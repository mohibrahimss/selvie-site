<!-- Help & Support -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="page-title">Help & Support</h1>
                        <p class="page-subtitle">Get help, access resources, and manage support tickets</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                wire:click="contactSupport" 
                                class="btn btn-success">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>Contact Support</span>
                        </button>
                        <button type="button" 
                                wire:click="showCreateTicket" 
                                class="btn btn-primary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Create Ticket</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="max-w-3xl mx-auto">
        <div class="relative">
            <input type="text" 
                   wire:model.debounce.300ms="search" 
                   class="form-input pl-10" 
                   placeholder="Search FAQs, guides, and support articles...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="card">
        <!-- Tabs -->
        <div class="card-header border-b border-gray-200 pb-0">
            <nav class="flex gap-6" aria-label="Tabs">
                <button wire:click="setActiveTab('faq')" 
                        class="tab {{ $activeTab === 'faq' ? 'tab-active' : '' }}">
                    Frequently Asked Questions
                </button>
                <button wire:click="setActiveTab('guides')" 
                        class="tab {{ $activeTab === 'guides' ? 'tab-active' : '' }}">
                    Guides & Resources
                </button>
                <button wire:click="setActiveTab('tickets')" 
                        class="tab {{ $activeTab === 'tickets' ? 'tab-active' : '' }}">
                    My Support Tickets
                </button>
            </nav>
        </div>

        <div class="card-body">
            <!-- FAQs Tab -->
            @if ($activeTab === 'faq')
                <div class="space-y-6">
                    @foreach ($faqs as $faq)
                        <div class="card card-hover">
                            <div class="card-body">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $faq['question'] }}
                                </h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                                <div class="mt-3">
                                    <span class="badge badge-primary">
                                        {{ $categories[$faq['category']] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Guides Tab -->
            @if ($activeTab === 'guides')
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @foreach ($guides as $guide)
                        <div class="card card-hover">
                            <div class="card-body">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $guide['title'] }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $guide['description'] }}
                                </p>
                                <div class="mt-4">
                                    <button type="button" 
                                            wire:click="viewGuide({{ $guide['id'] }})" 
                                            class="btn btn-secondary">
                                        View Guide
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tickets Tab -->
            @if ($activeTab === 'tickets')
                <div class="space-y-6">
                    @foreach ($tickets as $ticket)
                        <div class="card card-hover">
                            <div class="card-body">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $ticket['subject'] }}
                                    </h3>
                                    <span class="badge {{ 
                                        $ticket['status'] === 'open' ? 'badge-warning' :
                                        ($ticket['status'] === 'in-progress' ? 'badge-info' : 'badge-success')
                                    }}">
                                        {{ ucfirst($ticket['status']) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>{{ $ticket['description'] }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between text-sm">
                                    <div class="flex gap-4">
                                        <span class="text-gray-500">
                                            Category: {{ $categories[$ticket['category']] }}
                                        </span>
                                        <span class="text-gray-500">
                                            Priority: {{ ucfirst($ticket['priority']) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-500">
                                        Created: {{ \Carbon\Carbon::parse($ticket['created_at'])->format('M j, Y g:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Create Ticket Modal -->
    <div x-show="$wire.showTicketModal" 
         class="modal"
         x-cloak
         x-transition>
        <div class="modal-backdrop"></div>

        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create Support Ticket</h3>
            </div>
            
            <div class="modal-body space-y-4">
                <div>
                    <label for="ticket-subject" class="form-label">Subject</label>
                    <input type="text" 
                           wire:model="ticketSubject" 
                           id="ticket-subject" 
                           class="form-input">
                </div>

                <div>
                    <label for="ticket-description" class="form-label">Description</label>
                    <textarea wire:model="ticketDescription" 
                              id="ticket-description" 
                              rows="4" 
                              class="form-textarea"></textarea>
                </div>

                <div>
                    <label for="ticket-category" class="form-label">Category</label>
                    <select wire:model="ticketCategory" 
                            id="ticket-category" 
                            class="form-select">
                        <option value="">Select Category</option>
                        @foreach ($categories as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="ticket-priority" class="form-label">Priority</label>
                    <select wire:model="ticketPriority" 
                            id="ticket-priority" 
                            class="form-select">
                        @foreach ($priorities as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" 
                        wire:click="$set('showTicketModal', false)" 
                        class="btn btn-secondary">
                    Cancel
                </button>
                <button type="button" 
                        wire:click="createTicket" 
                        class="btn btn-primary">
                    Submit Ticket
                </button>
            </div>
        </div>
    </div>

    <!-- Guide Modal -->
    <div x-show="$wire.showGuideModal" 
         class="modal"
         x-cloak
         x-transition>
        <div class="modal-backdrop"></div>

        <div class="modal-content">
            @if ($selectedGuide)
                <div class="modal-header">
                    <h3 class="modal-title">{{ $selectedGuide['title'] }}</h3>
                    <button type="button" 
                            wire:click="$set('showGuideModal', false)" 
                            class="btn btn-icon">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="text-sm text-gray-500">{{ $selectedGuide['description'] }}</p>

                    <div class="mt-6">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach ($selectedGuide['sections'] as $index => $section)
                                    <li>
                                        <div class="relative pb-8">
                                            @if (!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex gap-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-white">
                                                        <span class="text-white text-sm font-medium">{{ $index + 1 }}</span>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $section['title'] }}</h4>
                                                    <p class="mt-2 text-sm text-gray-500">{{ $section['content'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 