<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::where('is_published', 1)->paginate(10);
        $categories = Category::all('title', 'slug');
        return view('home', compact('posts', 'categories'));
    }
}