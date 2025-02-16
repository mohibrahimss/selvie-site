<div>
    <x-dialog-modal wire:model="show">
        <x-slot name="title">
            {{ $isEditing ? 'Edit Module' : 'Add Module' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <x-label for="title" value="Title" />
                    <x-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="state.title" />
                    <x-input-error for="state.title" class="mt-2" />
                </div>

                <!-- Description -->
                <div>
                    <x-label for="description" value="Description" />
                    <textarea id="description" wire:model.defer="state.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" rows="3"></textarea>
                    <x-input-error for="state.description" class="mt-2" />
                </div>

                <!-- Content -->
                <div>
                    <x-label for="content" value="Content" />
                    <textarea id="content" wire:model.defer="state.content" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" rows="6"></textarea>
                    <x-input-error for="state.content" class="mt-2" />
                </div>

                <!-- Type -->
                <div>
                    <x-label for="type" value="Type" />
                    <select id="type" wire:model.defer="state.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="">Select Type</option>
                        @foreach($typeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="state.type" class="mt-2" />
                </div>

                <!-- Order -->
                <div>
                    <x-label for="order" value="Order" />
                    <x-input id="order" type="number" class="mt-1 block w-full" wire:model.defer="state.order" min="1" />
                    <x-input-error for="state.order" class="mt-2" />
                </div>

                <!-- Estimated Duration -->
                <div>
                    <x-label for="estimated_duration" value="Estimated Duration (minutes)" />
                    <x-input id="estimated_duration" type="number" class="mt-1 block w-full" wire:model.defer="state.estimated_duration" min="1" />
                    <x-input-error for="state.estimated_duration" class="mt-2" />
                </div>

                <!-- Required -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_required" type="checkbox" wire:model.defer="state.is_required" class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_required" class="font-medium text-gray-700">Required Module</label>
                        <p class="text-gray-500">Mark this module as required for training completion</p>
                    </div>
                </div>

                <!-- Passing Score -->
                <div>
                    <x-label for="passing_score" value="Passing Score (%)" />
                    <x-input id="passing_score" type="number" class="mt-1 block w-full" wire:model.defer="state.passing_score" min="0" max="100" />
                    <x-input-error for="state.passing_score" class="mt-2" />
                </div>

                <!-- Attachments -->
                <div>
                    <x-label for="attachments" value="Attachments" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-hover focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                    <span>Upload files</span>
                                    <input id="file-upload" type="file" class="sr-only" wire:model="attachments" multiple>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG up to 10MB
                            </p>
                        </div>
                    </div>
                    <x-input-error for="attachments.*" class="mt-2" />

                    @if($attachments)
                        <ul class="mt-4 divide-y divide-gray-200">
                            @foreach($attachments as $index => $attachment)
                                <li class="py-3 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        <span class="ml-2 text-sm text-gray-900">{{ $attachment->getClientOriginalName() }}</span>
                                    </div>
                                    <button type="button" wire:click="removeAttachment({{ $index }})" class="text-red-600 hover:text-red-900">
                                        Remove
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$emit('closeModal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                {{ $isEditing ? 'Update Module' : 'Add Module' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div> 