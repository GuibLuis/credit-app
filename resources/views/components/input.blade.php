@props(['id', 'type' => 'text', 'placeholder' => '', 'value' => '', 'class' => ''])

<div class="relative {{ $id == 'valor' ? 'h-full' : '' }}">
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => 'border-2 border-gray-300 rounded-md p-2 h-full ' . $class]) }}>
    <input type="hidden" id="{{ $id }}-value" value="">
    <p id="{{ $id }}-error" class="text-red-500 absolute -bottom-6 hidden">Inválido</p>
</div>
