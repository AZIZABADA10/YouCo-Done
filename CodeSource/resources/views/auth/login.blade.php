<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sign In - Youco'Done</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#437055",
                        "background-light": "#f6f7f7",
                        "background-dark": "#161c18",
                        "brand-accent": "#EBF4DD",
                        "brand-btn": "#5A7863",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display flex flex-col min-h-screen text-[#121614] dark:text-gray-100 overflow-x-hidden transition-colors duration-300">
    <!-- Header -->
    <header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-[#ebefed] dark:border-neutral-800 px-6 lg:px-10 py-3 bg-white/80 dark:bg-[#161c18]/90 backdrop-blur-md">
        <div class="flex items-center gap-4">
            <div class="size-8 flex items-center justify-center text-primary rounded-lg bg-primary/10">
                <span class="material-symbols-outlined text-2xl">restaurant_menu</span>
            </div>
            <h2 class="text-[#121614] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Youco'Done</h2>
        </div>
        <div class="flex flex-1 justify-end gap-8">
            <div class="hidden md:flex items-center gap-9">
                <a class="text-[#121614] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors" href="/">Home</a>
                <a class="text-[#121614] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors" href="#">About Us</a>
                <a class="text-[#121614] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors" href="#">Contact</a>
            </div>
            <div class="flex gap-2">
                <button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-primary/10 text-primary dark:text-primary-400 hover:bg-primary/20 dark:hover:bg-primary/20 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
                    <span class="truncate">Sign Up</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center py-12 px-4 relative">
        <!-- Background Gradients -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute top-0 left-0 w-[800px] h-[800px] bg-brand-accent/40 dark:bg-primary/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-brand-accent/30 dark:bg-primary/5 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-[480px] flex flex-col bg-brand-accent dark:bg-[#1e2621] rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-black/20 border border-[#d8dfdb] dark:border-neutral-800 overflow-hidden">
            <!-- Header -->
            <div class="pt-8 pb-2 px-8 text-center">
                <h1 class="text-[#121614] dark:text-white tracking-tight text-3xl font-bold leading-tight mb-3">Welcome Back</h1>
                <p class="text-[#516358] dark:text-gray-400 text-sm font-normal leading-relaxed">
                    Sign in to your Youco'Done account
                </p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mx-8 mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">error</span>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-red-800 dark:text-red-300 mb-1">Whoops! Something went wrong.</h3>
                            <ul class="text-xs text-red-700 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Message -->
            @session('status')
                <div class="mx-8 mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">check_circle</span>
                        <p class="text-sm text-green-700 dark:text-green-300">{{ $value }}</p>
                    </div>
                </div>
            @endsession

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="px-8 pb-8 pt-6 flex flex-col gap-5">
                @csrf

                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label class="text-[#121614] dark:text-gray-200 text-sm font-bold" for="email">Email Address</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#677e70] transition-colors group-focus-within:text-primary">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input 
                            class="w-full h-11 pl-10 pr-4 rounded-lg border border-transparent dark:border-neutral-700 bg-white dark:bg-neutral-800 text-[#121614] dark:text-white placeholder:text-[#677e70]/60 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm shadow-sm" 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="name@example.com"
                        />
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5">
                    <label class="text-[#121614] dark:text-gray-200 text-sm font-bold" for="password">Password</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#677e70] transition-colors group-focus-within:text-primary">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input 
                            class="w-full h-11 pl-10 pr-10 rounded-lg border border-transparent dark:border-neutral-700 bg-white dark:bg-neutral-800 text-[#121614] dark:text-white placeholder:text-[#677e70]/60 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm shadow-sm" 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-[#677e70] hover:text-[#121614] dark:hover:text-white transition-colors cursor-pointer" type="button" onclick="togglePassword()">
                            <span class="material-symbols-outlined text-[20px]" id="toggleIcon">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <input 
                            class="w-4 h-4 rounded border-gray-400 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-primary focus:ring-primary/20 cursor-pointer" 
                            id="remember_me" 
                            type="checkbox"
                            name="remember"
                        />
                        <label class="text-sm text-[#516358] dark:text-gray-400 cursor-pointer select-none" for="remember_me">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary font-semibold hover:underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Sign In Button -->
                <button class="mt-2 w-full h-11 bg-brand-btn hover:bg-[#4a6352] text-white font-bold rounded-lg shadow-md shadow-brand-btn/20 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2" type="submit">
                    <span>Sign In</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>

                <!-- Divider -->
                <div class="relative py-2">
                    <div aria-hidden="true" class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#dce5de] dark:border-neutral-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-brand-accent dark:bg-[#1e2621] text-[#677e70] text-xs uppercase tracking-wider font-semibold">Or sign in with</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button class="flex items-center justify-center h-10 bg-white/60 dark:bg-neutral-800 border border-white/40 dark:border-neutral-700 rounded-lg hover:bg-white dark:hover:bg-neutral-700 transition-colors shadow-sm" type="button">
                        <span class="text-sm font-semibold text-[#121614] dark:text-gray-200">Google</span>
                    </button>
                    <button class="flex items-center justify-center h-10 bg-white/60 dark:bg-neutral-800 border border-white/40 dark:border-neutral-700 rounded-lg hover:bg-white dark:hover:bg-neutral-700 transition-colors shadow-sm" type="button">
                        <span class="text-sm font-semibold text-[#121614] dark:text-gray-200">Apple</span>
                    </button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center pt-2">
                    <p class="text-sm text-[#516358] dark:text-gray-400">
                        Don't have an account? 
                        <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Sign Up</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Security Badge -->
        <div class="mt-8 flex items-center gap-6 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#677e70]">lock</span>
                <span class="text-xs text-[#677e70] font-medium">Secure SSL Encryption</span>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility_off';
            }
        }
    </script>
</body>
</html>