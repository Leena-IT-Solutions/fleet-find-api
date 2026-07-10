@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-800 bg-slate-950/60 text-slate-100 placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg shadow-sm transition duration-150 ease-in-out']) }}>
