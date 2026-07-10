<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-slate-800 rounded-lg font-semibold text-xs text-slate-300 uppercase tracking-widest shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
