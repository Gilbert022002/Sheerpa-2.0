<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Email non vérifié - Sheerpa</title>
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
                        "primary": "#7ec9df",
                        "secondary": "#ef5e21",
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

        <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light text-center">
            <div class="mb-6">
                <span class="material-symbols-outlined text-6xl text-secondary">mark_email_unread</span>
            </div>

            <h1 class="text-2xl font-black mb-4">Email non vérifié</h1>
            
            <p class="text-text-sub-light text-sm mb-6">
                Vous devez vérifier votre adresse email avant de pouvoir accéder à votre compte. 
                Vérifiez votre boîte de réception et cliquez sur le lien de vérification.
            </p>

            @if (session('message'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold text-sm mb-6">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('resent'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl font-bold text-sm mb-6">
                    Un nouvel email de vérification a été envoyé !
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-primary hover:opacity-90 transition-all text-white rounded-xl font-bold text-sm tracking-wide soft-shadow">
                    <span class="material-symbols-outlined text-sm align-middle mr-2">send</span>
                    Renvoyer l'email de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-text-sub-light text-sm font-bold hover:text-secondary transition-colors">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>

</body>
</html>
