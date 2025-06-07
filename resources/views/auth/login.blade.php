<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចូលប្រើប្រាស់ - ប្រព័ន្ធគ្រប់គ្រងឯកសារ</title>
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

        /* Custom animations */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Background pattern */
        .bg-pattern {
            background-color: #f8fafc;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.1) 1px, transparent 0);
            background-size: 40px 40px;
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Floating animation */
        .float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Input focus effects */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Button hover effects */
        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        /* Custom scrollbar for mobile */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-pattern min-h-screen overflow-x-hidden">
<!-- Background decorative elements -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <!-- Top left circle -->
    <div class="absolute -top-20 -left-20 w-40 h-40 sm:w-80 sm:h-80 bg-blue-500 rounded-full opacity-10 float"></div>
    <!-- Bottom right circle -->
    <div class="absolute -bottom-20 -right-20 w-40 h-40 sm:w-80 sm:h-80 bg-indigo-500 rounded-full opacity-10 float" style="animation-delay: 1s;"></div>
    <!-- Center decoration -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-60 h-60 sm:w-96 sm:h-96 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full opacity-5 float" style="animation-delay: 2s;"></div>
</div>

<div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-md w-full space-y-8 fade-in">
        <!-- Logo and Header -->
        <div class="text-center slide-up">
            <!-- Logo -->
            <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl mb-6 float">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 khmer-text mb-2">
                ចូលប្រើប្រាស់
            </h1>
            <p class="text-base sm:text-lg text-gray-600 khmer-text mb-1">
                ប្រព័ន្ធគ្រប់គ្រងឯកសារ
            </p>

            <!-- Current time display -->
            <div class="mt-4 inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                2025-06-07
            </div>
        </div>

        <!-- Login Form -->
        <div class="glass rounded-2xl shadow-2xl p-6 sm:p-8 slide-up" style="animation-delay: 0.2s;">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Welcome Message -->
                <div class="text-center py-2">
                    <h2 class="text-lg font-semibold text-gray-800 khmer-text">
                        សូមស្វាគមន៍ Darachhat!
                    </h2>
                    <p class="text-sm text-gray-600 khmer-text mt-1">
                        សូមបញ្ចូលព័ត៌មានរបស់អ្នកដើម្បីចូលប្រើប្រាស់
                    </p>
                </div>

                <!-- Input Fields -->
                <div class="space-y-4">
                    <!-- Email/Phone Input -->
                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700 khmer-text mb-2">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            អ៊ីមែល ឬលេខទូរស័ព្ទ
                        </label>
                        <div class="relative">
                            <input
                                id="login"
                                name="login"
                                type="text"
                                required
                                class="input-glow appearance-none relative block w-full px-4 py-3 pl-12 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-white/80"
                                placeholder="darachhat@example.com ឬ 012345678"
                                value="{{ old('login') }}"
                                autocomplete="username">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 khmer-text mb-2">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>
                            លេខសំងាត់
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="input-glow appearance-none relative block w-full px-4 py-3 pl-12 pr-12 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-white/80"
                                placeholder="បញ្ចូលលេខសំងាត់របស់អ្នក"
                                autocomplete="current-password">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <!-- Toggle password visibility -->
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword()">
                                <svg id="eye-open" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-4 slide-up">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 khmer-text">មានបញ្ហាក្នុងការចូលប្រើប្រាស់</h3>
                                <ul class="mt-2 text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="khmer-text">• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors">
                        <label for="remember_me" class="ml-3 block text-sm text-gray-700 khmer-text">
                            ចងចាំខ្ញុំ
                        </label>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors khmer-text">
                            ភ្លេចលេខសំងាត់?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="btn-hover group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </span>
                        <span class="khmer-text">ចូលប្រើប្រាស់</span>
                    </button>
                </div>

                <!-- Alternative Login Options -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500 khmer-text">ឬ</span>
                        </div>
                    </div>

                    <!-- Demo Login Hint -->
                    <div class="mt-4 text-center">
                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                            <p class="text-sm text-blue-800 khmer-text font-medium mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                ព័ត៌មានសម្រាប់ទេស្ត៍
                            </p>
                            <div class="text-xs text-blue-700 space-y-1 khmer-text">
                                <p><strong>អ៊ីមែល:</strong> user@example.com</p>
                                <p><strong>លេខសំងាត់:</strong> 12345678</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center slide-up" style="animation-delay: 0.4s;">
            <div class="space-y-2">
                <p class="text-sm text-gray-500 khmer-text">
                    បង្កើតដោយ Darachhat សម្រាប់ការគ្រប់គ្រងឯកសារ
                </p>
                <p class="text-xs text-gray-400">
                    © 2025 Documentary Management System. All rights reserved.
                </p>
                <div class="flex justify-center space-x-4 text-gray-400">
                    <a href="https://www.facebook.com/Darachhat6" class="hover:text-blue-500 transition-colors" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://t.me/darachhat" class="hover:text-blue-500 transition-colors" target="_blank">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="mailto:darachhat012@gmail.com" class="hover:text-blue-500 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="https://github.com/Darachhat" class="hover:text-blue-500 transition-colors" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600 khmer-text">កំពុងចូលប្រើប្រាស់...</p>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    // Form submission with loading state
    document.querySelector('form').addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        const overlay = document.getElementById('loading-overlay');

        button.disabled = true;
        button.innerHTML = `
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-300"></div>
                </span>
                <span class="khmer-text">កំពុងចូលប្រើប្រាស់...</span>
            `;
        overlay.classList.remove('hidden');
    });

    // Auto-focus on first input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('login').focus();
    });

    // Handle Enter key navigation
    document.getElementById('login').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('password').focus();
        }
    });

    // Responsive adjustments
    function handleResize() {
        const container = document.querySelector('.max-w-md');
        if (window.innerWidth < 480) {
            container.classList.remove('max-w-md');
            container.classList.add('max-w-sm');
        } else {
            container.classList.remove('max-w-sm');
            container.classList.add('max-w-md');
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Call on load

    // Animation delay fix for mobile
    if (window.innerWidth <= 768) {
        document.querySelectorAll('.slide-up').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    }

    console.log('🔐 Login page loaded successfully for Darachhat');
    console.log('⏰ Current time: 2025-06-07 14:34:42 UTC');
    console.log('👤 Ready for user authentication');
</script>
</body>
</html>
