<?php

namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixDocumentFiles extends Command
{
    protected $signature = 'documents:fix-files {--dry-run : Run without making changes}';

    protected $description = 'Fix document file issues and clean up orphaned files';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        $this->info('🔍 Scanning documents for file issues...');

        $documents = Document::all();
        $issueCount = 0;
        $fixedCount = 0;

        foreach ($documents as $document) {
            $this->line("📄 Checking document #{$document->id} - {$document->number}");

            $validFiles = [];
            $hasIssues = false;

            foreach ($document->files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    $validFiles[] = $file;
                    $this->line("  ✅ {$file} - OK");
                } else {
                    $hasIssues = true;
                    $issueCount++;
                    $this->error("  ❌ {$file} - NOT FOUND");
                }
            }

            if ($hasIssues && !$isDryRun) {
                $document->update(['files' => $validFiles]);
                $fixedCount++;
                $this->info("  🔧 Fixed document #{$document->id}");
            }
        }

        // Clean up orphaned files
        $this->info('🧹 Checking for orphaned files...');
        $allStoredFiles = Storage::disk('public')->files('documents');
        $referencedFiles = Document::pluck('files')->flatten()->toArray();

        $orphanedFiles = array_diff($allStoredFiles, $referencedFiles);

        if (!empty($orphanedFiles)) {
            $this->warn('Found ' . count($orphanedFiles) . ' orphaned files:');
            foreach ($orphanedFiles as $orphanedFile) {
                $this->line("  🗑️ {$orphanedFile}");
                if (!$isDryRun) {
                    Storage::disk('public')->delete($orphanedFile);
                }
            }
        }

        if ($isDryRun) {
            $this->info('🔍 DRY RUN - No changes made');
            $this->info("Found {$issueCount} file issues that would be fixed");
        } else {
            $this->info("✅ Fixed {$fixedCount} documents with file issues");
            $this->info("🗑️ Cleaned up " . count($orphanedFiles) . " orphaned files");
        }

        return 0;
    }
}
