<!DOCTYPE html>
<html>
<head>
    <title>Shoe Products</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
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

        .menu a:hover {
            background: #1e293b;
        }

        .active {
            background: #2563eb;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 25px;
        }

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
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f5f9;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
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
            <a class="active" href="{{ route('shoe-products.index') }}">Shoe Products</a>
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
            <h2>Shoe Products</h2>

            <button class="btn btn-add" onclick="openAddModal()">
                + Add Product
            </button>
        </div>

        <table>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Size</th>
                <th>Color</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            @foreach($shoeProducts as $product)

            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->color }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>₱{{ $product->price }}</td>

                <td>

                    <!-- EDIT BUTTON -->
                    <button type="button"
                            class="btn btn-edit"
                            onclick="openEditModal(
                                '{{ $product->id }}',
                                '{{ $product->product_name }}',
                                '{{ $product->brand }}',
                                '{{ $product->category }}',
                                '{{ $product->size }}',
                                '{{ $product->color }}',
                                '{{ $product->stock_quantity }}',
                                '{{ $product->price }}'
                            )">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <form method="POST"
                          action="{{ route('shoe-products.destroy', $product->id) }}"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-delete"
                                onclick="return confirm('Delete this product?')">
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

        <h3>Add Product</h3>

        <form method="POST" action="{{ route('shoe-products.store') }}">
            @csrf

            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="text" name="brand" placeholder="Brand" required>

            <select name="category" required>
                <option value="">Category</option>
                <option>Sneakers</option>
                <option>Running Shoes</option>
                <option>Sandals</option>
                <option>Boots</option>
                <option>Formal Shoes</option>
            </select>

            <select name="size" required>
                <option value="">Size</option>
                <option>US 5 / EU 35</option>                                                                                                
                <option>US 6 / EU 36-37</option>                                                                                                         
                <option>US 7 / EU 38</option>                                                                                                          
                <option>US 8 / EU 39</option>                                                                                                                   
                <option>US 9 / EU 40</option>                                                                                                                                       
                <option>US 10 / EU 41</option>                                                                                                             
                <option>US 11 / EU 42</option>                                                                                                         
                <option>US 12 / EU 43</option>
            </select>

            <select name="color" required>
                <option value="">Color</option>
                <option>Black</option>
                <option>White</option>
                <option>Brown</option>
                <option>Red</option>
                <option>Blue</option>
            </select>

            <input type="number" name="stock_quantity" placeholder="Stock" required>
            <input type="number" name="price" placeholder="Price" required>

            <button class="btn btn-add" type="submit">
                Save Product
            </button>

        </form>

    </div>
</div>

<div class="modal" id="editModal">

    <div class="modal-content">

        <span class="close" onclick="closeEditModal()">&times;</span>

        <h3>Edit Product</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="product_name" id="edit_product_name" required>
            <input type="text" name="brand" id="edit_brand" required>

            <select name="category" id="edit_category" required>
                <option>Sneakers</option>
                <option>Running Shoes</option>
                <option>Sandals</option>
                <option>Boots</option>
                <option>Formal Shoes</option>
            </select>

            <select name="size" id="edit_size" required>
                <option>US 5 / EU 35</option>
                <option>US 6 / EU 36-37</option>
                <option>US 7 / EU 38</option>
                <option>US 8 / EU 39</option>
                <option>US 9 / EU 40</option>
                <option>US 10 / EU 41</option>
                <option>US 11 / EU 42</option>
                <option>US 12 / EU 43</option>
            </select>

            <select name="color" id="edit_color" required>
                <option>Black</option>
                <option>White</option>
                <option>Brown</option>
                <option>Red</option>
                <option>Blue</option>
            </select>

            <input type="number" name="stock_quantity" id="edit_stock" required>
            <input type="number" name="price" id="edit_price" required>

            <button class="btn btn-add" type="submit">
                Update Product
            </button>

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

    function openEditModal(id, name, brand, category, size, color, stock, price) {

        document.getElementById('editModal').style.display = 'flex';

        document.getElementById('edit_product_name').value = name;
        document.getElementById('edit_brand').value = brand;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_size').value = size.trim();
        document.getElementById('edit_size').dispatchEvent(new Event('change'));
        document.getElementById('edit_color').value = color;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_price').value = price;

        document.getElementById('editForm').action = "/shoe-products/" + id;
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    }
</script>

</body>
</html>