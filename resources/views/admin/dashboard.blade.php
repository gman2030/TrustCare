<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <div class="main-content">
        <div class="header-dashboard">
            <div class="header-title">
                <i class="fas fa-shield-halved"></i>
                <h2 style="margin:0;">TrustCare Admin</h2>
            </div>
            <div class="header-user">
                <span class="welcome-msg">Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout-modern">
                        <i class="fas fa-power-off"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-info">
                    <h4>Total Requests</h4>
                    <p>{{ $messages->count() }}</p>
                </div>
            </div>

            <div class="stat-card" style="border-left-color: var(--success);">
                <div class="stat-icon" style="color: var(--success); background: rgba(46, 213, 115, 0.1);">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h4>Active Users</h4>
                    <p>{{ \App\Models\User::where('role', 'user')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="table-container-card">
            <div class="card-header-table">
                <i class="fas fa- screwdriver-wrench" style="color: var(--primary-blue);"></i>
                <h3 style="margin:0;">Recent Maintenance Requests</h3>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
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
                                        <span>{{ $msg->user->name }}</span>
                                    </div>
                                </td>
                                <td><span style="color: #636e72;">{{ $msg->subject }}</span></td>
                                <td>
                                    <span class="badge badge-pending">{{ $msg->status }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.assign', $msg->id) }}" method="POST"
                                        class="assign-form">
                                        @csrf
                                        <input type="text" name="worker_name" placeholder="Enter worker name..."
                                            required>
                                        <button type="submit" class="btn-assign">
                                            <i class="fas fa-plus"></i> Assign
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.user.delete', $msg->user_id) }}" method="POST"
                                        onsubmit="return confirm('Kick this user from system?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-kick" title="Delete User">
                                            <i class="fas fa-user-xmark"></i> Kick
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #b2bec3;">
                                    <i class="fas fa-folder-open"
                                        style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                                    No maintenance requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
