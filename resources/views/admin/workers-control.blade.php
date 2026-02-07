@extends('layouts.admin-master')

@section('content')
<div class="container" dir="ltr" style="text-align: left; padding: 20px;">
    <h2>Workers Control</h2>

    <table class="table" style="width: 100%; background: white; border-radius: 10px; overflow: hidden;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th style="padding: 15px;">Worker Name</th>
                <th style="padding: 15px; text-align: center;">Control</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workers as $worker)
            <tr>
                <td style="padding: 15px;">{{ $worker->name }}</td>
                <td style="padding: 15px; text-align: center;">
                    {{-- عند الضغط يفتح المودال ويمرر معرف العامل واسمه --}}
                    <button onclick="openAssignModal('{{ $worker->id }}', '{{ $worker->name }}')"
                            style="background: #1b2d95; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                        Assign Task
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- المودال --}}
<div id="assignModal" style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 10% auto; padding: 30px; width: 30%; border-radius: 15px;">
        <h3 id="display_worker_name">Assign Task</h3>
        <form action="{{ route('admin.assign.task') }}" method="POST">
            @csrf
            <input type="hidden" name="worker_id" id="modal_worker_id">
            <div style="margin-top: 15px;">
                <label>Customer Name:</label>
                <input type="text" name="customer_name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" style="background: #e91e63; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Confirm</button>
                <button type="button" onclick="closeAssignModal()" style="background: #ccc; border: none; padding: 10px 20px; border-radius: 5px;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(id, name) {
    document.getElementById('modal_worker_id').value = id;
    document.getElementById('display_worker_name').innerText = "Assign Task to: " + name;
    document.getElementById('assignModal').style.display = 'block';
}
function closeAssignModal() {
    document.getElementById('assignModal').style.display = 'none';
}
</script>
@endsection
