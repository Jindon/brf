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

                        <p class="font-bold mb-3">🍻 Add new expense</p>
                        <div>
                            <form wire:submit.prevent="createExpense">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <x-select wire:model="form.type" id="expense">
                                            <option value="">Select type</option>
                                            @foreach($types  as $type)
                                                <option value="{{ $type['type'] }}">{{ $type['label'] }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    @if($form['type'])
                                        <div>
                                            <x-label for="amount" :value="__('Amount')" />
                                            <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" wire:model.defer="form.amount" required />
                                        </div>
                                        <div>
                                            <x-label for="date" :value="__('Date')" />
                                            <x-pickaday id="date" wire:model.defer="form.date" required/>
                                        </div>
                                        <div class="flex space-x-3 items-center mt-3">
                                            <x-label for="paid" class="font-bold text-lg" :value="__('Paid')" />
                                            <x-input id="paid" class="block w-6 h-6" type="checkbox" name="paid" wire:model.defer="form.paid" />
                                        </div>
                                    @endif
                                </div>

                                @if($form['type'])
                                    <div class="flex mt-6">
                                        <x-button class="mt-3 mr-3">
                                            {{ __('Add expense') }}
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
                        <p class="font-bold md:text-4xl text-lg">Expenses</p>
                        <div class="w-1/3">
                            <p class="mb-1 font-bold">Order by date</p>
                            <x-select wire:model="order">
                                <option value="desc">Latest</option>
                                <option value="asc">Oldest</option>
                            </x-select>
                        </div>
                    </div>

                    @if(!$expenses->count())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                            <div class="px-6 py-3 bg-white">
                                <p class="text-gray-300 py-6">No expenses found....</p>
                            </div>
                        </div>
                    @endif
                    @foreach($expenses as $expense)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                            <div class="px-6 py-3 bg-white">
                                <div class="flex justify-between items-center">
                                    <div class="w-2/3 flex md:flex-row flex-col md:justify-between md:items-center">
                                        <div>
                                            <p>Expense type:
                                                <span class="font-bold ml-3">{{ config("app.expense_type")[$expense->type]['label'] }}</span>
                                            </p>
                                            <p>Date:
                                                <span class="font-bold ml-3">{{ $expense->date }}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <p>Amount:
                                                <span class="font-bold ml-3">₹{{ $expense->amount }}</span>
                                            </p>
                                            <p>Paid:
                                                <span class="font-bold ml-3">{{ $expense->paid ? 'Yes' : 'No' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="w-1/3 flex flex-col justify-center items-end space-y-1">
                                        <x-button id="paid_{{ $expense->id }}" :disabled="!$expense->paid != 1" wire:click.prevent="markPaid({{ $expense }})">Mark paid</x-button>
                                        <x-alt-button id="delete_{{ $expense->id }}" wire:click.prevent="delete({{ $expense }})">Delete</x-alt-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
