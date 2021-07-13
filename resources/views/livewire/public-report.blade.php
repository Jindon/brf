<div class="py-12">
    @if($unlocked)
        <div class="text-center">
            <h3 class="mb-3 font-bold text-2xl">Bright Future Reports</h3>
        </div>
        <livewire:dashboard />
    @else
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="flex justify-center overflow-hidden sm:rounded-lg">
                <form wire:submit.prevent="unlockReport">
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">
                        <div class="md:mr-2">
                            <x-input id="pin" class="block w-44 py-1" type="text" name="pin" wire:model.defer="pin"/>
                        </div>
                        <div>
                            <x-button>Unlock</x-button>
                            <x-alt-button wire:click.prevent="clear" class="ml-2">Clear</x-alt-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
