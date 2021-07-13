<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white">
            <div class="">
                <p class="text-lg font-bold">Patron overall loan details</p>
                <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                <div class="min-w-full overflow-x-scroll md:overflow-auto">
                    <table class="table-fixed min-w-full text-left">
                    <thead>
                        <tr class="border-b border-indigo-500">
                            <th class="w-1/6 px-3 py-2">Name</th>
                            <th class="w-1/6 px-3 py-2">Borrowed</th>
                            <th class="w-1/6 px-3 py-2">Due</th>
                            <th class="w-1/6 px-3 py-2">Paid</th>
                            <th class="w-1/6 px-3 py-2">Interest Paid</th>
                            <th class="w-1/6 px-3 py-2">Fines Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($patronsWithDues as $index => $patron)
                        <tr>
                            <th class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">{{ $patron->name }}</th>
                            <td class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹{{ $patron->loan_total ?? 0 }}</td>
                            <td class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹{{ $patron->total_due ?? 0 }}</td>
                            <td class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹{{ $patron->loan_paid_total ?? 0 }}</td>
                            <td class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹{{ $patron->loan_interest_paid_total ?? 0 }}</td>
                            <td class="{{ $index%2 == 0 ? 'bg-gray-100' : '' }} border-b border-gray-200 px-3 py-2">₹{{ $patron->loan_fine_paid_total ?? 0 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white">
            <div class="">
                <p class="text-lg font-bold">Overall loan summary</p>
                <p class="text-sm text-gray-400 mb-3">as of {{ now()->format('M, Y') }}</p>
                <table class="table-fixed w-full text-left">
                    <tbody>
                        <tr>
                            <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Issued</th>
                            <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_issued ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Due</th>
                            <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_due ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Interest</th>
                            <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_interest ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th class="w-1/2 border-b border-gray-200 px-3 py-2">Total Fine</th>
                            <td class="w-1/2 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_fine ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">Total Paid</th>
                            <td class="w-1/2 bg-gray-100 border-b border-gray-200 px-3 py-2">₹ {{ $overallReport->total_paid ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
