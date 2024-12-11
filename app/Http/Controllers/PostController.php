<?php

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Ambil data dengan pagination, 10 item per halaman
        $posts = Post::paginate(10);

        // Kirim data ke view
        return view('posts.index', compact('posts'));
    }
}
