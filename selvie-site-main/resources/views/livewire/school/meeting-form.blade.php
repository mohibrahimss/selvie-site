<div>
    <x-dialog-modal wire:model="show">
        <x-slot name="title">
            {{ $isEditing ? 'Edit Meeting' : 'Schedule Meeting' }}
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

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-label for="date" value="Date" />
                        <x-input id="date" type="date" class="mt-1 block w-full" wire:model.defer="selectedDate" min="{{ now()->format('Y-m-d') }}" />
                        <x-input-error for="selectedDate" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="startTime" value="Start Time" />
                        <x-input id="startTime" type="time" class="mt-1 block w-full" wire:model.defer="startTime" />
                        <x-input-error for="startTime" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="endTime" value="End Time" />
                        <x-input id="endTime" type="time" class="mt-1 block w-full" wire:model.defer="endTime" />
                        <x-input-error for="endTime" class="mt-2" />
                    </div>
                </div>

                <!-- Mentor -->
                <div>
                    <x-label for="mentor" value="Mentor" />
                    <select id="mentor" wire:model.defer="state.mentor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="">Select Mentor</option>
                        @foreach($this->mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="state.mentor_id" class="mt-2" />
                </div>

                <!-- Student -->
                <div>
                    <x-label for="student" value="Student" />
                    <select id="student" wire:model.defer="state.student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="">Select Student</option>
                        @foreach($this->students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="state.student_id" class="mt-2" />
                </div>

                <!-- Status -->
                @if($isEditing)
                    <div>
                        <x-label for="status" value="Status" />
                        <select id="status" wire:model.defer="state.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            @foreach($this->statusOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="state.status" class="mt-2" />
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$emit('closeModal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3 bg-primary hover:bg-primary-hover" wire:click="save" wire:loading.attr="disabled">
                {{ $isEditing ? 'Update Meeting' : 'Schedule Meeting' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div> 