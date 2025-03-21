@extends('layouts.app')
@section('content')
    <div class="container min-vh-100 d-flex flex-column justify-content-center w-50">
        <h1 class="text-center">Edit {{ $blog->title }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('/blog/' . $blog->id . '/update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="inputTitle3" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputTitle3" placeholder="enter title"
                        value="{{ $blog->title }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputdescription3" class="col-sm-2 col-form-label">description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="inputdescription3" class="form-control" placeholder="Enter description">
                        {{ $blog->description }}
                    </textarea>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 justify-content-center my-2">
                @foreach ($blog->tags as $tag)
                    <span class="badge bg-secondary rounded-pill text-white">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
            <div class="row">
                <label for="inputdescription3" class="col-sm-2 col-form-label">tags :</label>
                <div class="col-sm-10">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    id="tag{{ $tag->id }}">
                                <label class="form-check-label" for="tag{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update</button>
        </form>
    </div>
@endsection
