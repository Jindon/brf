<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white">
        <div class="">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center md:space-y-0 space-y-3 pb-3">
                <div>
                    <p class="text-lg font-bold">Patron contribution summary</p>
                </div>
                <div class="md:w-1/4 w-full">
                    <x-select wire:model="filter.year">
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="min-w-full overflow-x-scroll md:overflow-auto">
                <table class="table-fixed min-w-full text-left">
                    <thead>
                    <tr class="border-b border-indigo-500">
                        <th class="p-2">Name</th>
                        @foreach($months as $month)
                            <th class="w-1/12 text-center text-xs">
                                <div class="p-2 {{ now()->month == $month['value'] ? 'bg-green-300' : '' }}">{{ data_get($month, 'label') }}</div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patrons as $index => $patron)
                        <tr>
                            <th class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 p-2 text-sm">{{ $patron['name'] }}</th>

                            @foreach($months as $month)
                                <td class="text-center {{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 p-2 text-xs font-bold">
                                    <p class="{{ data_get($patron['payment_details'], $month['label']) != 0 ? 'text-green-500' : 'text-gray-500' }}">
                                        ₹{{ data_get($patron['payment_details'], $month['label']) ?? 0 }}
                                    </p>
                                </td>
                            @endforeach

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
