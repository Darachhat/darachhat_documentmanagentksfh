<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    /**
     * Download single file with custom naming
     */
    public function downloadSingle(Document $document, $index)
    {
        try {
            // Check if file index exists
            if (!isset($document->files[$index])) {
                abort(404, 'File not found');
            }

            $file = $document->files[$index];

            // Check if file exists in storage
            if (!Storage::disk('public')->exists($file)) {
                abort(404, 'File not found in storage');
            }

            // Generate custom filename
            $customFileName = $document->generateDownloadFileName($file, $index);

            // Return download response with custom filename
            return Storage::disk('public')->download($file, $customFileName);

        } catch (\Exception $e) {
            \Log::error("Download error for document {$document->id}, file index {$index}: " . $e->getMessage());
            abort(500, 'Download failed');
        }
    }

    /**
     * Download all files as ZIP
     */
    public function downloadAll(Document $document)
    {
        try {
            if (!$document->hasValidFiles()) {
                abort(404, 'No valid files found');
            }

            return $document->downloadAllFilesAsZip();

        } catch (\Exception $e) {
            \Log::error("Download all error for document {$document->id}: " . $e->getMessage());
            abort(500, 'Download failed');
        }
    }

    /**
     * Download single file or all files based on count
     */
    public function download(Document $document)
    {
        try {
            if (!$document->hasValidFiles()) {
                abort(404, 'No valid files found');
            }

            // If only one file, download it directly
            if (count($document->files) === 1) {
                return $this->downloadSingle($document, 0);
            }

            // If multiple files, download as ZIP
            return $this->downloadAll($document);

        } catch (\Exception $e) {
            \Log::error("Download error for document {$document->id}: " . $e->getMessage());
            abort(500, 'Download failed');
        }
    }
}
