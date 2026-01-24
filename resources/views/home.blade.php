<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare - Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-flow.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* التنسيقات الإضافية للخطوات */
        .step-box { transition: 0.4s; }
        .product-preview img { cursor: pointer; transition: 0.3s; border: 2px solid transparent; }
        .product-preview img:hover { transform: scale(1.05); border-color: #1b2d95; }
        .overlay-text { pointer-events: none; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">
            <img src="{{ asset('image/logo-icon.png') }}" alt="Logo" class="nav-logo">
            TrustCare
        </div>
        <div style="display: flex; align-items: center; gap: 20px;">
            <span>Welcome, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

       <div class="request-card">
    <h3 class="section-title"><i class="fas fa-tools"></i> New Maintenance Request</h3>
@if ($errors->any())
    <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f87171;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('send.message') }}" method="POST" enctype="multipart/form-data" id="mainRequestForm">
        @csrf

        <div class="form-group">
            <label><i class="fas fa-id-card"></i> 1. Upload Warranty Card (Image)</label>
            <input type="file" name="warranty_image" class="form-control" accept="image/*" required>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label><i class="fas fa-barcode"></i> 2. Enter Product Serial Number</label>
            <div class="search-wrapper">
                <input type="text" id="sn_input" name="serial_number" placeholder="Enter SN..." required>
                <button type="button" onclick="checkProduct()" class="search-btn">Check Product</button>
            </div>
        </div>

        <div id="product-display" class="product-preview" style="display:none; margin: 20px 0; padding: 15px; border: 1px dashed #ccc; background-color: #f9f9f9;">
    <p class="found-text" style="color: green; font-weight: bold;">Product Identified:</p>
    <div style="display: flex; gap: 20px; align-items: flex-start;">
        <img id="p-img" src="" alt="Product" style="max-width: 150px; border-radius: 8px;">
        <div>
            <h4 id="p-name" style="margin-top: 0;"></h4>
            <div id="error-guide" style="display:none; margin-top: 10px; font-size: 0.9em; background: #fff; padding: 10px; border-radius: 5px; border: 1px solid #eee;">
                <p style="margin-bottom: 5px; color: #d32f2f; font-weight: bold;"><i class="fas fa-info-circle"></i> Common Error Codes:</p>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li><strong>E1:</strong> Room temperature sensor</li>
                    <li><strong>E3:</strong> Evaporator temperature sensor</li>
                    <li><strong>E4:</strong>Internal fan motor</li>
                </ul>
            </div>
        </div>
    </div>
</div>

        <div class="form-group" style="margin-top: 20px;">
            <label><i class="fas fa-edit"></i> 3. Describe the Problem</label>
            <textarea name="content" rows="4" placeholder="Describe the defect in detail..." required></textarea>
        </div>

        <button type="submit" class="submit-btn-final">Submit Final Request</button>
    </form>
</div>
        <h3 class="section-title"><i class="fas fa-history"></i> Your Requests History</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Warranty</th>
                        <th>Worker</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr>
                        <td><strong>{{ $msg->subject }}</strong></td>
                        <td><span class="status-badge status-{{ $msg->status }}">{{ $msg->status }}</span></td>
                        <td>
                            @if($msg->warranty_image)
                                <a href="{{ asset('storage/'.$msg->warranty_image) }}" target="_blank">View Card</a>
                            @endif
                        </td>
                        <td>{{ $msg->worker_name ?? 'Pending...' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;">No requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<script>
    function checkProduct() {
    let sn = document.getElementById('sn_input').value.trim();
    if (!sn) {
        alert("Please enter Serial Number.");
        return;
    }

    fetch(`/search-product/${sn}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('product-display').style.display = 'block';
                document.getElementById('p-name').innerText = data.product.name;
                document.getElementById('p-img').src = data.product.image;

                // التحقق من الرقم التسلسلي الخاص بالمكيف
                let errorGuide = document.getElementById('error-guide');
                if (sn === "0666456") {
                    errorGuide.style.display = 'block'; // إظهار الأكواد
                } else {
                    errorGuide.style.display = 'none'; // إخفاؤها للمنتجات الأخرى
                }
            } else {
                alert("Warning: Serial number not found in our database.");
                document.getElementById('product-display').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Connection error during search.");
        });
}
</script>
</body>
</html>
