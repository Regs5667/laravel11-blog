<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="max-width: 500px;">
            <div class="card-body text-center">
                <h2 class="card-title text-primary fw-bold">Email Verification</h2>
                <p class="card-text text-secondary">Thank you for registering with us. Please click on the button below
                    to verify your email address.</p>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg mt-3">Resend Verification Email</button>
                </form>
                <hr>
                <p class="text-muted small mb-0">Best regards,</p>
                <p class="text-muted small">Our Team</p>
                <p class="text-danger small fw-semibold">Note: This email may contain sensitive information. Please be
                    cautious when clicking on the link.</p>
            </div>
        </div>
    </div>
</body>

</html>
