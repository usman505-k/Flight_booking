<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .content {
            flex: 1;
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.flights') }}">Flights</a>
    <a href="{{ route('admin.bookings') }}">Bookings</a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
