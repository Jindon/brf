@props(['disabled' => false])
<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm']) !!}
>
    {{ $slot }}
</select>
