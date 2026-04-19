<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shomobay Cart Manager</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            color: #1f2937;
            min-height: 100vh;
        }

        .container {
            width: 92%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .hero {
            background: linear-gradient(135deg, #1d4ed8, #2563eb, #3b82f6);
            color: white;
            padding: 35px 30px;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.25);
            margin-bottom: 30px;
        }

        .hero h1 {
            font-size: 34px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .hero p {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.6;
            max-width: 750px;
        }

        .badge-row {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .badge {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.12);
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #111827;
        }

        .card p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .section-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .icon-cart {
            background: #dbeafe;
            color: #2563eb;
        }

        .icon-item {
            background: #dcfce7;
            color: #16a34a;
        }

        .icon-join {
            background: #ede9fe;
            color: #7c3aed;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            outline: none;
            transition: border 0.2s ease, box-shadow 0.2s ease;
            background: #f9fafb;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
            background: white;
        }

        button {
            width: 100%;
            padding: 13px 16px;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-blue {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .btn-green {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .btn-purple {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
        }

        .info-panel {
            margin-top: 30px;
            background: white;
            border-radius: 18px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        }

        .info-panel h3 {
            margin-bottom: 12px;
            font-size: 22px;
            color: #111827;
        }

        .info-panel p {
            color: #4b5563;
            line-height: 1.8;
            font-size: 15px;
        }

        .steps {
            margin-top: 14px;
            display: grid;
            gap: 12px;
        }

        .step {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            color: #374151;
        }

        .footer {
            text-align: center;
            margin: 30px 0 10px;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .hero h1 {
                font-size: 28px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="hero">
            <h1>Shomobay Cart Manager Dashboard</h1>
            <p>
                Manage the core neighbourhood bulk-buying workflow from one screen.
                Create a shared building cart, add products, accept neighbour contributions,
                and support the dynamic price-drop model for Sprint 3.
            </p>

            <div class="badge-row">
                <div class="badge">Neighborhood Group Cart Engine</div>
                <div class="badge">Dynamic Price Drop</div>
                <div class="badge">Countdown-Aware Contributions</div>
                <div class="badge">Threshold Control</div>
            </div>
        </div>

        <div class="grid">

            <div class="card">
                <div class="section-icon icon-cart">🛒</div>
                <h2>Create Group Cart</h2>
                <p>Create a building-specific shared cart with a target weight and expiry time.</p>

                <form method="POST" action="/cart/create">
                    <?php echo csrf_field(); ?>

                    <label>Building Name</label>
                    <input type="text" name="building_name" placeholder="e.g. Block B" required>

                    <label>Target Weight (kg)</label>
                    <input type="number" name="target_weight" step="0.01" placeholder="e.g. 100" required>

                    <label>Expires At</label>
                    <input type="datetime-local" name="expires_at" required>

                    <button type="submit" class="btn-blue">Create Cart</button>
                </form>
            </div>

            <div class="card">
                <div class="section-icon icon-item">📦</div>
                <h2>Add Item to Cart</h2>
                <p>Add bulk items such as rice, onions, or potatoes into an active group cart.</p>

                <form method="POST" action="/cart/add-item">
                    <?php echo csrf_field(); ?>

                    <label>Cart ID</label>
                    <input type="number" name="group_cart_id" placeholder="Enter cart ID" required>

                    <label>Product Name</label>
                    <input type="text" name="product_name" placeholder="e.g. Rice" required>

                    <label>Base Price per KG</label>
                    <input type="number" name="base_price_per_kg" step="0.01" placeholder="e.g. 60" required>

                    <button type="submit" class="btn-green">Add Item</button>
                </form>
            </div>

            <div class="card">
                <div class="section-icon icon-join">👥</div>
                <h2>Add Contribution</h2>
                <p>Let neighbours join the cart by contributing a required weight for a selected item.</p>

                <form method="POST" action="/cart/add-contribution">
                    <?php echo csrf_field(); ?>

                    <label>Cart ID</label>
                    <input type="number" name="group_cart_id" placeholder="Enter cart ID" required>

                    <label>Cart Item ID</label>
                    <input type="number" name="cart_item_id" placeholder="Enter item ID" required>

                    <label>Weight Requested (kg)</label>
                    <input type="number" name="weight_requested" step="0.01" placeholder="e.g. 5" required>

                    <button type="submit" class="btn-purple">Add Contribution</button>
                </form>
            </div>

        </div>

        <div class="info-panel">
            <h3>Demo Flow</h3>
            <p>
                For a clean presentation, first create a new cart, then add one product to that cart,
                and finally submit one or more contributions. After each action, verify the backend output
                in phpMyAdmin to show weight growth, contribution records, cart status updates, and dynamic price changes.
            </p>

            <div class="steps">
                <div class="step"><strong>Step 1:</strong> Create a fresh cart with a future expiry date and a realistic target weight.</div>
                <div class="step"><strong>Step 2:</strong> Add an item such as Rice with a base price per kilogram.</div>
                <div class="step"><strong>Step 3:</strong> Add contributions using the cart ID and item ID.</div>
                <div class="step"><strong>Step 4:</strong> Show how current weight updates and how price drops as the total increases.</div>
                <div class="step"><strong>Step 5:</strong> Demonstrate cart locking once target weight is reached or expiry time passes.</div>
            </div>
        </div>

        <div class="footer">
            Shomobay Sprint 3 • Cart Manager Professional Demo UI
        </div>

    </div>
</body>
</html>