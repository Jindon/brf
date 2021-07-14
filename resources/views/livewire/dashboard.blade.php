<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                            <div>
                                <p class="text-gray-500">Total Contribution</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['totalContribution'] }}</p>
                                <p class="text-gray-500 mt-2">Total fine</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['totalFine'] }}</p>
                                <p class="text-gray-500 mt-2">Total expense</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['totalExpense'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Total loan issued</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['totalLoanIssued'] }}</p>
                                <p class="text-gray-500 mt-2">Total interest collected</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['interestCollected'] }}</p>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <p class="text-gray-500">Pending loan amount</p>
                                <p class="text-lg md:text-xl font-bold text-red-500">₹{{ $platformReport['pendingLoan'] }}</p>
                                <p class="text-gray-500 mt-2">Amount in account</p>
                                <p class="text-lg md:text-xl font-bold">₹{{ $platformReport['totalContribution'] + $platformReport['interestCollected'] - $platformReport['pendingLoan'] - $platformReport['totalExpense'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-6">
                <livewire:contribution-summary :years="$years" :months="$months"/>
            </div>

            <div class="mb-6">
                <livewire:loan-report />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <div class="">
                            <p class="text-lg font-bold">Patrons contribution summary</p>
                            <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                            <table class="table-fixed w-full text-left">
                                <tbody>
                                @foreach($patronsContribution as $index => $patron)
                                    <tr>
                                        <th class="w-1/2 {{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">{{ $patron->name }}</th>
                                        <td class="w-1/2 {{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹ {{ $patron->total_paid }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <div class="">
                            <p class="text-lg font-bold">Patrons pending contributions</p>
                            <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                            <table class="table-fixed w-full text-left">
                                <tbody>
                                @foreach($patronsPendingContribution as $index => $patron)
                                    <tr>
                                        <th class="w-1/2 {{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">{{ $patron->name }}</th>
                                        <td class="w-1/2 {{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹ {{ $patron->total_due }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <div class="">
                            <p class="text-lg font-bold">Overall contribution summary</p>
                            <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                            <table class="table-fixed w-full text-left">
                                <tbody>
                                <tr>
                                    <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Due</th>
                                    <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_due ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Paid</th>
                                    <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_paid + $startingBalance ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Fine</th>
                                    <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_fine ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Amount</th>
                                    <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_amount + $startingBalance ?? 0 }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <div class="">
                            <p class="text-lg font-bold mb-3">Contribution reports for</p>
                            <div>
                                <div class="flex space-x-2 mb-3">
                                    <div class="w-1/2">
                                        <x-select wire:model="filter.month">
                                            <option value="">All months</option>
                                            @foreach($months as $month)
                                                <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="w-1/2">
                                        <x-select wire:model="filter.year">
                                            @foreach($years as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                            <table class="table-fixed w-full text-left">
                        <tbody>
                            <tr>
                                <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Due</th>
                                <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_due ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Paid</th>
                                <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_paid ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Fine</th>
                                <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_fine ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Amount</th>
                                <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_amount ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
