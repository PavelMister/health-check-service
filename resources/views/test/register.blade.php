<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Реєстрація - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        function onSubmit(token) {
            document.getElementById("register").submit();
        }
    </script>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans">

<header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
    <nav class="flex items-center justify-end gap-4">
        <span class="text-[#706f6c] dark:text-[#A1A09A]">{{ __('Вже маєте акаунт?') }}</span>
        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-all">
            {{ __('Увійти') }}
        </a>
    </nav>
</header>

<div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow">
    <main class="flex max-w-[335px] w-full flex-col lg:max-w-4xl lg:flex-row shadow-sm rounded-lg overflow-hidden border border-[#19140015] dark:border-[#3E3E3A]">

        {{-- Ліва частина: Інфо --}}
        <div class="flex-1 p-8 lg:p-12 bg-white dark:bg-[#161615] dark:text-[#EDEDEC]">
            <h1 class="text-2xl font-semibold mb-2">{{ __('Створити акаунт') }}</h1>
            <p class="mb-8 text-[#706f6c] dark:text-[#A1A09A]">{{ __('Приєднуйтесь до нашої спільноти та отримайте доступ до всіх можливостей.') }}</p>

            <ul class="space-y-4 text-sm">
                <li class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600">✓</div>
                    <span>{{ __('Безкоштовний доступ до API') }}</span>
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600">✓</div>
                    <span>{{ __('Підтримка 24/7') }}</span>
                </li>
            </ul>
        </div>

        {{-- Права частина: Форма --}}
        <div class="flex-1 p-8 lg:p-12 bg-[#FDFDFC] dark:bg-[#111110] border-t lg:border-t-0 lg:border-l border-[#19140015] dark:border-[#3E3E3A]">
            <form method="POST" id="register" action="/api/v1/users/register" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('Ім\'я') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] focus:ring-2 focus:ring-[#f53003] outline-none transition-all">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] focus:ring-2 focus:ring-[#f53003] outline-none transition-all">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">{{ __('Пароль') }}</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] focus:ring-2 focus:ring-[#f53003] outline-none transition-all">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">{{ __('Підтвердіть пароль') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] focus:ring-2 focus:ring-[#f53003] outline-none transition-all">
                </div>

                @error('g-recaptcha-response') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror

                <button
                    type="submit"
                    class="g-recaptcha w-full py-2.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1c1c1a] rounded-sm font-medium hover:bg-black dark:hover:bg-white transition-colors shadow-sm"
                    data-sitekey="{{ config('app.recaptcha.site') }}"
                    data-callback='onSubmit'
                    data-action='submit'
                >
                    {{ __('Зареєструватися') }}
                </button>
            </form>
        </div>
    </main>
</div>

<footer class="mt-8 text-[#706f6c] text-xs">
    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</footer>

</body>
</html>
