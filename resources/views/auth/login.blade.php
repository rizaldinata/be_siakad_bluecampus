<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .login-container {
            min-height: 100vh;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
        }

        .logo-section {
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            color: #374151;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 500px;
        }

        .logo-container {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }

        .logo-container img {
            max-width: 200px;
            max-height: 120px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .logo-title .blue-text {
            color: #2563eb;
        }

        .logo-title .yellow-text {
            color: #f59e0b;
        }

        .logo-subtitle {
            font-size: 14px;
            color: #6b7280;
            font-weight: 400;
        }

        .form-section {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .form-title {
            font-size: 28px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 32px;
            font-size: 14px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .btn-login {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #1d4ed8;
            color: white;
        }

        .alert {
            border-radius: 6px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #dc2626;
            font-size: 14px;
            padding: 12px 16px;
        }

        .alert-danger {
            border-color: #fecaca;
            background-color: #fef2f2;
            color: #dc2626;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .copyright {
            color: #9ca3af;
            font-size: 12px;
            text-align: center;
            margin-top: 32px;
        }

        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
                border-radius: 8px;
            }

            .logo-section {
                padding: 40px 30px;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }

            .form-section {
                padding: 40px 30px;
            }

            .form-title {
                font-size: 24px;
            }

            .logo-title {
                font-size: 24px;
            }
        }

        /* Additional styling to match the dashboard theme */
        .table-container {
            background: white;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex align-items-center justify-content-center p-4">
        <div class="login-card">
            <div class="row g-0">
                <!-- Logo Section -->
                <div class="col-lg-5">
                    <div class="logo-section">
                        <div class="logo-container">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo BlueCampus">
                        </div>
                        <p class="logo-subtitle">Sistem Informasi Akademik</p>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="col-lg-7">
                    <div class="form-section">
                        <h2 class="form-title">Selamat Datang</h2>
                        <p class="form-subtitle">Silakan masuk ke akun admin Anda</p>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('web.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password" required
                                    placeholder="Masukkan kata sandi">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login">Masuk</button>
                            </div>
                        </form> 

                        <div class="copyright">
                            &copy; {{ date('Y') }} Blue Campus - Sistem Informasi Akademik
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
