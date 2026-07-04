@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-evergreen text-sm font-medium leading-5 text-evergreen focus:outline-none focus:border-evergreen transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-ink/60 hover:text-ink hover:border-brass-light focus:outline-none focus:text-ink focus:border-brass-light transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
