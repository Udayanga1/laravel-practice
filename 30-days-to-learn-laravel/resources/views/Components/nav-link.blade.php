@props(['active' => false])
{{-- default is false for above active props --}}

<a class="{{ $active ? 'bg-gray-900 text-white rounded-md px-3 py-2' : 'bg-gray-700 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2' }}" {{ $attributes }}>{{ $slot }}</a>