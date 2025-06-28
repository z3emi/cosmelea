<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'Cosmelea') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-bg': '#f9f5f1',
                        'brand-primary': '#cd8985',
                        'brand-secondary': '#dcaca9',
                        'brand-dark': '#be6661',
                        'brand-light': '#eadbcd',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .form-input {
            border-color: #eadbcd;
        }
        .form-input:focus {
            border-color: #cd8985;
            box-shadow: 0 0 0 1px #cd8985;
            outline: none;
        }
        .form-input.is-invalid {
             border-color: #ef4444; /* red-500 */
        }
    </style>
</head>
<body class="bg-brand-bg">
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-4xl font-bold" style="color: #cd8985;">
                Cosmelea
            </a>
        </div>

        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            @yield('content')
        </div>
    </div>
</body>
</html>
