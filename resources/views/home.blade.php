<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ប្រព័ន្ធគ្រប់គ្រងឯកសារ - Documentary System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Khmer', 'Khmer OS System', sans-serif;
        }
        .khmer-text {
            font-family: 'Noto Sans Khmer', 'Khmer OS System', Arial, sans-serif;
            line-height: 1.7;
        }

        /* Modal styles */
        .modal-overlay {
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            animation: slideUp 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card hover effects */
        .document-row:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .document-row {
            transition: all 0.2s ease-in-out;
        }

        /* Mobile table improvements */
        @media (max-width: 768px) {
            .mobile-card {
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 16px;
                margin-bottom: 16px;
                background: white;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .mobile-hide {
                display: none;
            }

            .mobile-show {
                display: block;
            }

            .modal-content {
                max-height: 85vh;
                margin: 10px;
                width: calc(100% - 20px);
            }
        }

        /* Desktop table show */
        @media (min-width: 769px) {
            .mobile-show {
                display: none;
            }

            .mobile-hide {
                display: table;
            }
        }

        /* Responsive dropdown */
        .dropdown-menu {
            min-width: 200px;
        }

        @media (max-width: 640px) {
            .dropdown-menu {
                position: fixed !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                bottom: 20px !important;
                top: auto !important;
                right: auto !important;
                width: calc(100% - 40px);
                max-width: 320px;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50">
<div class="min-h-screen">
    <!-- Mobile-Responsive Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Title -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 khmer-text hidden sm:block">ប្រព័ន្ធគ្រប់គ្រងឯកសារ</h1>
                    <h1 class="text-base font-bold text-gray-900 khmer-text sm:hidden">ឯកសារ</h1>
                </div>

                <!-- Right side navigation -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <!-- Current time - Hidden on mobile -->
                    <div class="hidden lg:flex items-center text-sm text-gray-500 khmer-text">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        2025-06-07 14:20:57
                    </div>

                    @auth
                        <!-- User greeting - Abbreviated on mobile -->
                        <span class="text-gray-700 khmer-text text-sm sm:text-base">
                            <span class="hidden sm:inline">សួស្តី</span>
                        </span>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ url('/admin') }}" class="bg-blue-600 text-white px-2 py-1 sm:px-4 sm:py-2 rounded-lg hover:bg-blue-700 transition-colors khmer-text text-sm">
                                <i class="fas fa-cog mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">គ្រប់គ្រង</span>
                                <span class="sm:hidden">គ្រប់គ្រង</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900 khmer-text text-sm">
                                <i class="fas fa-sign-out-alt mr-1 sm:mr-2"></i>
                                <span class="hidden sm:inline">ចាកចេញ</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors khmer-text text-sm">
                            <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">ចូលប្រើប្រាស់</span>
                            <span class="sm:hidden">ចូល</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <!-- Quick Stats - Responsive Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
            <div class="bg-white rounded-lg shadow p-3 sm:p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $documents->total() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 khmer-text">ឯកសារសរុប</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 bg-green-100 rounded-lg">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $documents->where('type', 'លិខិតចូល')->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 khmer-text">លិខិតចូល</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $documents->where('type', 'លិខិតចេញ')->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 khmer-text">លិខិតចេញ</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 sm:p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 bg-purple-100 rounded-lg">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-sm sm:text-lg font-bold text-gray-900 khmer-text">Darachhat</p>
                        <p class="text-xs sm:text-sm text-gray-500 khmer-text">អ្នកប្រើប្រាស់</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Filters -->
        <div class="bg-white shadow-lg rounded-lg mb-4 sm:mb-6 border border-gray-200">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 khmer-text flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                    </svg>
                    តម្រងស្វែងរក
                </h2>
            </div>
            <div class="px-4 sm:px-6 py-4">
                <form method="GET" action="{{ route('home') }}" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-6 sm:gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 khmer-text">ចាប់ពីថ្ងៃទី</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 khmer-text">ដល់ថ្ងៃទី</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 khmer-text">ប្រភេទ</label>
                        <select name="type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 khmer-text">
                            <option value="">ទាំងអស់</option>
                            <option value="លិខិតចេញ" {{ request('type') == 'លិខិតចេញ' ? 'selected' : '' }}>📤 លិខិតចេញ</option>
                            <option value="លិខិតចូល" {{ request('type') == 'លិខិតចូល' ? 'selected' : '' }}>📥 លិខិតចូល</option>
                        </select>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 khmer-text">ប្រភពឯកសារ</label>
                        <input type="text" name="source_file" value="{{ request('source_file') }}" placeholder="ស្វែងរកប្រភពឯកសារ..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 khmer-text">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1 khmer-text">លេខឯកសារ</label>
                        <input type="text" name="number" value="{{ request('number') }}" placeholder="ស្វែងរកលេខឯកសារ..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 khmer-text">
                    </div>
                    <div class="sm:col-span-1 sm:flex sm:items-end sm:space-x-2">
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors khmer-text text-sm mb-2 sm:mb-0">
                            <i class="fas fa-search mr-2"></i>ស្វែងរក
                        </button>
                        <a href="{{ route('home') }}" class="w-full sm:w-auto bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors khmer-text text-sm text-center block">
                            <i class="fas fa-times mr-2"></i>សម្អាត
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center bg-gradient-to-r from-gray-50 to-slate-50 space-y-2 sm:space-y-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 khmer-text flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    បញ្ជីឯកសារ ({{ $documents->total() }})
                </h2>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/admin/documents/create') }}" class="w-full sm:w-auto bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors khmer-text text-sm text-center">
                            <i class="fas fa-plus mr-2"></i>បន្ថែមឯកសារ
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Desktop Table View -->
            <div class="overflow-x-auto mobile-hide">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">ប្រភេទ</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">លេខរាង</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text hidden lg:table-cell">អត្តលេខលិខិត</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">កាលបរិច្ឆេទ</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text hidden xl:table-cell">ប្រភពឯកសារ</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">ឯកសារ</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text hidden lg:table-cell">ការពិពណ៌នា</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">សកម្មភាព</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $document)
                        <tr class="document-row">
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full khmer-text {{ $document->type == 'លិខិតចេញ' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                                    {{ $document->type == 'លិខិតចេញ' ? '📤' : '📥' }}
                                    <span class="hidden sm:inline">{{ $document->type }}</span>
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $document->number }}</td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 hidden lg:table-cell">
                                {{ $document->second_number ?? '-' }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $document->date->format('d/m/Y') }}</td>
                            <td class="px-3 sm:px-6 py-4 text-sm text-gray-600 khmer-text max-w-xs truncate hidden xl:table-cell">{{ $document->source_file }}</td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                    <i class="fas fa-paperclip mr-1"></i>{{ count($document->files) }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-sm text-gray-500 max-w-xs truncate khmer-text hidden lg:table-cell">{{ $document->description ?? 'មិនមាន' }}</td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-1 sm:space-x-3">
                                    <!-- View Details Button -->
                                    <button onclick="showDocumentDetails({{ $document->id }})" class="text-blue-600 hover:text-blue-900 khmer-text bg-blue-50 px-2 py-1 rounded-lg hover:bg-blue-100 transition-colors text-xs sm:text-sm">
                                        <i class="fas fa-eye mr-1"></i> <span class="hidden sm:inline">មើល</span>
                                    </button>

                                    <!-- Download Files Dropdown -->
                                    @if(count($document->files) > 0)
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown({{ $document->id }})" class="text-green-600 hover:text-green-900 khmer-text bg-green-50 px-2 py-1 rounded-lg hover:bg-green-100 transition-colors text-xs sm:text-sm">
                                                <i class="fas fa-download mr-1"></i> <span class="hidden sm:inline">ទាញយក</span>
                                                <i class="fas fa-chevron-down ml-1"></i>
                                            </button>
                                            <div id="dropdown-{{ $document->id }}" class="hidden absolute right-0 z-50 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 dropdown-menu">
                                                <div class="py-1">
                                                    @foreach($document->files as $index => $file)
                                                        <a href="{{ route('document.download', [$document, $index]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 khmer-text">
                                                            <i class="fas fa-file mr-2"></i>ឯកសារ {{ $index + 1 }}
                                                        </a>
                                                    @endforeach
                                                    @if(count($document->files) > 1)
                                                        <div class="border-t border-gray-100"></div>
                                                        <a href="{{ route('document.download.all', $document) }}" class="block px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 khmer-text font-medium">
                                                            <i class="fas fa-download mr-2"></i>ទាញយកទាំងអស់
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ url('/admin/documents/' . $document->id . '/edit') }}" class="text-amber-600 hover:text-amber-900 khmer-text bg-amber-50 px-2 py-1 rounded-lg hover:bg-amber-100 transition-colors text-xs sm:text-sm">
                                                <i class="fas fa-edit mr-1"></i> <span class="hidden sm:inline">កែប្រែ</span>
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2 khmer-text">មិនមានឯកសារទេ</h3>
                                    <p class="text-gray-500 khmer-text">សូមព្យាយាមប្រើតម្រងផ្សេងទៀត ឬបន្ថែមឯកសារថ្មី</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-show p-4">
                @forelse($documents as $document)
                    <div class="mobile-card">
                        <!-- Header with type and actions -->
                        <div class="flex justify-between items-start mb-3">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full khmer-text {{ $document->type == 'លិខិតចេញ' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                                {{ $document->type == 'លិខិតចេញ' ? '📤' : '📥' }} {{ $document->type }}
                            </span>
                            <div class="flex space-x-2">
                                <button onclick="showDocumentDetails({{ $document->id }})" class="text-blue-600 bg-blue-50 px-2 py-1 rounded text-xs">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(count($document->files) > 0)
                                    <button onclick="toggleDropdown({{ $document->id }})" class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs">
                                        <i class="fas fa-download"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Document info -->
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 khmer-text">លេខរាង:</span>
                                <span class="text-sm font-bold text-blue-600">{{ $document->number }}</span>
                            </div>
                            @if($document->second_number)
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-600 khmer-text">អត្តលេខ:</span>
                                    <span class="text-sm font-semibold text-green-600">{{ $document->second_number }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 khmer-text">កាលបរិច្ឆេទ:</span>
                                <span class="text-sm text-gray-900">{{ $document->date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600 khmer-text">ឯកសារ:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-paperclip mr-1"></i>{{ count($document->files) }}
                                </span>
                            </div>
                        </div>

                        <!-- Source file -->
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <span class="text-xs font-medium text-gray-600 khmer-text">ប្រភពឯកសារ:</span>
                            <p class="text-sm text-gray-800 khmer-text mt-1">{{ $document->source_file }}</p>
                        </div>

                        <!-- Download dropdown for mobile -->
                        @if(count($document->files) > 0)
                            <div id="dropdown-{{ $document->id }}" class="hidden mt-3 pt-3 border-t border-gray-200 dropdown-menu">
                                <div class="space-y-2">
                                    @foreach($document->files as $index => $file)
                                        <a href="{{ route('document.download', [$document, $index]) }}" class="block w-full text-left px-3 py-2 text-sm bg-gray-50 text-gray-700 rounded khmer-text">
                                            <i class="fas fa-file mr-2"></i>ឯកសារ {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                    @if(count($document->files) > 1)
                                        <a href="{{ route('document.download.all', $document) }}" class="block w-full text-left px-3 py-2 text-sm bg-blue-50 text-blue-700 rounded khmer-text font-medium">
                                            <i class="fas fa-download mr-2"></i>ទាញយកទាំងអស់
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2 khmer-text">មិនមានឯកសារទេ</h3>
                            <p class="text-gray-500 khmer-text">សូមព្យាយាមប្រើតម្រងផ្សេងទៀត ឬបន្ថែមឯកសារថ្មី</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $documents->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Responsive Document Details Modal -->
@foreach($documents as $document)
    <div id="modal-{{ $document->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden modal-overlay z-50">
        <div class="relative top-4 sm:top-10 mx-auto p-4 sm:p-5 border w-11/12 sm:w-3/4 lg:w-2/3 xl:w-1/2 shadow-xl rounded-xl bg-white modal-content">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4 sm:mb-6 pb-4 border-b border-gray-200">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 khmer-text flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="hidden sm:inline">ព័ត៌មានលម្អិតឯកសារ</span>
                        <span class="sm:hidden">ឯកសារ</span>
                    </h3>
                    <button onclick="closeModal({{ $document->id }})" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg p-2 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="space-y-4 sm:space-y-6">
                    <!-- Basic Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-blue-50 rounded-lg p-3 sm:p-4 border border-blue-200">
                                <div class="flex items-center mb-2">
                                    <span class="inline-flex px-2 sm:px-3 py-1 text-xs font-semibold rounded-full khmer-text {{ $document->type == 'លិខិតចេញ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $document->type == 'លិខិតចេញ' ? '📤' : '📥' }} {{ $document->type }}
                                    </span>
                                </div>
                                <div class="khmer-text text-xs sm:text-sm text-gray-600">ប្រភេទឯកសារ</div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                <div class="text-base sm:text-lg font-bold text-blue-600 mb-1">{{ $document->number }}</div>
                                <div class="khmer-text text-xs sm:text-sm text-gray-600">លេខរាងឯកសារ</div>
                            </div>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                <div class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ $document->date->format('d/m/Y') }}</div>
                                <div class="khmer-text text-xs sm:text-sm text-gray-600">កាលបរិច្ឆេទឯកសារ</div>
                            </div>

                            @if($document->second_number)
                                <div class="bg-green-50 rounded-lg p-3 sm:p-4 border border-green-200">
                                    <div class="text-base sm:text-lg font-bold text-green-600 mb-1">{{ $document->second_number }}</div>
                                    <div class="khmer-text text-xs sm:text-sm text-gray-600">អត្តលេខលិខិត</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Source File -->
                    <div class="bg-orange-50 rounded-lg p-3 sm:p-4 border border-orange-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h1m-1-4h1m4 4h1m-1-4h1"></path>
                            </svg>
                            <strong class="khmer-text text-gray-900 text-sm sm:text-base">ប្រភពឯកសារ:</strong>
                        </div>
                        <div class="khmer-text text-gray-800 font-medium text-sm sm:text-base">{{ $document->source_file }}</div>
                    </div>

                    <!-- Description -->
                    @if($document->description)
                        <div class="bg-blue-50 rounded-lg p-3 sm:p-4 border border-blue-200">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <strong class="khmer-text text-gray-900 text-sm sm:text-base">ការពិពណ៌នា:</strong>
                            </div>
                            <div class="khmer-text text-gray-800 leading-relaxed text-sm sm:text-base">{{ $document->description }}</div>
                        </div>
                    @endif

                    <!-- Other Notes -->
                    @if($document->other)
                        <div class="bg-amber-50 rounded-lg p-3 sm:p-4 border border-amber-200">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <strong class="khmer-text text-gray-900 text-sm sm:text-base">កំណត់ចំណាំ:</strong>
                            </div>
                            <div class="khmer-text text-gray-800 leading-relaxed text-sm sm:text-base">{{ $document->other }}</div>
                        </div>
                    @endif

                    <!-- Files Section -->
                    <div class="bg-purple-50 rounded-lg p-3 sm:p-4 border border-purple-200">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <strong class="khmer-text text-gray-900 text-sm sm:text-base">ឯកសារភ្ជាប់:</strong>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ count($document->files) }} ឯកសារ
                            </span>
                        </div>

                        @if(count($document->files) > 0)
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($document->files as $index => $file)
                                    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <div class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg">
                                                    <span class="text-xs font-bold text-blue-600">{{ $index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">ឯកសារ {{ $index + 1 }}</div>
                                                    <div class="text-xs text-gray-500 hidden sm:block">{{ $document->generateDownloadFileName($file, $index) }}</div>
                                                </div>
                                            </div>
                                            <a href="{{ route('document.download', [$document, $index]) }}"
                                               class="text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-2 py-1 rounded transition-colors">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if(count($document->files) > 1)
                                <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-purple-200">
                                    <a href="{{ route('document.download.all', $document) }}"
                                       class="inline-flex items-center px-3 sm:px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors w-full sm:w-auto justify-center">
                                        <i class="fas fa-download mr-2"></i>
                                        <span class="khmer-text">ទាញយកទាំងអស់</span>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 khmer-text text-sm">មិនមានឯកសារភ្ជាប់</p>
                            </div>
                        @endif
                    </div>

                    <!-- Metadata -->
                    <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm">
                            <div>
                                <div class="text-gray-500 khmer-text mb-1">បង្កើតនៅ:</div>
                                <div class="font-medium text-gray-900">{{ $document->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 khmer-text mb-1">កែប្រែចុងក្រោយ:</div>
                                <div class="font-medium text-gray-900">{{ $document->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    // All JavaScript functions remain the same but now work with responsive design
    function showDocumentDetails(documentId) {
        const modal = document.getElementById(`modal-${documentId}`);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(documentId) {
        const modal = document.getElementById(`modal-${documentId}`);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleDropdown(documentId) {
        const dropdown = document.getElementById(`dropdown-${documentId}`);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }

        // Close other dropdowns
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            if (el.id !== `dropdown-${documentId}`) {
                el.classList.add('hidden');
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('button')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });

    // Close modals when clicking outside
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                const documentId = this.id.replace('modal-', '');
                closeModal(documentId);
            }
        });
    });

    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    const documentId = modal.id.replace('modal-', '');
                    closeModal(documentId);
                }
            });
        }
    });

    // Mobile-specific optimizations
    if (window.innerWidth <= 768) {
        // Adjust modal positioning for mobile
        document.querySelectorAll('.modal-content').forEach(modal => {
            modal.style.maxHeight = '85vh';
        });
    }

    console.log('📱 Responsive home page loaded successfully ');
    console.log('📊 Total documents loaded: {{ $documents->count() }}');
    console.log('📱 Device: ' + (window.innerWidth <= 768 ? 'Mobile' : 'Desktop'));
</script>
</body>
</html>
