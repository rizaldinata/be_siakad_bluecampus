<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .logo-section {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 500px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .logo svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .logo-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .logo-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .form-section {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 40px;
            font-size: 16px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .btn-login {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 14px;
        }

        .copyright {
            color: #9ca3af;
            font-size: 13px;
            text-align: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
                border-radius: 16px;
            }

            .logo-section {
                padding: 40px 30px;
                min-height: auto;
            }

            .form-section {
                padding: 40px 30px;
            }

            .form-title {
                font-size: 28px;
            }

            .logo-title {
                font-size: 24px;
            }
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
                        <div class="logo">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z" />
                            </svg>
                        </div>
                        <h1 class="logo-title">Blue Campus</h1>
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
                            <div class="mb-4">
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
