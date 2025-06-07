<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span class="khmer-text">សកម្មភាពលឿន</span>
            </div>
        </x-slot>

        <div class="space-y-4">
            @if($canCreateDocuments)
                <a href="{{ route('filament.admin.resources.documents.create') }}"
                   class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-lg mr-4 group-hover:bg-blue-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 khmer-text">បង្កើតឯកសារថ្មី</h3>
                        <p class="text-sm text-gray-600 khmer-text">បន្ថែមឯកសារថ្មីចូលក្នុងប្រព័ន្ធ</p>
                    </div>
                </a>
            @endif

            <a href="{{ route('filament.admin.resources.documents.index') }}"
               class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors group">
                <div class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-lg mr-4 group-hover:bg-green-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 khmer-text">មើលឯកសារទាំងអស់</h3>
                    <p class="text-sm text-gray-600 khmer-text">រកមើលនិងគ្រប់គ្រងឯកសារ</p>
                </div>
            </a>

            @if($canManageUsers)
                <a href="{{ route('filament.admin.resources.users.index') }}"
                   class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors group">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-500 rounded-lg mr-4 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 khmer-text">គ្រប់គ្រងអ្នកប្រើប្រាស់</h3>
                        <p class="text-sm text-gray-600 khmer-text">បន្ថែម កែប្រែ និងគ្រប់គ្រងអ្នកប្រើប្រាស់</p>
                    </div>
                </a>
            @endif

            <a href="{{ route('home') }}"
               class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg border border-orange-200 transition-colors group">
                <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-lg mr-4 group-hover:bg-orange-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 khmer-text">ទៅកាន់គេហទំព័រ</h3>
                    <p class="text-sm text-gray-600 khmer-text">មើលគេហទំព័រសាធារណៈ</p>
                </div>
            </a>
        </div>
    </x-filament::section>

    <style>
        .khmer-text {
            font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
        }
    </style>
</x-filament-widgets::widget>
