<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-evergreen border border-transparent rounded-md font-semibold text-xs text-paper uppercase tracking-widest hover:bg-evergreen-dark focus:bg-evergreen-dark active:bg-evergreen-dark focus:outline-none focus:ring-2 focus:ring-evergreen focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
