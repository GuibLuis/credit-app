@props(['id', 'type' => 'text', 'placeholder' => '', 'value' => '', 'class' => ''])

<input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    {{ $attributes->merge(['class' => 'border-2 border-gray-300 rounded-md p-2 w-[200px] ' . $class]) }}>
