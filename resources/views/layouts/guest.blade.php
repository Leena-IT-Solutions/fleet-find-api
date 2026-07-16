<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WheelsTracker') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-glow {
                background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0) 50%);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-800 min-h-screen relative overflow-x-hidden flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
        <!-- Background Glows -->
        <div class="absolute inset-0 hero-glow pointer-events-none z-0"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none z-0"></div>

        <div class="relative z-10 flex-grow flex flex-col justify-between">
            @if ($plain ?? false)
                {{ $slot }}
            @else
                <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                    <div class="flex flex-col items-center">
                        <a href="/" wire:navigate class="flex flex-col items-center gap-2">
                            <x-application-logo class="w-16 h-16 object-contain" />
                            <span class="text-2xl font-bold tracking-tight text-slate-900">WheelsTracker</span>
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 backdrop-blur-xl border border-slate-200/80 shadow-2xl shadow-slate-200/50 overflow-hidden rounded-2xl">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/919096189183" target="_blank" class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 rounded-full bg-[#25D366] hover:bg-[#20ba5a] shadow-xl hover:scale-110 active:scale-95 transition-all duration-300 group" aria-label="Chat on WhatsApp">
            <svg class="w-7 h-7 text-white fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.733-1.464L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.59 1.978 14.12 1.9 12.012 1.9c-5.44 0-9.866 4.372-9.87 9.802 0 1.696.475 3.356 1.378 4.793l-.997 3.645 3.734-.969zm10.963-3.561c-.301-.15-1.784-.879-2.057-.978-.273-.099-.471-.148-.669.15-.197.299-.767.978-.94.178-.173-.199-.347-.399-.575-.598-.567-.506-1.127-1.127-1.554-1.637-.425-.51-.122-.786-.068-.893.054-.108.12-.239.18-.359.061-.12.09-.208.136-.299.045-.09.022-.17-.01-.249-.033-.079-.669-1.611-.917-2.207-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.299-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.199 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.784-.73 2.032-1.432.248-.699.248-1.298.173-1.422-.074-.124-.272-.198-.57-.347z"/>
            </svg>
            <span class="absolute right-16 scale-0 group-hover:scale-100 bg-slate-900/90 backdrop-blur text-white text-[10px] font-bold px-3 py-1.5 rounded-lg border border-slate-800 transition-all duration-200 whitespace-nowrap shadow-xl">
                Chat on WhatsApp
            </span>
        </a>
    </body>
</html>
