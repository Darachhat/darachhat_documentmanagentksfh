<div class="space-y-6">
    <!-- Document Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                @if($document->type === 'លិខិតចេញ')
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                @else
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h3 class="text-xl font-bold text-gray-900 khmer-text">{{ $document->type }}</h3>
                    <div class="flex space-x-2 text-sm text-gray-500">
                        <span>លេខទី១: {{ $document->number }}</span>
                        @if($document->second_number)
                            <span>•</span>
                            <span>លេខទី២: {{ $document->second_number }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">កាលបរិច្ឆេទ</p>
                <p class="font-semibold text-gray-900">{{ $document->date->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- File Status Check -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center mb-3">
            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h4 class="font-semibold text-gray-900">ឯកសារភ្ជាប់</h4>
        </div>

        <div class="space-y-3">
            @forelse($document->file_info as $index => $fileInfo)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($fileInfo['exists'])
                                <span class="text-green-500">✅</span>
                            @else
                                <span class="text-red-500">❌</span>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $fileInfo['name'] }}</p>
                                <p class="text-sm text-gray-600">
                                    ទំហំ: {{ $fileInfo['size'] }} •
                                    ប្រភេទ: {{ $fileInfo['mime_type'] }} •
                                    ស្ថានភាព: {{ $fileInfo['exists'] ? 'ដំណើរការបាន' : 'រកមិនឃើញ' }}
                                </p>
                            </div>
                        </div>
                        @if($fileInfo['exists'] && $fileInfo['url'])
                            <div class="flex space-x-2">
                                <a href="{{ $fileInfo['url'] }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    មើល
                                </a>
                                <a href="{{ $fileInfo['url'] }}" download
                                   class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    ទាញយក
                                </a>
                            </div>
                        @else
                            <span class="text-red-600 text-sm font-medium">ឯកសារមិនដំណើរការ</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">មិនមានឯកសារភ្ជាប់</p>
            @endforelse
        </div>

        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">
                <strong>ព័ត៌មានសរុប:</strong>
                {{ count($document->files) }} ឯកសារ •
                ទំហំសរុប: {{ $document->total_file_size }} •
                ស្ថានភាព: {{ $document->hasValidFiles() ? '✅ ឯកសារទាំងអស់ដំណើរការបាន' : '⚠️ មានឯកសារខ្លះមិនដំណើរការ' }}
            </p>
        </div>
    </div>

    <!-- Document Details -->
    @if($document->description || $document->other)
        <div class="grid grid-cols-1 gap-6">
            @if($document->description)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">ការពិពណ៌នាអំពីឯកសារ</h4>
                    <p class="text-gray-700 leading-relaxed khmer-text">{{ $document->description }}</p>
                </div>
            @endif

            @if($document->other)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">កំណត់ចំណាំផ្សេងៗ</h4>
                    <p class="text-gray-700 leading-relaxed khmer-text">{{ $document->other }}</p>
                </div>
            @endif
        </div>
    @endif
</div>

<style>
    .khmer-text {
        font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
    }
</style>
