<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold khmer-text">សូមស្វាគមន៍ {{ auth()->user()->name }}!</h1>
                    <p class="text-blue-100 mt-2 khmer-text">
                        {{ now()->format('l, F j, Y') }} • {{ now()->format('H:i') }}
                    </p>
                    <p class="text-blue-100 khmer-text">
                        ប្រព័ន្ធគ្រប់គ្រងឯកសារ - ការគ្រប់គ្រងឯកសារប្រកបដោយប្រសិទ្ធភាព
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        {{ $this->getHeaderWidgetsSection() }}

        <!-- Main Widgets Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($this->getWidgets() as $widget)
                @livewire($widget)
            @endforeach
        </div>
    </div>

    <style>
        .khmer-text {
            font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
        }
    </style>
</x-filament-panels::page>
