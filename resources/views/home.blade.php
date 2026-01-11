<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

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
            <h3 class="section-title"><i class="fas fa-paper-plane"></i> Send Maintenance Request</h3>
            <form action="{{ route('send.message') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Device / Subject</label>
                    <input type="text" name="subject" placeholder="Ex: Samsung Fridge Repair" required>
                </div>
                <div class="form-group">
                    <label>Describe the Problem</label>
                    <textarea name="content" rows="4" placeholder="What is wrong with your device?" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Request</button>
                @csrf
    <div class="form-group">
        <label for="pdf_file">اختر ملف PDF:</label>
        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf">
    </div>
    <button type="submit" class="btn btn-primary">رفع الملف</button>
            </form>
        </div>

        <h3 class="section-title"><i class="fas fa-history"></i> Your Requests & Status</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Worker Assigned</th>
                        <th>Admin Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                        $myMessages = App\Models\Message::where('user_id', Auth::id())->latest()->get();
                    @endphp

                    @forelse($myMessages as $msg)
                    <tr>
                        <td><strong>{{ $msg->subject }}</strong></td>
                        <td>
                            <span class="status-badge {{ $msg->status == 'pending' ? 'pending' : 'assigned' }}">
                                {{ $msg->status }}
                            </span>
                        </td>
                        <td>{{ $msg->worker_name ?? 'Waiting...' }}</td>
                        <td style="color: #666; font-style: italic;">
                            {{ $msg->admin_reply ?? 'No reply yet' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #999;">
                            You haven't sent any requests yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
