@props(['id', 'text', 'class' => ''])

<button id="{{ $id }}"
    class="bg-primary text-white rounded-md py-2 px-4 hover:bg-primary/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed {{ $class }}">
    {{ $text }}
</button>
