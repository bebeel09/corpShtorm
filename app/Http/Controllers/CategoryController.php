<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug) {
        $category_id = Category::where('slug', $slug)->pluck('id');
        $category =  Category::where('id', $category_id)->first();
        $posts = Post::where('is_published', 1)->where('category_id', $category_id)->paginate(10);
        $categories = Category::all('title', 'slug');
        return view('category', [
            'posts' => $posts,
            'categories' => $categories,
            'category' => $category,
        ]);
    }
}