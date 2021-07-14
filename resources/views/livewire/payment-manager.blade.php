<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-3 bg-white border-b border-gray-200">
                    <div class="grid md:grid-cols-3 grid-cols-1 gap-3">
                        <div>
                            <p class="mb-1 font-bold">Filter by patrons</p>
                            <x-select wire:model="filter.patronId">
                                <option value="">All Patrons</option>
                                @foreach($patrons as $patron)
                                    <option value="{{ $patron->id }}">{{ $patron->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <p class="mb-1 font-bold">Filter by month</p>
                                <x-select wire:model="filter.month">
                                    <option value="">All months</option>
                                    @foreach($months as $month)
                                        <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="w-1/2">
                                <p class="mb-1 font-bold">Filter by year</p>
                                <x-select wire:model="filter.year">
                                    <option value="">All years</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <p class="mb-1 font-bold">Filter by status</p>
                                <x-select wire:model="filter.status">
                                    <option value="all">All</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </x-select>
                            </div>
                            <div class="w-1/2">
                                <p class="mb-1 font-bold">Filter by fine</p>
                                <x-select wire:model="filter.fine">
                                    <option value="all">All</option>
                                    <option value="no">No fine</option>
                                    <option value="yes">Has fine</option>
                                </x-select>
                            </div>
                        </div>
                    </div>
                    @if(!count($payments))
                        <p class="pt-6 text-gray-300">No payments details found...</p>
                    @endif
                    <div class="pt-6">
                        @foreach($payments as $payment)
                            <hr>
                            <div class="grid grid-col-1 gap-3 md:grid-cols-7 py-3">
                                <div class="md:col-span-3">
                                    <p class="relative"><span class="absolute block w-5 h-5 {{ $payment->due > 0 ? 'bg-red-500' : 'bg-green-500' }} rounded-full"></span> <span class="pl-5 mx-2 text-xl font-bold">{{ $payment->patron->name }}</span> Payments details for <span class="ml-3 font-bold">{{ $payment->month }}, {{ $payment->year }}</span></p>
                                    <div class="flex flex-wrap space-x-2">
                                        <p>D:<span class="text-red-500 font-bold ml-2">₹ {{ $payment->due }}</span></p>
                                        <p>| P:<span class="text-green-500 font-bold ml-2">₹ {{ $payment->paid }}</span></p>
                                        <p>| F:<span class="text-red-400 ml-2">₹ {{ $payment->fine }}</span></p>
                                        <p>| A:<span class="ml-2">₹ {{ $payment->amount }}</span></p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Last date</p>
                                    <p>{{ $payment->due_date->format('m-d-Y') }}</p>
                                </div>
                                <div class="md:col-span-3 flex md:justify-end">
                                    @if(optional($selectedPayment)->id == $payment->id)
                                        <div class="flex flex-col md:flex-row">
                                            <div class="md:mr-2">
                                                <x-input id="{{$payment->uuid}}" class="block w-32 py-1" type="number" name="amount" wire:model="amount" required max="{{ $payment->due }}" min="10"/>
                                            </div>
                                            <div>
                                                <x-button wire:click.prevent="makePayment">Pay</x-button>
                                                <x-alt-button wire:click.prevent="cancel" class="ml-2">Cancel</x-alt-button>
                                            </div>
                                        </div>
                                    @endif
                                    @if(optional($selectedPayment)->id != $payment->id)
                                        <div>
                                            <x-button :disabled="($payment->due == 0)" wire:click.prevent="selectPayment({{ $payment->id }})">
                                                {{ $payment->due ? 'Make Payment' : 'Already Paid' }}
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 py-2 mb-2">⌚ Generated on: {{ $payment->created_at->format('d-m-Y, h:i a') }}</p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>

        </div>
    </div>
</div>
