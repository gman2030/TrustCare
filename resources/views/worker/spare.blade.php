@extends('layouts.worker-master')

@section('styles')
<style>
    .search-container {
        max-width: 600px;
        margin: 50px auto;
        text-align: center;
    }
    .search-box {
        display: flex;
        gap: 10px;
        background: white;
        padding: 10px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }
    .search-box input {
        flex: 1;
        border: none;
        padding: 15px;
        font-size: 16px;
        outline: none;
    }
    .search-btn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0 25px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }
    .search-btn:hover { background: #2a3eb1; }

    #result-area {
        margin-top: 30px;
        display: none; /* مخفي افتراضياً */
    }
    .part-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border-left: 5px solid var(--secondary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
</style>
@endsection

@section('content')
<div class="search-container">
    <h2 style="color: var(--primary); margin-bottom: 10px;">Spare Parts Lookup</h2>
    <p style="color: #64748b; margin-bottom: 30px;">Enter Serial Number to find compatible parts</p>

    <div class="search-box">
        <i class="fas fa-barcode" style="align-self: center; margin-left: 15px; color: #94a3b8;"></i>
        <input type="text" id="sn-input" placeholder="Enter Serial Number (e.g. SN-1022)...">
        <button class="search-btn" onclick="searchParts()">
            <i class="fas fa-search"></i> Search
        </button>
    </div>

    <div id="result-area">
        <div id="loading" style="display:none; color: var(--primary);">
            <i class="fas fa-spinner fa-spin"></i> Searching database...
        </div>
        <div id="parts-list">
            </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function searchParts() {
    const sn = document.getElementById('sn-input').value;
    const resultArea = document.getElementById('result-area');
    const partsList = document.getElementById('parts-list');
    const loading = document.getElementById('loading');

    if(!sn) {
        alert("Please enter a serial number first.");
        return;
    }

    // إظهار منطقة النتائج والتحميل
    resultArea.style.display = 'block';
    loading.style.display = 'block';
    partsList.innerHTML = '';

    // طلب البيانات من المسار الذي أنشأناه سابقاً للبحث
    fetch(`/search-product/${sn}`)
        .then(response => response.json())
        .then(data => {
            loading.style.display = 'none';
            if(data.error) {
                partsList.innerHTML = `<p style="color: #ef4444; padding: 20px;">${data.error}</p>`;
            } else {
                // هنا نفترض أن الـ Product يرجع معه قطع الغيار المتوافقة
                // إذا كنت تعرض القطعة نفسها التي بحثت عنها:
                partsList.innerHTML = `
                    <div class="part-card">
                        <div>
                            <strong style="display:block; font-size: 1.1rem;">${data.name}</strong>
                            <small style="color: #64748b;">Category: ${data.category || 'Maintenance'}</small>
                        </div>
                        <div style="text-align: right;">
                            <span style="background: #dcfce7; color: #166534; padding: 5px 12px; border-radius: 20px; font-weight: bold;">
                                ${data.quantity} in stock
                            </span>
                            <p style="margin-top: 5px; font-weight: bold; color: var(--primary);">$${data.price}</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            loading.style.display = 'none';
            partsList.innerHTML = `<p style="color: #ef4444;">Connection error. Please try again.</p>`;
        });
}
</script>
@endsection
