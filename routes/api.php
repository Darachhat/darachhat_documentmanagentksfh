<?php

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/documents/{document}', function (Document $document) {
    return response()->json([
        'id' => $document->id,
        'type' => $document->type,
        'number' => $document->number,
        'second_number' => $document->second_number,
        'date' => $document->date->format('d/m/Y'),
        'source_file' => $document->source_file,
        'files' => $document->files,
        'description' => $document->description,
        'other' => $document->other,
    ]);
});
