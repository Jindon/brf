<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patrons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(!$this->addNew)
                        <div>
                            <a href="" wire:click.prevent="addNewPatron" class="text-blue-600">Add new patron</a>
                        </div>
                    @endif
                    @if($this->addNew)
                        <p class="font-bold">Add a new patron</p>
                        <div>
                            <form wire:submit.prevent="savePatron">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <x-label for="name" :value="__('Name')" />
                                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model="form.name" required />
                                    </div>
                                    <div>
                                        <x-label for="email" :value="__('Email')" />
                                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model="form.email" required />
                                    </div>
                                    <div>
                                        <x-label for="joined_on" :value="__('Joined on')" />
                                        <x-pickaday id="joined_on" wire:model="form.joined_on" required/>
                                    </div>
                                </div>

                                <div class="flex">
                                    <x-button class="mt-3 mr-3">
                                        {{ __('Add Patron') }}
                                    </x-button>
                                    <x-alt-button class="mt-3" type="button" wire:click.prevent="closeAddForm">
                                        {{ __('Cancel') }}
                                    </x-alt-button>
                                </div>

                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @foreach($patrons as $patron)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                    <div class="px-6 py-3 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="w-2/3 flex md:flex-row flex-col md:justify-between md:items-center">
                                <div>
                                    <p class="text-2xl font-bold">{{ $patron->name }}</p>
                                    <p class="text-gray-500">{{ $patron->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs">Joined on</p>
                                    <p class="text-xl font-bold">{{ $patron->joined_on->format('d-m-Y') }}</p>
                                </div>
                            </div>
                            <div class="w-1/3 flex justify-end">
                                @if(optional($this->selectedPatron)->id != $patron->id)
                                    <x-button wire:click.prevent="selectPatron({{ $patron }})">Edit</x-button>
                                @endif
                            </div>
                        </div>
                        @if(optional($this->selectedPatron)->id == $patron->id)
                            <div>
                                <form wire:submit.prevent="savePatron">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div>
                                            <x-label for="name" :value="__('Name')" />
                                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model="form.name" required />
                                        </div>
                                        <div>
                                            <x-label for="email" :value="__('Email')" />
                                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model="form.email" required />
                                        </div>
                                        <div>
                                            <x-label for="joined_on_{{ $patron->id }}" :value="__('Joined on')" />
                                            <x-pickaday id="joined_on_{{ $patron->id }}" wire:model="form.joined_on" required/>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <x-button class="mt-3 mr-3">
                                            {{ __('Save Patron') }}
                                        </x-button>
                                        <x-alt-button class="mt-3" type="button" wire:click.prevent="unSelectPatron">
                                            {{ __('Cancel') }}
                                        </x-alt-button>
                                    </div>

                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $patrons->links() }}
            </div>

        </div>
    </div>
</div>
