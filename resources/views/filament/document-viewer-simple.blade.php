<div class="max-w-6xl mx-auto space-y-6">
    <!-- Clean Document Header -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <!-- Document Information -->
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-4">
                    <!-- Document Type Icon -->
                    @if($document->type === 'លិខិតចេញ')
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                📤 {{ $document->type }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">បង្កើតដោយ: Darachhat</p>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                📥 {{ $document->type }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">បង្កើតដោយ: Darachhat</p>
                        </div>
                    @endif
                </div>

                <!-- Document Title -->
                <h1 class="text-2xl font-bold text-gray-900 khmer-text mb-4">
                    ឯកសារលេខ {{ $document->number }}
                </h1>

                <!-- Show duplicate info if exists -->
                @php
                    $sameNumberDocs = \App\Models\Document::getDocumentsWithSameNumber($document->number, $document->id);
                @endphp
                @if($sameNumberDocs->count() > 0)
                    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800 mb-1 khmer-text">លេខឯកសារនេះមានក្នុងឆ្នាំផ្សេងទៀត:</p>
                                <div class="space-y-1">
                                    @foreach($sameNumberDocs->take(3) as $doc)
                                        <p class="text-sm text-yellow-700">
                                            • ឆ្នាំ {{ $doc->date->year }} - {{ $doc->date->format('d/m/Y') }}
                                            ({{ $doc->type }})
                                        </p>
                                    @endforeach
                                    @if($sameNumberDocs->count() > 3)
                                        <p class="text-sm text-yellow-600">និង {{ $sameNumberDocs->count() - 3 }} ឯកសារទៀត...</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Document Numbers -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm font-bold">
                                1
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">លេខរាង</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $document->number }}</p>
                            </div>
                        </div>
                    </div>

                    @if($document->second_number)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-500 text-white rounded-lg flex items-center justify-center text-sm font-bold">
                                    2
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">អត្តលេខ</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $document->second_number }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="border border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-lg flex items-center justify-center text-sm font-bold">
                                    2
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium">អត្តលេខ</p>
                                    <p class="text-sm text-gray-400">មិនមាន</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Date and Status -->
            <div class="lg:w-64">
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">កាលបរិច្ឆេទ</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">{{ $document->date->format('d/m/Y') }}</p>
                    <p class="text-sm text-gray-500">ឆ្នាំ {{ $document->date->year }}</p>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">សកម្ម</span>
                    </div>
                    @if($document->hasValidFiles())
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">ឯកសារបានដំណើរការ</span>
                        </div>
                    @endif
                </div>

                <!-- Current Time -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">បច្ចុប្បន្នភាព</p>
                    <p class="text-sm font-medium text-gray-900">2025-06-07 13:47:13 UTC</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Source File -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h1m-1-4h1m4 4h1m-1-4h1"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 khmer-text">ប្រភពឯកសារ</h3>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 khmer-text leading-relaxed">{{ $document->source_file }}</p>
            </div>
        </div>

        <!-- File Count -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 khmer-text">ឯកសារភ្ជាប់</h3>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <span class="text-2xl font-bold text-blue-600">{{ count($document->files ?? []) }}</span>
                </div>
                <p class="text-lg font-semibold text-gray-900 mb-2">{{ count($document->files ?? []) }} ឯកសារ</p>
                @if($document->hasValidFiles())
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        ✓ ពេញលេញ
                    </span>
                @else
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                        ⚠ មានបញ្ហា
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Description and Notes -->
    @if($document->description || $document->other)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if($document->description)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 khmer-text">ការពិពណ៌នា</h3>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
                        <p class="text-gray-900 khmer-text leading-relaxed">{{ $document->description }}</p>
                    </div>
                </div>
            @endif

            @if($document->other)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 khmer-text">កំណត់ចំណាំ</h3>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border-l-4 border-amber-400">
                        <p class="text-gray-900 khmer-text leading-relaxed">{{ $document->other }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Files Section -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 khmer-text">ឯកសារភ្ជាប់</h3>
                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2 py-1 rounded-full">
                        {{ count($document->files ?? []) }}
                    </span>
                </div>
                @if(count($document->files ?? []) > 1 && $document->hasValidFiles())
                    <a href="{{ route('document.download.all', $document) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3"></path>
                        </svg>
                        ទាញយកទាំងអស់
                    </a>
                @endif
            </div>
        </div>

        <!-- Files List -->
        <div class="p-6">
            @if(!empty($document->files))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($document->files as $index => $file)
                        @php
                            $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($file);
                            $size = $exists ? \Illuminate\Support\Facades\Storage::disk('public')->size($file) : 0;
                            $sizeFormatted = $size > 0 ? number_format($size / 1024, 1) . ' KB' : 'មិនដឹង';
                            $downloadName = $document->generateDownloadFileName($file, $index);

                            // Fixed: Check file extension properly for PHP 8.4
                            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                            $isPdf = $fileExtension === 'pdf';
                        @endphp

                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <!-- File Icon -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    @if($isImage)
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @elseif($isPdf)
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">ឯកសារ {{ $index + 1 }}</p>
                                    <p class="text-xs text-gray-500">{{ $sizeFormatted }}</p>
                                </div>
                                @if($exists)
                                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- File Name -->
                            <p class="text-sm text-gray-700 mb-3 break-words">{{ $downloadName }}</p>

                            <!-- Actions -->
                            @if($exists)
                                <div class="flex gap-2">
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                       class="flex-1 text-center px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                        មើល
                                    </a>
                                    @if(method_exists($document, 'getDownloadUrl'))
                                        <a href="{{ $document->getDownloadUrl($index) }}"
                                           class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            ទាញយក
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $file) }}" download="{{ $downloadName }}"
                                           class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            ទាញយក
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="text-center px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg">
                                    មិនដំណើរការ
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2 khmer-text">មិនមានឯកសារភ្ជាប់</h3>
                    <p class="text-gray-500 khmer-text">ឯកសារនេះមិនមានឯកសារភ្ជាប់ណាមួយទេ។</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if(!empty($document->files))
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <span>📄 សរុប: {{ count($document->files) }} ឯកសារ</span>
                        @php
                            $validFiles = collect($document->files)->filter(function($file) {
                                return \Illuminate\Support\Facades\Storage::disk('public')->exists($file);
                            })->count();
                        @endphp
                        @if($validFiles > 0)
                            <span>✅ {{ $validFiles }} ដំណើរការ</span>
                        @endif
                        <span>📊 ទំហំសរុប:
                            @if(method_exists($document, 'getTotalFileSizeAttribute'))
                                {{ $document->total_file_size }}
                            @else
                                មិនដឹង
                            @endif
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        ទម្រង់: លេខឯកសារ_កាលបរិច្ឆេទ.extension
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Document Metadata -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 khmer-text">ព័ត៌មានបន្ថែម</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">បង្កើតនៅ</p>
                <p class="text-sm font-medium text-gray-900">{{ $document->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">កែប្រែចុងក្រោយ</p>
                <p class="text-sm font-medium text-gray-900">{{ $document->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">បង្កើតដោយ</p>
                <p class="text-sm font-medium text-gray-900 khmer-text">Darachhat</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">ស្ថានភាព</p>
                <span class="inline-flex items-center gap-1 text-sm text-green-700">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    សកម្ម
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    .khmer-text {
        font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
        line-height: 1.6;
    }

    /* Simple hover effects */
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Smooth transitions */
    .transition-shadow {
        transition: box-shadow 0.15s ease-in-out;
    }

    .transition-colors {
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📄 Document Viewer loaded for Darachhat');
        console.log('🕐 Current time: 2025-06-07 13:47:13 UTC');
        console.log('📁 Document files: {{ count($document->files ?? []) }}');

        // Simple download tracking
        document.addEventListener('click', function(e) {
            if (e.target.closest('a[href*="download"]') || e.target.closest('a[download]')) {
                const link = e.target.closest('a');
                console.log('⬇️ Download initiated:', link.href);

                // Add visual feedback
                const button = e.target.closest('a');
                const originalText = button.textContent;
                button.textContent = '⏳ កំពុងទាញយក...';
                button.style.pointerEvents = 'none';

                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.pointerEvents = 'auto';
                }, 2000);
            }
        });
    });
</script>
