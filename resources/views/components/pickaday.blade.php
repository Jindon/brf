<div
    x-data
    x-init="new Pikaday({ field: $refs.input, format: 'DD-MM-YYYY' })"
    @change="$dispatch('input', $event.target.value)"
    class="relative flex"
>
    <div class="absolute right-0 top-0 px-2 py-3 text-gray-400">
        <svg class="w-4 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M4 0a1 1 0 00-1 1v1H2a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2h-1V1a1 1 0 00-2 0v1H5V1a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 000-2z" fill-rule="evenodd"/></svg>
    </div>
    <input {{ $attributes }}
           autocomplete="false"
           class="w-full p-2 pr-8 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
           x-ref="input"
           placeholder="DD-MM-YYYY"
           type="text"
    >
</div>
