@extends('layouts.app')
@section('content')
    <div class="container min-vh-100 d-flex flex-column justify-content-center w-50">
        <h1 class="text-center">ADD BLOGS</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/blog/create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="inputTitle3" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputTitle3" placeholder="Enter title"
                        value="{{ old('title') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputdescription3" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" id="inputdescription3" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputfile3" class="col-sm-2 col-form-label">File</label>
                <div class="col-sm-10">
                    <input type="file" name="file-test" class="form-control" id="inputfile3" accept="image/*" required>
                </div>
            </div>

            <div class="row">
                <label for="inputdescription3" class="col-sm-2 col-form-label">Tags:</label>
                <div class="col-sm-10">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Create</button>
        </form>
    </div>
@endsection
