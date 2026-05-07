<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>

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

        .readonly-box {
            background: #f3f4f6;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
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
            <a href="{{ route('orders.index') }}">Orders</a>
            <a class="active" href="{{ route('payments.index') }}">Payments</a>

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
            <h2>Payments</h2>

            <button class="btn btn-add" onclick="openAddModal()">
                + Add Payment
            </button>
        </div>

        <table>
            <tr>
                <th>Order</th>
                <th>Amount Paid</th>
                <th>Remaining</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @foreach($payments as $payment)
            <tr>
                <td>
                    #{{ $payment->order_id }}
                    <br>
                    <small>{{ $payment->order->customer_name }}</small>
                </td>

                <td>₱{{ $payment->amount_paid }}</td>
                <td>₱{{ $payment->remaining_balance }}</td>
                <td><b>{{ $payment->payment_status }}</b></td>

                <td>
                    <button class="btn btn-edit"
                        onclick="openEditModal(
                            {{ $payment->id }},
                            '{{ $payment->order->customer_name }}',
                            {{ $payment->amount_paid }},
                            {{ $payment->remaining_balance }}
                        )">
                        Edit
                    </button>

                    <form method="POST"
                          action="{{ route('payments.destroy', $payment->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-delete"
                            onclick="return confirm('Delete this payment?')">
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

        <h3>Add Payment</h3>

        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            <select name="order_id" required>
                <option value="">Select Order</option>

                @foreach($orders as $order)
                    <option value="{{ $order->id }}">
                        Order #{{ $order->id }} -
                        {{ $order->customer_name }}
                        (₱{{ $order->total_cost }})
                    </option>
                @endforeach
            </select>

            <input type="number" step="0.01" name="amount_paid" placeholder="Amount Paid" required>

            <button class="btn btn-add">Save Payment</button>
        </form>

    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">

        <span class="close" onclick="closeEditModal()">&times;</span>

        <h3>Edit Payment</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="readonly-box">
                <b>Customer:</b> <span id="edit_customer"></span>
            </div>

            <div class="readonly-box">
                <b>Previous Paid:</b> ₱<span id="old_amount"></span>
            </div>

            <div class="readonly-box">
                <b>Remaining:</b> ₱<span id="old_balance"></span>
            </div>

            <input type="number"
                   step="0.01"
                   name="amount_paid"
                   id="new_amount"
                   placeholder="Enter NEW payment amount"
                   required>

            <button class="btn btn-add">Update Payment</button>

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

    function openEditModal(id, customer, oldAmount, oldBalance) {
        document.getElementById('editModal').style.display = 'flex';

        document.getElementById('edit_customer').innerText = customer;
        document.getElementById('old_amount').innerText = oldAmount;
        document.getElementById('old_balance').innerText = oldBalance;

        document.getElementById('new_amount').value = "";

        document.getElementById('editForm').action = "/payments/" + id;
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

</body>
</html>