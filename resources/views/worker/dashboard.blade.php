<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard | TrustCare</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/worker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* إضافة بعض اللمسات التجميلية الإضافية */
        .task-body p { margin-bottom: 8px; }
        .task-body i { width: 20px; color: var(--primary); }
        .status-accepted { background: #dcfce7 !important; color: #166534 !important; }
        .status-pending { background: #fef3c7 !important; color: #92400e !important; }
    </style>
</head>
<body>

    <nav class="navbar">
    <div class="logo">
        <img src="{{ asset('image/logo-icon.png') }}" alt="Logo" style="height: 40px; margin-right: 10px; vertical-align: middle;">
        <span>TrustCare</span>
    </div>
    <div class="user-meta">
        <span>Welcome, <strong>{{ Auth::user()->name }}</strong></span>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</nav>

    <div class="container">
        <div class="welcome-box">
            <h2><i class="fas fa-tasks"></i> Your Assigned Tasks</h2>
            <p style="color: #64748b;">Review and update the maintenance requests assigned to you by the admin.</p>
        </div>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bdf0d0;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="task-grid">
            @forelse($tasks as $task)
                @php 
                    // تحويل الحالة لنص صغير لضمان عمل الـ CSS والشرط برغم اختلاف الأحرف
                    $status = strtolower($task->status); 
                @endphp

                <div class="task-card {{ $status == 'accepted' ? 'accepted' : '' }}">
                    <div class="task-header">
                        <div class="task-title">{{ $task->subject }}</div>
                        <span class="status-label {{ $status == 'accepted' ? 'status-accepted' : 'status-pending' }}">
                            <i class="fas {{ $status == 'accepted' ? 'fa-user-check' : 'fa-clock' }}"></i> 
                            {{ $task->status }}
                        </span>
                    </div>

                    <div class="task-body">
                        <p><i class="fas fa-user"></i> <strong>Customer:</strong> {{ $task->user->name ?? 'User' }}</p>
                        <p><i class="fas fa-phone-alt"></i> <strong>Phone:</strong> {{ $task->user->phone ?? 'N/A' }}</p>
                        <p><i class="fas fa-comment-alt"></i> <strong>Request:</strong> {{ $task->content }}</p>
                    </div>

                    <div class="task-footer">
                        @if($status == 'assigned')
                            <form action="{{ route('worker.accept', $task->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="accept-btn">
                                    <i class="fas fa-thumbs-up"></i> Accept Task
                                </button>
                            </form>
                        @elseif($status == 'accepted')
                            <span style="color: var(--success); font-weight: bold;">
                                <i class="fas fa-tools fa-spin"></i> Job in Progress...
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; grid-column: 1/-1; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <i class="fas fa-clipboard-check fa-4x" style="color: #e2e8f0; margin-bottom: 20px;"></i>
                    <h3 style="color: #64748b;">No Tasks Yet</h3>
                    <p style="color: #94a3b8;">When the admin assigns you a task, it will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>