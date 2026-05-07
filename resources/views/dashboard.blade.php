<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px;
            background: #0f172a;
            color: white;
            padding: 20px;
        }

        .menu a {
            display: block;
            padding: 12px;
            margin: 5px 0;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .menu a:hover { background: #1e293b; }
        .active { background: #2563eb; }

        .content { flex: 1; padding: 25px; }

        .header {
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .card h1 {
            font-size: 18px;
            margin: 0;
        }

        .card p {
            font-size: 32px;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<x-app-layout>

<div class="wrapper">

    <div class="sidebar">
        <h2>👟 Shoe Store</h2>

        <div class="menu">
            <a class="active" href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('shoe-products.index') }}">Shoe Products</a>
            <a href="{{ route('orders.index') }}">Orders</a>
            <a href="{{ route('payments.index') }}">Payments</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="w-full text-left px-4 py-2 rounded text-white
                        hover:bg-red-600
                        active:bg-red-700
                        transition">
                    Logout
                </button>
            </form>
        </div>
    </div>


    <div class="content">

        <div class="header">
            <h2>Dashboard</h2>
        </div>

        <div class="grid">

            <div class="card">
                <h1>Total Products</h1>
                <p>{{ $totalProducts }}</p>
            </div>

            <div class="card">
                <h1>Total Orders</h1>
                <p>{{ $totalOrders }}</p>
            </div>

            <div class="card">
                <h1>Total Payments</h1>
                <p>{{ $totalPayments }}</p>
            </div>

        </div>

    </div>

</div>

</x-app-layout>

</body>
</html>