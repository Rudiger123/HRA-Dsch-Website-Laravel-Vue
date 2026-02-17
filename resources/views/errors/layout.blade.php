<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Erreur')</title>
    <link rel="shortcut icon" href="/images/logo-hrad.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-600: #00A651;
            --primary-700: #00884B;
            --primary-800: #006B3D;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
                @yield('icon')
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">HRA Dschang</h1>
            <p class="text-primary-100">Plateforme Administrative</p>
        </div>

        <!-- Error Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-6">
                <h2 class="text-5xl font-bold text-primary-600 mb-4">@yield('code', 'Erreur')</h2>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">@yield('message', 'Une erreur s\'est produite')</h3>
                <p class="text-gray-600">@yield('description')</p>
            </div>

            <!-- Additional Content -->
            @yield('content')

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col gap-3">
                <a href="/" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition duration-200 text-center">
                    Retour à l'accueil
                </a>
                @if(auth()->check())
                    <a href="/admin/dashboard" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition duration-200 text-center">
                        Tableau de bord
                    </a>
                @else
                    <a href="/admin/login" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition duration-200 text-center">
                        Connexion
                    </a>
                @endif
            </div>
        </div>

        <!-- Help Text -->
        <div class="mt-8 text-center">
            <p class="text-primary-100 text-sm">
                Besoin d'aide ?<br>
                <a href="mailto:contact@hradschang.com" class="text-white font-semibold hover:underline">Contactez le support</a>
            </p>
        </div>
    </div>
</body>
</html>
