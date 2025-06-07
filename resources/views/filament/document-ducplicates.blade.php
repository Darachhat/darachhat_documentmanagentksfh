<div class="space-y-4">
    <!-- Current Document -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="font-semibold text-blue-900 khmer-text">ឯកសារបច្ចុប្បន្ន</h3>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-blue-600 font-medium">លេខរាង:</span> {{ $current->number }}
            </div>
            <div>
                <span class="text-blue-600 font-medium">កាលបរិច្ឆេទ:</span> {{ $current->date->format('d/m/Y') }}
            </div>
            <div>
                <span class="text-blue-600 font-medium">ឆ្នាំ:</span> {{ $current->date->year }}
            </div>
            <div>
                <span class="text-blue-600 font-medium">ប្រភេទ:</span> {{ $current->type }}
            </div>
        </div>
    </div>

    <!-- Other Documents with Same Number -->
    <div>
        <h4 class="font-semibold text-gray-900 mb-3 khmer-text">ឯកសារផ្សេងទៀតដែលមានលេខដូចគ្នា ({{ $duplicates->count() }})</h4>
        <div class="space-y-3">
            @foreach($duplicates as $duplicate)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="grid grid-cols-2 gap-4 text-sm flex-1">
                            <div>
                                <span class="text-gray-600 font-medium">កាលបរិច្ឆេទ:</span>
                                <span class="font-semibold">{{ $duplicate->date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">ឆ្នាំ:</span>
                                <span class="font-semibold text-purple-600">{{ $duplicate->date->year }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">ប្រភេទ:</span>
                                <span class="inline-block px-2 py-1 rounded-full text-xs {{ $duplicate->type === 'លិខិតចេញ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $duplicate->type }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600 font-medium">អត្តលេខ:</span>
                                <span class="font-medium">{{ $duplicate->second_number ?? 'មិនមាន' }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="/admin/documents/{{ $duplicate->id }}/edit"
                               class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                មើល
                            </a>
                        </div>
                    </div>

                    @if($duplicate->source_file)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-gray-600 font-medium text-sm khmer-text">ប្រភពឯកសារ:</span>
                            <p class="text-sm text-gray-800 mt-1 khmer-text">{{ Str::limit($duplicate->source_file, 80) }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Summary -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h5 class="font-medium text-yellow-900 mb-1 khmer-text">ចំណាំ:</h5>
                <p class="text-sm text-yellow-800 khmer-text">
                    លេខឯកសារ "{{ $current->number }}" មានប្រើក្នុងឆ្នាំផ្សេងៗគ្នា។
                    នេះជាការអនុញ្ញាតបាន ដោយសារតែឆ្នាំមិនដូចគ្នា។
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .khmer-text {
        font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
        line-height: 1.6;
    }
</style>
