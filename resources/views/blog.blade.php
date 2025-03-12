@extends('layouts.app')
@section('content')
    <h1 class="text-center mb-5">BLOG</h1>
    <div class="container">
        <form action="" method="GET" class="mb-5">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username"
                    aria-describedby="basic-addon2" name='title' value="{{ $title }}">
                <button href="{{ url('/blog/add') }}" type="submit"
                    class="btn btn-primary text-white rounded-end bg-primary outline-none border-none">Search</button>
            </div>
        </form>
        <a href="{{ url('/blog/add') }}" type="submit"
            class=" btn btn-primary text-white rounded bg-primary outline-none border-none">Add</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() == 0)
                    <td colspan="4" class="text-center">No Data</td>
                @endif
                @foreach ($data as $item)
                    <tr>
                        <td scope="row">{{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}</td>
                        <td>{{ $item->title }}</td>
                        <td class="description" title="{{ $item->description }}">
                            {{ Str::limit($item->description, 50) }}
                        </td>
                        <td>
                            <a href="{{ url('/blog/' . $item->id . '/show') }}"
                                class="btn btn-secondary text-white">view</a> |
                            <a href="{{ url('/blog/' . $item->id . '/edit') }}" class="btn btn-primary text-white">edit</a>
                            |
                            <a href="{{ url('/blog/' . $item->id . '/delete') }}"
                                class="btn btn-danger text-white"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $item->title }}?')">
                                Delete
                             </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
