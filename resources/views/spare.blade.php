@extends('layouts.admin-master')

@section('content')
<div class="admin-container" dir="ltr" style="text-align: left;">
    <div class="header-section" style="margin-bottom: 30px;">
        <h2 style="color: #0f172a; font-weight: 700;">Spare Parts <span style="color: #e91e63;">/</span> Search</h2>
        <p style="color: #64748b; font-size: 14px;">Enter the serial number to find compatible spare parts.</p>
    </div>

    {{-- Search Bar Section --}}
    <div class="search-card" style="background: white; padding: 25px; border-radius: 15px; border: 1px solid #e2e8f0; display: flex; gap: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        <input type="text" id="spare_sn" placeholder="e.g. 0666456"
               style="flex: 1; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none; font-size: 15px;">
        <button onclick="findParts()"
                style="background: #1b2d95; color: white; border: none; padding: 0 30px; border-radius: 10px; cursor: pointer; font-weight: 600; transition: 0.3s;">
            Search
        </button>
    </div>

    {{-- Simple Results Display --}}
    <div id="results_area" style="margin-top: 30px;">
        </div>
</div>
@endsection

@section('scripts')
<script>
function findParts() {
    const sn = document.getElementById('spare_sn').value;
    const area = document.getElementById('results_area');

    if(sn === "0666456") {
        area.innerHTML = `
            <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-weight: bold; color: #1b2d95;">
                    Compatible Parts for: ${sn}
                </div>
                <div style="padding: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                            <span>Fan Motor (AC)</span>
                            <span style="color: #10b981; font-weight: bold;">Available</span>
                        </li>
                        <li style="display: flex; justify-content: space-between; padding: 10px 0;">
                            <span>Control Sensor</span>
                            <span style="color: #10b981; font-weight: bold;">Available</span>
                        </li>
                    </ul>
                </div>
            </div>`;
    } else {
        area.innerHTML = `<p style="color: #ef4444; text-align: center; padding: 20px;">No parts found for this S/N.</p>`;
    }
}
</script>
@endsection
