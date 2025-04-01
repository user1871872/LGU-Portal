<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | LGU-ANDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">   
</head>
<body>

    @include('layouts.partials.navbar') 

    <div class="d-flex">
        @include('layouts.partials.user.sidebar') 
        
        <div class="main-content p-4 flex-grow-1">
            @yield('content')
        </div>
    </div>

    @include('layouts.partials.footer') 

</body>
</html>
