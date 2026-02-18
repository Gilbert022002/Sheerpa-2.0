<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Sheerpa</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7ec9df", // Bleu Sheerpa
                        "secondary": "#ef5e21", // Orange Sheerpa
                        "background-light": "#f6f6f8",
                        "card-light": "#ffffff",
                        "text-main-light": "#121118",
                        "text-sub-light": "#686189",
                        "border-light": "#f1f0f4",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem"
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .soft-shadow {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col items-center justify-center p-6">

    <div class="w-full max-w-md">
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-16 w-auto object-contain">
        </div>

        <div class="bg-card-light rounded-3xl p-8 md:p-10 soft-shadow border border-border-light">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-black mb-2">Welcome Back</h1>
                <p class="text-text-sub-light text-sm font-medium">Please enter your details to sign in</p>
            </div>

            @if (session('message'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold text-sm mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-bold px-1" for="email">Email</label>
                    <div class="flex items-center rounded-xl bg-background-light border border-transparent focus-within:border-primary/30 transition-all overflow-hidden">
                        <div class="pl-4 text-text-sub-light flex items-center">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            placeholder="alex@example.com"
                            class="w-full p-3.5 bg-transparent border-none focus:ring-0 text-sm font-medium outline-none"
                            required
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 px-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-sm font-bold" for="password">Password</label>
                        <a href="#" class="text-xs font-bold text-primary hover:text-secondary transition-colors">Forgot your password?</a>
                    </div>
                    <div class="flex items-center rounded-xl bg-background-light border border-transparent focus-within:border-primary/30 transition-all overflow-hidden">
                        <div class="pl-4 text-text-sub-light flex items-center">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            placeholder="••••••••"
                            class="w-full p-3.5 bg-transparent border-none focus:ring-0 text-sm font-medium outline-none"
                            required
                        >
                    </div>
                </div>

                <div class="flex items-center gap-3 px-1">
                    <input 
                        type="checkbox" 
                        name="remember"
                        id="remember" 
                        class="size-5 rounded border-border-light text-primary focus:ring-primary/20"
                    >
                    <label for="remember" class="text-sm font-medium text-text-sub-light cursor-pointer select-none">Remember me</label>
                </div>

                <button type="submit" class="w-full py-4 bg-primary hover:opacity-90 transition-all text-white rounded-xl font-bold text-sm tracking-wide soft-shadow mt-2">
                    Log in
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-border-light text-center">
                <p class="text-sm text-text-sub-light font-medium">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-secondary font-bold hover:underline ml-1">Create Account</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="#" class="inline-flex items-center gap-2 text-text-sub-light hover:text-primary transition-colors text-sm font-bold">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Back to website
            </a>
        </div>
    </div>

</body>
</html>