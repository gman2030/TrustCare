@extends('layouts.worker-master')

@section('styles')
    <style>
        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .task-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .status-label {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .status-assigned { background: #fef3c7; color: #92400e; }
        .status-accepted { background: #dcfce7; color: #166534; }

        .customer-btn {
            background: none; border: none; color: var(--primary);
            font-weight: 700; font-size: 1.1rem; cursor: pointer;
            padding: 0; text-decoration: underline; text-underline-offset: 4px;
        }

        /* تنسيق أزرار الأكشن */
        .action-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-complete {
            flex: 3; background: #10b981; color: white; border: none;
            padding: 12px; border-radius: 8px; cursor: pointer;
            font-weight: bold; transition: 0.2s;
        }

        .btn-delete {
            flex: 1; background: #ef4444; color: white; border: none;
            padding: 12px; border-radius: 8px; cursor: pointer;
            transition: 0.2s;
        }

        .btn-complete:hover { background: #059669; }
        .btn-delete:hover { background: #dc2626; }

        .modal {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white; margin: 10% auto; padding: 25px; width: 90%;
            max-width: 500px; border-radius: 15px; position: relative;
        }
    </style>
@endsection

@section('content')
    <div class="welcome-section" style="margin-bottom: 30px;">
        <h2 style="color: var(--primary); font-weight: 800;">Assigned Tasks</h2>
        <p style="color: #64748b;">Manage your tasks. Use "Mark as Done" to complete or the trash icon to remove.</p>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #bdf0d0;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="task-grid">
        @forelse($tasks as $task)
            @php
                $status = strtolower($task->status);
                $parts = explode(': ', $task->subject);
                $sn = isset($parts[1]) ? trim($parts[1]) : 'N/A';
            @endphp

            <div class="task-card">
                <div>
                    <span class="status-label {{ $status == 'accepted' ? 'status-accepted' : 'status-assigned' }}">
                        <i class="fas {{ $status == 'accepted' ? 'fa-spinner fa-spin' : 'fa-clock' }}"></i>
                        {{ $task->status }}
                    </span>

                    <h3 style="margin-bottom: 10px; color: #334155;">Ticket: {{ $sn }}</h3>

                    <p style="margin-bottom: 8px; color: #475569;">
                        <i class="fas fa-user" style="width: 20px;"></i>
                        <button class="customer-btn"
                            onclick="openDetails('{{ addslashes($task->user->name ?? 'Guest') }}', '{{ $task->user->phone ?? 'N/A' }}', '{{ $sn }}', '{{ addslashes($task->content) }}')">
                            {{ $task->user->name ?? 'Unknown' }}
                        </button>
                    </p>
                    <p style="color: #475569;"><i class="fas fa-phone-alt" style="width: 20px;"></i>
                        {{ $task->user->phone ?? 'N/A' }}</p>
                </div>

                <div class="action-group">
                    @if ($status == 'assigned')
                        <form action="{{ route('worker.accept', $task->id) }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" style="width:100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold;">
                                <i class="fas fa-check"></i> Accept Task
                            </button>
                        </form>
                    @elseif($status == 'accepted')
                        {{-- زر الإتمام --}}
                        <form action="{{ route('worker.complete', $task->id) }}" method="POST" style="flex: 3;" onsubmit="return confirm('Mark this task as finished?')">
                            @csrf
                            <button type="submit" class="btn-complete">
                                <i class="fas fa-check-double"></i> Mark Done
                            </button>
                        </form>

                        {{-- زر الحذف النهائي --}}
                        <form action="{{ route('worker.destroy', $task->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Permanently delete this task information?')">
                            @csrf
                            <button type="submit" class="btn-delete" title="Delete Task">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 15px; border: 2px dashed #e2e8f0;">
                <i class="fas fa-inbox fa-3x" style="color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="color: #64748b; font-size: 1.2rem; font-weight: 600;">No tasks assigned to you yet.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal --}}
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <h3 style="color: var(--primary); margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Request Details</h3>
            <div style="line-height: 1.8;">
                <p><strong>Customer:</strong> <span id="m_name"></span></p>
                <p><strong>Phone:</strong> <span id="m_phone"></span></p>
                <p><strong>Serial:</strong> <span id="m_sn" style="color: var(--secondary); font-weight: bold;"></span></p>
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-top: 15px; border: 1px solid #e2e8f0;">
                    <strong>Complaint:</strong>
                    <p id="m_content" style="font-size: 14px; color: #475569; margin-top: 5px;"></p>
                </div>
            </div>
            <button onclick="closeModal()" style="width: 100%; margin-top: 20px; padding: 10px; background: #64748b; color: white; border: none; border-radius: 8px; cursor: pointer;">Close</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openDetails(name, phone, sn, content) {
            document.getElementById('m_name').innerText = name;
            document.getElementById('m_phone').innerText = phone;
            document.getElementById('m_sn').innerText = sn;
            document.getElementById('m_content').innerText = content;
            document.getElementById('detailsModal').style.display = 'block';
        }
        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target == document.getElementById('detailsModal')) closeModal();
        }
    </script>
@endsection
