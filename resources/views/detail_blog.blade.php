@extends('layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="card shadow-lg p-4 w-100 w-md-75 w-lg-50 border-0" style="max-width: 700px; animation: fadeIn 0.8s ease-in-out;">
            <div class="card-body text-center">
                <h1 class="mb-4 fw-bold text-gradient"> Detail Blog</h1>
                <h3 class="fw-bold text-primary">{{ $blog->title }}</h3>
                <p class="text-muted mt-3">{{ $blog->description }}</p>
                <p class="text-muted mt-3">{{ $blog->created_at }}</p>
                <a href="{{ route('blog') }}" class="btn btn-primary mt-4 px-4">🔙 Kembali</a>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .text-gradient {
            background: linear-gradient(45deg, #007bff, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
@endsection
