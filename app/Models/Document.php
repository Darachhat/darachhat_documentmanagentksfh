<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    const TYPE_OUTGOING = 'លិខិតចេញ';
    const TYPE_INCOMING = 'លិខិតចូល';

    protected $fillable = [
        'type',
        'number',
        'second_number',
        'date',
        'source_file',
        'files',
        'description',
        'other',
    ];

    protected $casts = [
        'date' => 'date',
        'files' => 'array',
    ];

    protected function files(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true) ?? [],
            set: fn ($value) => json_encode($value),
        );
    }

    // NEW: Check for duplicate number in the same year AND same type
    public static function isDuplicateNumberInSameYearAndType($number, $date, $type, $excludeId = null)
    {
        $year = \Carbon\Carbon::parse($date)->year;

        $query = self::where('number', $number)
            ->whereYear('date', $year)
            ->where('type', $type);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // UPDATED: Check for duplicate number in same year (any type) - for info only
    public static function isDuplicateNumberInSameYear($number, $date, $excludeId = null)
    {
        $year = \Carbon\Carbon::parse($date)->year;

        $query = self::where('number', $number)
            ->whereYear('date', $year);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // NEW: Get documents with same number and year but different type
    public static function getDocumentsWithSameNumberInYear($number, $year, $excludeId = null)
    {
        $query = self::where('number', $number)
            ->whereYear('date', $year);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    // Get all documents with the same number but different years
    public static function getDocumentsWithSameNumber($number, $excludeId = null)
    {
        $query = self::where('number', $number);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    // UPDATED: Get the validation error message for duplicates (same year + same type)
    public static function getDuplicateMessage($number, $date, $type)
    {
        $year = \Carbon\Carbon::parse($date)->year;
        $existingDocument = self::where('number', $number)
            ->whereYear('date', $year)
            ->where('type', $type)
            ->first();

        if ($existingDocument) {
            return "លេខឯកសារ '{$number}' មានរួចហើយក្នុងឆ្នាំ {$year} សម្រាប់ប្រភេទ '{$type}' (កាលបរិច្ឆេទ: {$existingDocument->date->format('d/m/Y')})។ សូមប្រើលេខផ្សេង។";
        }

        return null;
    }

    // NEW: Get info message for same number in same year but different type
    public static function getDifferentTypeMessage($number, $date, $type)
    {
        $year = \Carbon\Carbon::parse($date)->year;
        $otherType = $type === self::TYPE_OUTGOING ? self::TYPE_INCOMING : self::TYPE_OUTGOING;

        $existingDocument = self::where('number', $number)
            ->whereYear('date', $year)
            ->where('type', $otherType)
            ->first();

        if ($existingDocument) {
            return "លេខឯកសារ '{$number}' មានរួចហើយក្នុងឆ្នាំ {$year} សម្រាប់ប្រភេទ '{$otherType}' (កាលបរិច្ឆេទ: {$existingDocument->date->format('d/m/Y')})។ ប៉ុន្តែអនុញ្ញាតបានដោយសារប្រភេទខុសគ្នា។";
        }

        return null;
    }

    public function getFileUrlsAttribute()
    {
        return collect($this->files)->map(function ($file) {
            return asset('storage/' . $file);
        });
    }

    public function getFileInfoAttribute()
    {
        return collect($this->files)->map(function ($file, $index) {
            try {
                $exists = Storage::disk('public')->exists($file);
                $size = 0;
                $mimeType = 'unknown';

                if ($exists) {
                    try {
                        $size = Storage::disk('public')->size($file);
                        $mimeType = Storage::disk('public')->mimeType($file);
                    } catch (\Exception $e) {
                        \Log::warning("Could not get file details for: {$file}");
                    }
                }

                return [
                    'path' => $file,
                    'name' => basename($file),
                    'exists' => $exists,
                    'size' => $this->formatFileSize($size),
                    'size_bytes' => $size,
                    'mime_type' => $mimeType,
                    'url' => $exists ? asset('storage/' . $file) : null,
                    'download_name' => $this->generateDownloadFileName($file, $index),
                    'download_url' => $exists ? route('document.download.single', [$this->id, $index]) : null,
                ];
            } catch (\Exception $e) {
                \Log::warning("Error processing file: {$file}", ['error' => $e->getMessage()]);
                return [
                    'path' => $file,
                    'name' => basename($file),
                    'exists' => false,
                    'size' => 'Unknown',
                    'size_bytes' => 0,
                    'mime_type' => 'unknown',
                    'url' => null,
                    'download_name' => 'unknown_file',
                    'download_url' => null,
                ];
            }
        });
    }

    /**
     * Generate custom download filename: number_date.extension
     */
    public function generateDownloadFileName($originalFile, $index = 0)
    {
        // Clean the number (remove special characters)
        $cleanNumber = preg_replace('/[^a-zA-Z0-9]/', '_', $this->number);

        // Format date as YYYY-MM-DD
        $formattedDate = $this->date->format('Y-m-d');

        // Get file extension
        $extension = pathinfo($originalFile, PATHINFO_EXTENSION);

        // If multiple files, add index
        $suffix = count($this->files) > 1 ? '_' . ($index + 1) : '';

        // Combine: number_date_index.extension
        $fileName = "{$cleanNumber}_{$formattedDate}{$suffix}.{$extension}";

        return $fileName;
    }

    /**
     * Get download URL for single file
     */
    public function getDownloadUrl($index = 0)
    {
        if (!isset($this->files[$index])) {
            return null;
        }

        if (!Storage::disk('public')->exists($this->files[$index])) {
            return null;
        }

        return route('document.download.single', [$this->id, $index]);
    }

    /**
     * Get download URL for all files
     */
    public function getDownloadAllUrl()
    {
        if (!$this->hasValidFiles()) {
            return null;
        }

        return route('document.download.all', $this->id);
    }

    /**
     * Get main download URL (single file or ZIP)
     */
    public function getMainDownloadUrl()
    {
        if (!$this->hasValidFiles()) {
            return null;
        }

        return route('document.download', $this->id);
    }

    /**
     * Download all files as ZIP with custom naming
     */
    public function downloadAllFilesAsZip()
    {
        $zip = new \ZipArchive();
        $cleanNumber = preg_replace('/[^a-zA-Z0-9]/', '_', $this->number);
        $formattedDate = $this->date->format('Y-m-d');
        $zipFileName = "{$cleanNumber}_{$formattedDate}_files.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($this->files as $index => $file) {
                $filePath = storage_path("app/public/{$file}");
                if (file_exists($filePath)) {
                    $customFileName = $this->generateDownloadFileName($file, $index);
                    $zip->addFile($filePath, $customFileName);
                }
            }
            $zip->close();
            return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
        }
        throw new \Exception('Unable to create zip file');
    }

    private function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor(log($bytes, 1024));

        return sprintf('%.1f %s', $bytes / pow(1024, $factor), $units[$factor]);
    }

    public static function getTypeOptions(): array
    {
        return [
            self::TYPE_OUTGOING => self::TYPE_OUTGOING,
            self::TYPE_INCOMING => self::TYPE_INCOMING,
        ];
    }

    // Check if all files exist
    public function hasValidFiles(): bool
    {
        if (empty($this->files)) {
            return false;
        }

        return collect($this->files)->every(function ($file) {
            try {
                return Storage::disk('public')->exists($file);
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    // Get total size of all files
    public function getTotalFileSizeAttribute(): string
    {
        $totalBytes = collect($this->files)->sum(function ($file) {
            try {
                return Storage::disk('public')->exists($file)
                    ? Storage::disk('public')->size($file)
                    : 0;
            } catch (\Exception $e) {
                return 0;
            }
        });

        return $this->formatFileSize($totalBytes);
    }
}
