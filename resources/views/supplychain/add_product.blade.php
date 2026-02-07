@extends('layouts.Supplychain-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="bg-white p-5 shadow-sm" style="border-radius: 30px; border: 1px solid #f0f0f0;">

                <div class="text-center mb-5">
                    <h4 class="fw-bold text-dark">Add New Item</h4>
                    <p class="text-muted small">Fill in the essential details</p>
                </div>

                <form action="{{ route('supply.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="d-flex justify-content-center mb-5">
                        <label for="imageInput" class="upload-square">
                            <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                            <img id="imagePreview" src="" style="display: none;">
                            <div id="plusContent">
                                <i class="fas fa-plus text-muted"></i>
                            </div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div class="custom-input-group mb-4">
                            <label class="small fw-bold text-secondary ml-2 mb-1 d-block text-uppercase" style="letter-spacing: 1px;">Product Name</label>
                            <input type="text" name="name" class="modern-input" placeholder="Enter name..." required>
                        </div>

                        <div class="custom-input-group mb-5">
                            <label class="small fw-bold text-secondary ml-2 mb-1 d-block text-uppercase" style="letter-spacing: 1px;">Serial Number</label>
                            <input type="text" name="serial_number" class="modern-input" placeholder="Enter S/N..." required>
                        </div>
                    </div>
                    <br>

                    <button type="submit" class="btn-premium">
                        Save Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Square Uploader Style */
    .upload-square {
        width: 100px;
        height: 100px;
        background: #fbfbfb;
        border: 2px dashed #ececec;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        overflow: hidden;
    }
    .upload-square:hover {
        border-color: #000;
        background: #f0f0f0;
    }
    #imagePreview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Minimalist Inputs */
    .modern-input {
        width: 100%;
        padding: 15px 20px;
        background: #f9f9f9;
        border: 1px solid #eeeeee;
        border-radius: 12px;
        font-size: 15px;
        color: #333;
        transition: 0.3s;
    }
    .modern-input:focus {
        outline: none;
        background: #fff;
        border-color: #000;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Premium Button Style */
    .btn-premium {
        width: 100%;
        background: #004bad;
        color: #fff;
        border: none;
        padding: 18px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 16px;
        transition: 0.3s;
        cursor: pointer;
    }
    .btn-premium:hover {
        background: #00377f;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(54, 112, 199, 0.1);
    }
    .btn-premium:active {
        transform: translateY(0);
    }
</style>

<script>
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            const plus = document.getElementById('plusContent');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            plus.style.display = 'none';
        }
    }
</script>
@endsection
