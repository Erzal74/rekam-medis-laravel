<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-wrapper {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-image {
            width: 50%;
            background: url('{{ asset('images/poligigi.png') }}') center/contain no-repeat;
            background-color: #f0f6ff;
        }

        .login-form {
            width: 50%;
            padding: 40px;
        }

        .login-form h3 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #666;
            text-align: center;
        }

        @media(max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-image {
                display: none;
            }

            .login-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-image"></div>

        <div class="login-form">
            <h3 class="text-center">Login</h3>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ url('/') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Login sebagai</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    </select>
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <div class="footer mt-4">
        Creation of Informatics Students of Madiun State Polytechnic
    </div>

</body>
</html>
