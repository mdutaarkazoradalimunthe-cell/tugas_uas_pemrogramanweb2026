@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-mist focus:border-evergreen focus:ring-evergreen rounded-lg shadow-none']) }}>
