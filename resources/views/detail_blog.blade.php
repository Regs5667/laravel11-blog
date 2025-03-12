@extends('layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="card shadow-lg p-4 w-100 w-md-75 w-lg-50 border-0"
            style="max-width: 1000px; animation: fadeIn 0.8s ease-in-out;">
            <div class="card-body text-center">
                <h1 class="mb-4 fw-bold text-gradient">Detail Blog</h1>
                <h3 class="fw-bold text-primary">{{ $blog->title }}</h3>
                <p class="text-muted mt-3">{{ $blog->description }}</p>
                <p class="text-muted mb-1">
                    {{ $blog->created_at?->format('d M Y, H:i') ?? 'N/A' }}
                </p>            </div>
            <div class="mt-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ url('/comment/'.$blog-> id) }}" class="form-horizontal w-100" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="comment" class="col-sm-2 col-form-label text-start">Comments:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="comment" name="comment" placeholder="Enter Comment"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-4">Submit</button>
                        <a href="{{ route('blog') }}" class="btn btn-primary px-4">🔙 Kembali</a>
                    </div>
                </form>
                <div class="mt-4">
                    @if ($blog->comments->count() == 0)
                    <div class="card shadow-sm p-3 mb-3">
                        <div class="card-body">
                            <h1>No Comment</h1>
                        </div>
                    </div>
                @endif

                    @foreach ($blog->comments as $item)
                    <div class="card shadow-sm p-3 mb-3">
                        <div class="card-body">
                            <p class="text-muted mb-1">
                                {{ $item->created_at?->format('d M Y, H:i') ?? 'N/A' }}
                            </p>
                            <p>{{ $item->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
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
