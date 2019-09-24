<?php

namespace App\Http\Controllers\Blog;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;
use App\Post;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin', ['only' => [
            'create',
            'store',
            'edit',
            'update',
            'destroy'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items  = Post::latest()->notDeleted()->published()->paginate(6);
        $categories = Category::with([
            'articles' => function ($articles) {
                return $articles->notDeleted()->published();
            }
        ])->get();

        return view('blog.posts.index', compact('items', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPost($categorySlug, $postSlug)
    {
       
        $category=Category::select('id','slug','title','parent_id')->where('slug', $categorySlug)->first();
        

        $postBreadcrump=[];
        array_push($postBreadcrump, $category);
        PostController::breadcrumbs($category, $postBreadcrump); 
        krsort($postBreadcrump);

        $post=Post::select('slug', 'title', 'content_html', 'created_at', 'user_id', 'category_id')
        ->where('slug', $postSlug)
        ->where('category_id', $category->id)
        ->with(['user:id,first_name,sur_name,last_name,avatar'])
        ->first();

     return view('posts.post',compact('post','category', 'postBreadcrump'));
    }


    //Осторожно рекрусия!!!
    // $category - объект категории для поиска родительской категорий
    // &$arraySelf - ссылка на массив куда записываем найденные объекты
    protected function breadcrumbs($category, &$arraySelf){
        if ($category->parent_id == 0) return;
        else{
        $parentCategory=Category::select('id','slug','title','parent_id')->where('id', $category->parent_id)->first();
        array_push($arraySelf, $parentCategory);
        $this->breadcrumbs($parentCategory, $arraySelf);
        }
    }


}
