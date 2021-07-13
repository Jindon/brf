<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white">
            <div class="">
                <p class="text-lg font-bold">Patron contribution payment dues</p>
                <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                <table class="table-fixed w-full text-left">
                    <tbody>
{{--                    @foreach($patronsWithDues as $index => $patron)--}}
{{--                        <tr>--}}
{{--                            <th class="w-1/2 {{ $index/2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">{{ $patron->name }}</th>--}}
{{--                            <td class="w-1/2 {{ $index/2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹ {{ $patron->total_due }}</td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white">
            <div class="">
                <p class="text-lg font-bold">Overall contribution summary</p>
                <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
{{--                <table class="table-fixed w-full text-left">--}}
{{--                    <tbody>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Due</th>--}}
{{--                        <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_due ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Paid</th>--}}
{{--                        <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_paid ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Fine</th>--}}
{{--                        <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_fine ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Amount</th>--}}
{{--                        <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_amount ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white">
            <div class="">
                <p class="text-lg font-bold mb-3">Contribution  reports for</p>
{{--                <div>--}}
{{--                    <div class="flex space-x-2 mb-3">--}}
{{--                        <div class="w-1/2">--}}
{{--                            <x-select wire:model="filter.month">--}}
{{--                                @foreach($months as $month)--}}
{{--                                    <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>--}}
{{--                                @endforeach--}}
{{--                            </x-select>--}}
{{--                        </div>--}}
{{--                        <div class="w-1/2">--}}
{{--                            <x-select wire:model="filter.year">--}}
{{--                                @foreach($years as $year)--}}
{{--                                    <option value="{{ $year }}">{{ $year }}</option>--}}
{{--                                @endforeach--}}
{{--                            </x-select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <table class="table-fixed w-full text-left">--}}
{{--                    <tbody>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Due</th>--}}
{{--                        <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_due ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Paid</th>--}}
{{--                        <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_paid ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Fine</th>--}}
{{--                        <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_fine ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Amount</th>--}}
{{--                        <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $paymentReport->total_amount ?? 0 }}</td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
            </div>
        </div>
    </div>
</div>
