<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->cannot('viewAny', Blog::class)) {
            abort(403);
        }

        $title = $request->title;
        // $blogs = DB::table('blogs')->where('title', 'LIKE', '%' . $title . '%')->orderBy('id', 'desc')->paginate(4);
        $blogs = Blog::with('author')->where('title', 'LIKE', '%' . $title . '%')->orderBy('id', 'desc')->paginate(4);
        return view('blog', ['data' => $blogs, 'title' => $title]);
    }

    public function add()
    {
        $tags = Tag::all();
        return view('add_blog', compact('tags'));
    }

    public function create(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|unique:blogs|max:255',
            'description' => 'required',
            'file-test' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ], [
            'title.required' => 'Mohon isi Judul',
            'title.unique' => 'Judul sudah ada',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter',
            'description.required' => 'Deskripsi wajib diisi',
            'file-test.image' => 'File harus berupa gambar',
            'file-test.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'file-test.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file-test')) {
            $file = $request->file('file-test');
            $fileName = time() . '.' . $file->extension(); // Format nama unik
            $path = $file->storeAs('images', $fileName); // Simpan di storage/app/public/images
            $imagePath = 'storage/images/' . $fileName; // Path yang bisa diakses

        } else {
            $imagePath = null; // Jika tidak ada gambar, null
        }

        // Simpan data ke database
        $blogs = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath, // Simpan path gambar
        ]);

        // Simpan tag jika ada
        if ($request->has('tags')) {
            $blogs->tags()->attach($request->tags);
        }

        return redirect()->route('blog')->with('success', 'Data berhasil ditambahkan!');
    }

    public function show($id)
    {
        // $blog = DB::table('blogs')->where('id', $id)->first();
        $blog = Blog::with(['comments', 'tags'])->findorFail($id);
        // return $blog;
        return view('detail_blog', compact('blog'));
    }

    public function edit($id)
    {
        $tags = Tag::all();
        $blog = Blog::with(['tags'])->where('id', $id)->first();
        // if (!Gate::allows('update-blog', $blog)) {
        //     abort(403);
        // }

        $response = Gate::inspect('update-blog', $blog);

        if ($response->allowed()) {
            // The action is authorized...
        } else {
           abort(403,'You must be an author.');
        }
        return view('edit_blog', compact('blog', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ], [
            'title.required' => 'Mohon isi Judul',
            'title.unique' => 'Judul sudah ada',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter',
            'description.required' => 'Deskripsi wajib diisi',
        ]);



        $blog = Blog::findOrFail($id);
        $blog->update($validated);


        $blog->tags()->sync($request->tags ?? []);

        return redirect()->route('blog')->with('success', 'Data berhasil diubah!');
    }


    public function delete($id)
    {
        // DB::table('blogs')->where('id', $id)->delete();
        Blog::findorFail($id)->delete();
        return redirect()->route('blog')->with('success', 'Data berhasil dihapus!');
    }
}
