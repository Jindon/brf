<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">

                        <p class="font-bold mb-3">✈ Issue new loan</p>
                        <div>
                            <form wire:submit.prevent="issueLoan">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <x-select wire:model="form.patron_id" id="patron">
                                            <option value="">Select patron</option>
                                            @foreach($patrons as $patron)
                                                <option value="{{ $patron->id }}">{{ $patron->name }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    @if($form['patron_id'])
                                        <div>
                                            <x-label for="amount" :value="__('Loan amount')" />
                                            <div class="flex items-center">
                                                <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" wire:model="form.amount" required />
                                                <div class="w-1/2 p-2 ml-2">
                                                    <p>/ ₹{{ $amountInAccount }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <x-label for="interest" :value="__('Interest pc')" />
                                            <x-input id="interest" class="block mt-1 w-full" type="number" name="interest" wire:model.defer="form.interest" max="100" min="1" required />
                                        </div>
                                        <div>
                                            <x-label for="fine" :value="__('Fine')" />
                                            <x-input id="fine" class="block mt-1 w-full" type="number" name="fine" wire:model.defer="form.fine" required />
                                        </div>
                                        <div>
                                            <x-label for="issued_on" :value="__('Issued on')" />
                                            <x-pickaday id="issued_on" wire:model.defer="form.issued_on" required/>
                                        </div>
                                    @endif
                                </div>

                                @if($limitError)
                                    <p class="p-2 my-3 rounded-sm bg-red-600 text-red-100 font-bold text-sm">{{ $limitError }}</p>
                                @endif

                                @if($form['patron_id'])
                                    <div class="flex">
                                        <x-button :diabled="$loading" class="mt-3 mr-3">
                                            {{ __('Issue Loan') }}
                                        </x-button>
                                        <x-alt-button class="mt-3" type="button" wire:click.prevent="cancel">
                                            {{ __('Cancel') }}
                                        </x-alt-button>
                                    </div>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-3 px-4 md:px-0">
                        <p class="font-bold md:text-4xl text-lg">Issued Loans</p>
                        <div class="w-1/3">
                            <p class="mb-1 font-bold">Filter by status</p>
                            <x-select wire:model="filter.status">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </x-select>
                        </div>
                    </div>

                    @if(!$loans->total())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                            <div class="px-6 py-3 bg-white">
                                <p class="text-gray-300 py-6">No loans found....</p>
                            </div>
                        </div>
                    @endif
                    @foreach($loans as $loan)
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3"
                            wire:loading.class.delay="opacity-50" wire:key="row-{{ $loan->id }}"
                        >
                            <div class="px-6 py-3 bg-white">
                                <div class="flex justify-between items-center">
                                    <div class="w-2/3 flex md:flex-row flex-col md:justify-between md:items-center">
                                        <div>
                                            <p class="text-xl font-bold">{{ $loan->patron->name }}</p>
                                            <p>Issued on: <span class="font-bold">{{ $loan->issued_on->format('d-m-Y') }}</span></p>
                                            <p>Term: <span class="font-bold">{{ $loan->terms }}m</span></p>
                                            <p>Paid off: <span class="font-bold">{{ $loan->due ? 'No' : 'Yes' }}</span></p>
                                        </div>
                                        <div>
                                            <table class="table-fixed">
                                                <tbody class="text-left">
                                                    <tr>
                                                        <th class="p-1 bg-gray-100 border-b border-gray-200">Amount:</th>
                                                        <td class="p-1 bg-gray-100 border-b border-gray-200">₹{{ number_format($loan->amount, 2, '.', ',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-1 border-b border-gray-200">Interest:</th>
                                                        <td class="p-1 border-b border-gray-200">{{ $loan->interest }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-1 bg-gray-100 border-b border-gray-200">Fine:</th>
                                                        <td class="p-1 bg-gray-100 border-b border-gray-200">₹{{ $loan->fine }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="w-1/3 flex flex-col justify-center items-end space-y-1">
                                            <p>Current term: <span class="font-bold">{{ $loan->current_term }}</span></p>
                                            <p>Balance: <span class="font-bold text-red-500">₹{{ number_format($loan->due, 2, '.', ',') }}</span></p>
                                            <p>Paid: <span class="font-bold text-red-500">₹{{ number_format($loan->paid, 2, '.', ',') }}</span></p>
                                            <x-alt-button id="delete_{{ $loan->id }}" :disabled="$loan->paid != 0" wire:click.prevent="delete({{ $loan }})">Delete</x-alt-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $loans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
