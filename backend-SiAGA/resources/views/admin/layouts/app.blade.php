<!DOCTYPE html>

<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>FloodMon Admin Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#607afb",
                        "background-light": "#f5f6f8",
                        "background-dark": "#0f1323",
                        "surface-dark": "#1a1d2d",
                        "border-dark": "#272a3a",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"],
                        body: ["Noto Sans", "sans-serif"],
                    }
                }
            }
        }
    </script>
    @yield('css')
    @livewireStyles
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display overflow-hidden selection:bg-primary selection:text-white">

    @yield('content')

    @livewireScripts

    @yield('script')

</body>

</html>
