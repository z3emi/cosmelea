@props(['label', 'name', 'options' => [], 'selected' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}"
        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
        @foreach($options as $value => $label)
            <option value="{{ $value }}" @if(old($name, $selected) == $value) selected @endif>{{ $label }}</option>
        @endforeach
    </select>
</div>