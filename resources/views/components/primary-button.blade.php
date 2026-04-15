<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-ugoro-orange-dark to-ugoro-green border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-ugoro-orange hover:to-ugoro-emerald focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-ugoro-emerald focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
