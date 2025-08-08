<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Go Library</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    @include('partials.navbar')
    
    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Main Content -->
        @yield('content')
    </main>

    <!-- SweetAlert2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.all.min.js"></script>
    
    <!-- Toast Notifications Script -->
    <script>
        // Configure SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Success notification
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        // Error notification
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Warning notification
        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif

        // Info notification
        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>