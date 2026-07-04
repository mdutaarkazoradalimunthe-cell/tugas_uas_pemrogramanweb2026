@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-evergreen text-start text-base font-medium text-evergreen bg-evergreen/5 focus:outline-none focus:text-evergreen focus:bg-evergreen/10 focus:border-evergreen transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-ink/70 hover:text-ink hover:bg-mist/40 hover:border-brass-light focus:outline-none focus:text-ink focus:bg-mist/40 focus:border-brass-light transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
