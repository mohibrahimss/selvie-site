<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-8">
            <h1 class="text-2xl font-bold text-white">Super Admin Dashboard</h1>
            <p class="mt-2 text-indigo-100">System Overview and Management</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
        @foreach($stats as $key => $value)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-dynamic-component 
                                :component="'icon.' . $key"
                                class="h-6 w-6 text-gray-400"
                            />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ Str::title(str_replace('_', ' ', $key)) }}
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $value }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- System Alerts -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">System Alerts</h2>
                <!-- System alerts content -->
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Pending Approvals</h2>
                <!-- Pending approvals content -->
            </div>
        </div>
    </div>
</div> 