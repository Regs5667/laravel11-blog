<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex flex-column gap-2 justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
            <div class="card-body text-center">
                <h2 class="card-title text-primary fw-bold">Forgot Password</h2>
                <form action="/reset-password" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label fw-semibold">Password </label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="repassword" class="form-label fw-semibold">retype password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3 text-start">
                        <input type="hidden" id="token" name="token" class="form-control" value="{{ $token }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" required>Send Link</button>
                </form>
                <hr>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

    </div>
</body>

</html>
