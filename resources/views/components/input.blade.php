@props(['label', 'name', 'type' => 'text', 'value' => '', 'disabled' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($disabled) disabled @endif
        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
</div>