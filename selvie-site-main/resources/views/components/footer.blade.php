<!-- Footer -->
<footer class="bg-white border-t border-gray-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Selvie</h3>
                    <p class="text-sm text-gray-600">Empowering mentors to make a difference in students' lives through effective guidance and support.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Quick Links</h3>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <a href="{{ route('mentor.dashboard') }}" class="text-sm text-gray-600 hover:text-indigo-600">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('mentor.calendar') }}" class="text-sm text-gray-600 hover:text-indigo-600">Calendar</a>
                        </li>
                        <li>
                            <a href="{{ route('mentor.students') }}" class="text-sm text-gray-600 hover:text-indigo-600">My Students</a>
                        </li>
                        <li>
                            <a href="{{ route('mentor.tasks') }}" class="text-sm text-gray-600 hover:text-indigo-600">Tasks</a>
                        </li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Resources</h3>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <a href="{{ route('mentor.training') }}" class="text-sm text-gray-600 hover:text-indigo-600">Training Center</a>
                        </li>
                        <li>
                            <a href="{{ route('mentor.help') }}" class="text-sm text-gray-600 hover:text-indigo-600">Help & Support</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Documentation</a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">FAQs</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Contact</h3>
                    <ul class="mt-4 space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            support@selvie.com
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            (555) 123-4567
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom -->
            <div class="mt-12 pt-8 border-t border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Selvie. All rights reserved.</p>
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Terms of Service</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> 