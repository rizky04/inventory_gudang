<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            background-color: #0d6efd;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control {
            border-left: none;
            padding: 12px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        .brand-logo {
            font-size: 3.5rem;
            color: #0d6efd;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="brand-logo">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <h4 class="fw-bold m-0">Inventory App</h4>
                <p class="text-muted small">Kelola stok barang jadi lebih mudah</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label small fw-semibold text-secondary">Password</label>
                        <a href="#" class="text-decoration-none small">Lupa?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Ingat saya di perangkat ini</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        Masuk Ke Dashboard
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-4 text-muted small">
        &copy; 2026 Inventory System. Versi 1.0.0
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
