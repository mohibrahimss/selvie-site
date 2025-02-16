<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @stack('styles')

        <style>
            [x-cloak] { display: none !important; }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb {
                background: #c5c5c5;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            /* Global Styles */
            .page-header {
                @apply bg-white rounded-xl shadow-sm overflow-hidden mb-6;
            }

            .page-header-gradient {
                @apply relative;
            }

            .page-header-gradient::before {
                content: '';
                @apply absolute inset-0 bg-gradient-to-r from-indigo-600 to-indigo-400 opacity-90;
            }

            .page-header-content {
                @apply relative px-8 py-10 text-white;
            }

            .page-title {
                @apply text-3xl font-bold leading-7 sm:text-4xl sm:truncate;
            }

            .page-subtitle {
                @apply mt-2 text-lg text-indigo-100;
            }

            /* Card Styles */
            .card {
                @apply bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-200;
            }

            .card-header {
                @apply flex items-center justify-between p-6 border-b border-gray-100;
            }

            .card-title {
                @apply text-xl font-bold text-gray-900;
            }

            .card-body {
                @apply p-6;
            }

            /* Button Styles */
            .btn {
                @apply inline-flex items-center px-4 py-2 border text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150;
            }

            .btn-primary {
                @apply border-transparent text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500;
            }

            .btn-secondary {
                @apply border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-indigo-500;
            }

            /* Form Controls */
            .form-select {
                @apply block w-full pl-3 pr-10 py-2 text-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg;
            }

            .form-checkbox {
                @apply h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded;
            }

            /* Grid Layouts */
            .stats-grid {
                @apply grid grid-cols-4 gap-6 mb-8;
            }

            .content-grid {
                @apply grid grid-cols-1 gap-8 lg:grid-cols-2;
            }

            /* Progress Bars */
            .progress-bar {
                @apply overflow-hidden h-2 text-xs flex rounded-full bg-gray-100;
            }

            .progress-bar-fill {
                @apply shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500 rounded-full;
            }

            /* Badges */
            .badge {
                @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
            }

            .badge-red {
                @apply bg-red-100 text-red-800;
            }

            .badge-yellow {
                @apply bg-yellow-100 text-yellow-800;
            }

            /* Transitions */
            .transition-all {
                transition-property: all;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }

            /* Better Button Focus States */
            button:focus {
                outline: 2px solid transparent;
                outline-offset: 2px;
            }

            /* Card Hover Effects */
            .hover\:shadow-lg:hover {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
        </style>
    </head>
    <body class="h-full font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-50 flex flex-col">
            <!-- Mobile sidebar backdrop -->
            <div 
                x-show="sidebarOpen" 
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <!-- Navigation -->
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main class="lg:pl-72 flex-grow">
                <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[1440px] lg:pr-72">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <x-footer />

            <!-- Notifications -->
            <div 
                x-data="{ notifications: [] }"
                class="fixed bottom-0 right-0 p-6 z-50 space-y-4"
                @notification.window="
                    notifications.push($event.detail);
                    setTimeout(() => {
                        notifications = notifications.filter(n => n.id !== $event.detail.id);
                    }, 5000);
                "
            >
                <template x-for="notification in notifications" :key="notification.id">
                    <div 
                        x-show="true"
                        x-transition:enter="transform ease-out duration-300 transition"
                        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="max-w-sm w-full bg-white shadow-soft-lg rounded-xl pointer-events-auto"
                    >
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <template x-if="notification.type === 'success'">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </template>
                                    <template x-if="notification.type === 'error'">
                                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                    <p class="mt-1 text-sm text-gray-500" x-text="notification.message"></p>
                                </div>
                                <div class="ml-4 flex flex-shrink-0">
                                    <button 
                                        @click="notifications = notifications.filter(n => n.id !== notification.id)"
                                        class="inline-flex text-gray-400 hover:text-gray-500"
                                    >
                                        <span class="sr-only">Close</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        @livewireScripts
        @stack('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add smooth scrolling to all links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        document.querySelector(this.getAttribute('href')).scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });

                // Add transition classes to interactive elements
                const interactiveElements = document.querySelectorAll('button, a, select, input[type="checkbox"]');
                interactiveElements.forEach(element => {
                    element.classList.add('transition-all', 'duration-200', 'ease-in-out');
                });
            });
        </script>
    </body>
</html> 