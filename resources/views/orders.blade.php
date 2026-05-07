<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
        }

        .btn-add { background: #2563eb; }
        .btn-edit { background: #f59e0b; }
        .btn-delete { background: #ef4444; }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th { background: #f1f5f9; }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            width: 420px;
            border-radius: 10px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>

<x-app-layout>

<div class="wrapper">

    <div class="sidebar">
        <h2>👟 Shoe Store</h2>

        <div class="menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('shoe-products.index') }}">Shoe Products</a>
            <a class="active" href="{{ route('orders.index') }}">Orders</a>
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
            <h2>Orders</h2>

            <button class="btn btn-add" onclick="openAddModal()">
                + Add Order
            </button>
        </div>

        <table>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @foreach($orders as $order)
            <tr>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->shoeProduct->product_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱{{ $order->total_cost }}</td>
                <td>{{ $order->status }}</td>

                <td>
                    <button class="btn btn-edit"
                        onclick="openEditModal(
                            {{ $order->id }},
                            '{{ addslashes($order->customer_name) }}',
                            {{ $order->shoe_product_id }},
                            {{ $order->quantity }},
                            '{{ $order->status }}'
                        )">
                        Edit
                    </button>

                    <form method="POST"
                          action="{{ route('orders.destroy', $order->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-delete"
                            onclick="return confirm('Delete this order?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

    </div>
</div>

<div class="modal" id="addModal">
    <div class="modal-content">

        <span class="close" onclick="closeAddModal()">&times;</span>

        <h3>Add Order</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            <input type="text" name="customer_name" placeholder="Customer Name" required>

            <select name="shoe_product_id" required>
                <option value="">Select Product</option>
                @foreach($shoeProducts as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->product_name }} - ₱{{ $product->price }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="quantity" placeholder="Quantity" required>

            <input type="hidden" name="status" value="Pending">

            <button class="btn btn-add">Save Order</button>

        </form>

    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">

        <span class="close" onclick="closeEditModal()">&times;</span>

        <h3>Edit Order</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text" id="edit_customer" name="customer_name" required>

            <select name="shoe_product_id" id="edit_product" required>
                @foreach($shoeProducts as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="quantity" id="edit_quantity" required>

            <select name="status" id="edit_status" required>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
            </select>

            <button class="btn btn-add">Update Order</button>
        </form>

    </div>
</div>

</x-app-layout>

<script>
    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    function openEditModal(id, customer, product, qty, status) {
        document.getElementById('editModal').style.display = 'flex';

        document.getElementById('edit_customer').value = customer;
        document.getElementById('edit_product').value = product;
        document.getElementById('edit_quantity').value = qty;
        document.getElementById('edit_status').value = status;

        document.getElementById('editForm').action = "/orders/" + id;
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('editForm').reset();
    }

    window.onclick = function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    }
</script>

</body>
</html>