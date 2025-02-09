<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LGU-ANDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
</head>
<style>
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        left: 0;
        top: 56px;
        background: #343a40;
        color: white;
        padding-top: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .main-content {
        margin-left: 250px;
        padding: 20px;
        flex-grow: 1;
    }
    .sidebar .nav-link {
        color: white;
        padding: 10px 20px;
        display: block;
    }
    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
<body>

    @include('layouts.partials.navbar')
    
    <div class="d-flex">
        @include('layouts.partials.admin.sidebar') 
        
        <div class="main-content p-4 flex-grow-1">
            @yield('content')  
        </div>
    </div>

    @include('layouts.partials.footer')

</body>
</html>
