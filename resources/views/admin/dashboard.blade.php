<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .clickable-name { color: var(--primary-blue); cursor: pointer; font-weight: bold; text-decoration: underline; }
        .modern-select { padding: 8px; border-radius: 8px; border: 1px solid #ddd; outline: none; background: white; }
        .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background: rgba(0,0,0,0.7); backdrop-filter: blur(5px); }
        .modal-content { background: white; margin: 5% auto; padding: 25px; width: 55%; border-radius: 15px; position: relative; }
        .close-btn { position:absolute; right:20px; top:10px; cursor:pointer; font-size:28px; color: #333; }
        .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .product-img-frame { width: 100%; border-radius: 10px; border: 1px solid #eee; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="main-content">
    <div class="header-dashboard">
        <div class="header-title">
            <i class="fas fa-shield-halved"></i>
            <h2>TrustCare Admin</h2>
        </div>
        <div class="header-user">
            <span>Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout-modern">Logout</button></form>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-info"><h4>Total Requests</h4><p>{{ $messages->count() }}</p></div>
        </div>
        <div class="stat-card" style="border-left-color: var(--success);">
            <div class="stat-icon" style="color: var(--success);"><i class="fas fa-user-check"></i></div>
            <div class="stat-info"><h4>Active Users</h4><p>{{ \App\Models\User::where('role', 'user')->count() }}</p></div>
        </div>
    </div>

    <div class="table-container-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Assign Maintenance</th>
                    <th>Control</th>
                </tr>
            </thead>
     <tbody>
         @forelse($messages as $msg)
    <tr>
        <td>
            <div class="customer-info">
                <div class="avatar">{{ strtoupper(substr($msg->user->name, 0, 1)) }}</div>
                <span class="clickable-name"
                  style="color: #1b2d95; cursor: pointer; font-weight: bold; text-decoration: underline;"
                  onclick="openDetails('{{ $msg->user->name }}', '{{ $msg->user->phone }}', '{{ $msg->extracted_sn }}', '{{ addslashes($msg->content) }}', '{{ $msg->product_image }}', '{{ $msg->warranty_image }}')">
                  {{ $msg->user->name }}
                </span>
            </div>
        </td>
        <td>{{ $msg->subject }}</td>
        <td><span class="badge badge-pending">{{ $msg->status }}</span></td>
        <td>
            <form action="{{ route('admin.assign', $msg->id) }}" method="POST" class="assign-form">
                @csrf
                <select name="worker_name" class="modern-select" required>
                    <option value="" disabled selected>Select Worker...</option>
                    <option value="Ahmed">Worker One</option>

                </select>
                <button type="submit" class="btn-assign">Assign</button>
            </form>
        </td>
        <td>
            <form action="{{ route('admin.user.delete', $msg->user_id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-kick">Kick</button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="5">No requests found.</td></tr>
    @endforelse
</tbody>

<div id="detailsModal" class="modal">
    <div class="modal-content" style="width: 70%; max-width: 800px;">
        <span onclick="closeModal()" class="close-btn">&times;</span>
        <h2 style="border-bottom: 2px solid #1b2d95; padding-bottom: 10px; color: #1b2d95;">
            <i class="fas fa-info-circle"></i> Request Full Details
        </h2>

        <div class="modal-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px;">
            <div>
                <p><strong><i class="fas fa-user"></i> Customer:</strong> <span id="m-name"></span></p>
                <p><strong><i class="fas fa-phone"></i> Phone:</strong> <span id="m-phone" style="color: #28a745; font-weight: bold;"></span></p>
                <p><strong><i class="fas fa-barcode"></i> Serial Number:</strong> <span id="m-sn" style="color:red; font-weight:bold;"></span></p>
                <p><strong><i class="fas fa-edit"></i> Complaint:</strong></p>
                <div id="m-content" style="background:#f4f4f4; padding:15px; border-radius:10px; border:1px solid #ddd; min-height:100px; white-space: pre-wrap;"></div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px; border-left: 1px solid #eee; padding-left: 20px;">
                <div>
                    <p><strong><i class="fas fa-box"></i> Product Image:</strong></p>
                    <img id="m-p-img" src="" style="width: 100%; border-radius: 10px; border: 1px solid #ddd; display: none;">
                    <p id="m-p-no-img" style="color:#999; display: none;">No product photo available.</p>
                </div>
                <div>
                    <p><strong><i class="fas fa-id-card"></i> Warranty Card:</strong></p>
                    <img id="m-w-img" src="" style="width: 100%; border-radius: 10px; border: 1px solid #ddd; display: none;">
                    <p id="m-w-no-img" style="color:#999; display: none;">No warranty card uploaded.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function openDetails(name, phone, sn, content, p_img, w_img) {
    document.getElementById('m-name').innerText = name;
    document.getElementById('m-phone').innerText = phone;
    document.getElementById('m-sn').innerText = sn;
    document.getElementById('m-content').innerText = content;

    // --- 1. معالجة صورة المنتج ---
    let pImgTag = document.getElementById('m-p-img');
    let pNoImgText = document.getElementById('m-p-no-img');

    if (p_img && p_img !== 'null' && p_img !== '') {
        let finalPath = p_img.trim();

        // حل مشكلة الالتصاق: إذا كان يبدأ بـ products ولا توجد بعدها فاصلة
        if (finalPath.startsWith('products') && !finalPath.startsWith('products/')) {
            finalPath = finalPath.replace('products', 'products/');
        }
        // إذا كان المسار لا يحتوي على products نهائياً
        else if (!finalPath.includes('products/') && !finalPath.startsWith('http')) {
            finalPath = 'products/' + finalPath;
        }

        // تنظيف أي فواصل مائلة مكررة وبناء الرابط النهائي
        pImgTag.src = "/storage/" + finalPath.replace(/\/+/g, '/');
        pImgTag.style.display = 'block';
        if(pNoImgText) pNoImgText.style.display = 'none';
    } else {
        pImgTag.style.display = 'none';
        if(pNoImgText) pNoImgText.style.display = 'block';
    }

    // --- 2. معالجة صورة الضمان ---
    let wImgTag = document.getElementById('m-w-img');
    let wNoImgText = document.getElementById('m-w-no-img');

    if (w_img && w_img !== 'null' && w_img !== '') {
        // تنظيف المسار لضمان عدم وجود فواصل مائلة مكررة في البداية
        let cleanWPath = w_img.trim().replace(/^\/+/, '');
        wImgTag.src = "/storage/" + cleanWPath;
        wImgTag.style.display = 'block';
        if(wNoImgText) wNoImgText.style.display = 'none';
    } else {
        wImgTag.style.display = 'none';
        if(wNoImgText) wNoImgText.style.display = 'block';
    }

    document.getElementById('detailsModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
}

// إغلاق النافذة عند الضغط خارجها
window.onclick = function(event) {
    let modal = document.getElementById('detailsModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
</body>
</html>
