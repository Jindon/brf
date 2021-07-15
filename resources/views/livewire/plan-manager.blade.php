<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                wire:loading.class.delay="opacity-50"
            >
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-xl text-gray-500 mb-2">Current active plan</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="font-bold">Plan amount</p>
                            <x-input id="amount" class="block w-full" type="number" name="amount" wire:model.defer="amount" required />
                        </div>
                        <div>
                            <p class="font-bold">Fine amount</p>
                            <x-input id="fine_amount" class="block w-full" type="number" name="fine_amount" wire:model.defer="fine_amount" required />
                        </div>
                        <div>
                            <x-button class="md:mt-7" wire:click.prevent="updateAmount">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="px-6 py-3 bg-white border-b border-gray-200">
                    <p class="mt-3 text-gray-500">Payment Generation Logs</p>
                    @if(!count($planLogs))
                        <p class="pt-6 text-gray-300">No payments generated yet..</p>
                    @endif
                    <ul class="pt-6">
                        @foreach($planLogs as $log)
                            <hr>
                            @if($log->is_fine)
                                <li class="py-3">🚩 <span class="ml-3 font-bold">{{ $log->payments_generated }}</span> Fines generated for the month of <span class="font-bold">{{ $log->month }}, {{ $log->year }}</span> at {{ $log->created_at->format('d-m-Y, h:i a') }}.</li>
                            @else
                                <li class="py-3">🚀 <span class="ml-3 font-bold">{{ $log->payments_generated }}</span> Payments details generated for the month of <span class="font-bold">{{ $log->month }}, {{ $log->year }}</span> at {{ $log->created_at->format('d-m-Y, h:i a') }}.</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                {{ $planLogs->links() }}
            </div>

        </div>
    </div>
</div>
