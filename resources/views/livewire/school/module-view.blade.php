<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <!-- Module Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $module->title }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $module->description }}</p>
        </div>
        <div class="flex space-x-4">
            @if($previousModule)
                <button wire:click="previousModule" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </button>
            @endif

            @if($nextModule)
                <button wire:click="nextModule" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Next
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Module Progress -->
    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center">
            <div class="flex-1">
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center transition-all duration-300 {{ $completion->passed ? 'bg-green-500' : 'bg-primary' }}" style="width: {{ $completion->passed ? '100' : '0' }}%"></div>
                    </div>
                </div>
            </div>
            <div class="ml-4">
                @if($completion->passed)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Completed
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        In Progress
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Module Content -->
    <div class="px-4 py-5 sm:px-6 prose max-w-none">
        {!! $module->content !!}
    </div>

    <!-- Module Attachments -->
    @if($module->attachments->isNotEmpty())
        <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
            <h4 class="text-sm font-medium text-gray-500">Attachments</h4>
            <ul class="mt-4 divide-y divide-gray-200">
                @foreach($module->attachments as $attachment)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-900">{{ $attachment->name }}</span>
                            <span class="ml-2 text-sm text-gray-500">({{ $attachment->size_for_humans }})</span>
                        </div>
                        <a href="{{ $attachment->url }}" target="_blank" class="text-primary hover:text-primary-hover text-sm font-medium">
                            Download
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Module Completion -->
    <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
        @if($module->type === 'quiz')
            <div class="space-y-4">
                <h4 class="text-sm font-medium text-gray-500">Quiz Completion</h4>
                <div>
                    <x-label for="score" value="Score (%)" />
                    <x-input id="score" type="number" class="mt-1 block w-full" wire:model.defer="score" min="0" max="100" />
                    <x-input-error for="score" class="mt-2" />
                </div>
                <div class="flex justify-end">
                    <x-button wire:click="submitQuiz" wire:loading.attr="disabled">
                        Submit Quiz
                    </x-button>
                </div>
            </div>
        @elseif($module->type === 'assignment')
            <div class="space-y-4">
                <h4 class="text-sm font-medium text-gray-500">Assignment Submission</h4>
                <div>
                    <x-label for="answer" value="Your Answer" />
                    <textarea id="answer" wire:model.defer="answer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" rows="6"></textarea>
                    <x-input-error for="answer" class="mt-2" />
                </div>
                <div class="flex justify-end">
                    <x-button wire:click="submitAssignment" wire:loading.attr="disabled">
                        Submit Assignment
                    </x-button>
                </div>
            </div>
        @else
            <div class="flex justify-end">
                <x-button wire:click="markAsCompleted" wire:loading.attr="disabled" class="{{ $completion->passed ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $completion->passed ? 'disabled' : '' }}>
                    {{ $completion->passed ? 'Completed' : 'Mark as Completed' }}
                </x-button>
            </div>
        @endif
    </div>
</div> 