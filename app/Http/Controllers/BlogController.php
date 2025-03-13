<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {

        $title = $request->title;
        // $blogs = DB::table('blogs')->where('title', 'LIKE', '%' . $title . '%')->orderBy('id', 'desc')->paginate(4);
        $blogs = Blog::where('title', 'LIKE', '%' . $title . '%')->orderBy('id', 'desc')->paginate(4);
        return view('blog', ['data' => $blogs, 'title' => $title]);
    }

    public function add()
    {
        $tags = Tag::all();
        return view('add_blog', compact('tags'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:blogs|max:255',
            'description' => 'required',
        ], [
            'title.required' => 'Mohon isi Judul',
            'title.unique' => 'Judul sudah Ada',
            'title.max' => 'Judul tidak Boleh lebih dari 255 character',
            'description.required' => 'Deskripsi Wajib Di isi',
        ]);
        // DB::table('blogs')->insert([
        //     'title' => $request->title,
        //     'description' => $request->description
        // ]);

        $blogs = Blog::create(request()->all());
        $blogs->tags()->attach($request->tags);

        return redirect()->route('blog')->with('success', 'Data berhasil ditambahkan!');;
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
