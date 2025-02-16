<div>
    <x-dialog-modal wire:model="show">
        <x-slot name="title">
            {{ $isEditing ? 'Edit Student' : 'Add New Student' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <x-label for="name" value="Name" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
                    <x-input-error for="state.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                    <x-input-error for="state.email" class="mt-2" />
                </div>

                <!-- Grade -->
                <div>
                    <x-label for="grade" value="Grade" />
                    <select id="grade" wire:model.defer="state.grade" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        <option value="">Select Grade</option>
                        @foreach($this->gradeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="state.grade" class="mt-2" />
                </div>

                <!-- Status -->
                <div>
                    <x-label for="status" value="Status" />
                    <select id="status" wire:model.defer="state.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        @foreach($this->statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="state.status" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$emit('closeModal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3 bg-primary hover:bg-primary-hover" wire:click="save" wire:loading.attr="disabled">
                {{ $isEditing ? 'Update' : 'Create' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div> 