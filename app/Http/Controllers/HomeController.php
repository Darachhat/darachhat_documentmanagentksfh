<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('source_file')) {
            $query->where('source_file', 'like', '%' . $request->source_file . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'like', '%' . $request->number . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $documents = $query->orderBy('date', 'desc')->paginate(15);

        return view('home', compact('documents'));
    }

    public function show(Document $document)
    {
        return view('document-details', compact('document'));
    }

    public function download(Document $document, $fileIndex = 0)
    {
        if (!isset($document->files[$fileIndex])) {
            abort(404, 'File not found');
        }

        $filePath = $document->files[$fileIndex];

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found in storage');
        }

        // Generate custom filename
        $customFileName = $document->generateDownloadFileName($filePath, $fileIndex);

        return Storage::disk('public')->download($filePath, $customFileName);
    }
}
