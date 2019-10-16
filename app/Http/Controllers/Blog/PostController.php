<?php

namespace App\Http\Controllers\Blog;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;
use App\Post;
use App\Catalog;
use App\CatalogPost;


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
        $category = Category::select('id', 'slug', 'title', 'parent_id')->where('slug', $categorySlug)->first();

        $postBreadcrump = [];
        array_push($postBreadcrump, $category);
        PostController::breadcrumbs($category, $postBreadcrump);
        krsort($postBreadcrump);

        $post = Post::select('id', 'slug', 'title', 'content_html', 'created_at', 'user_id', 'category_id')
            ->where('slug', $postSlug)
            ->where('category_id', $category->id)
            ->with(['user:id,first_name,sur_name,last_name,avatar'])
            ->first();

        return view('posts.post', compact('post', 'category', 'postBreadcrump'));
    }

    public function showPostCatalog($catalogSlug, $catalogPostSlug)
    {
        $catalog = Catalog::select('id', 'slug', 'title', 'parent_id')->where('slug', $catalogSlug)->first();

        $postBreadcrump = [];
        array_push($postBreadcrump, $catalog);
        PostController::breadcrumbs($catalog, $postBreadcrump);
        krsort($postBreadcrump);

        $post = catalogPost::select('id', 'slug', 'title', 'content_json', 'created_at', 'user_id', 'catalog_id')
            ->where('slug', $catalogPostSlug)
            ->where('catalog_id', $catalog->id)
            ->with(['user:id,first_name,sur_name,last_name,avatar'])
            ->first();
        
        return view('posts.catalogPost', compact('post', 'catalog', 'postBreadcrump'));
    }


    //Осторожно рекрусия!!!
    // $category - объект категории для поиска родительской категорий
    // &$arraySave - ссылка на массив куда записываем найденные объекты
    protected function breadcrumbs($category, &$arraySave)
    {
        if ($category->parent_id == 0) return;
        else {
            $parentCategory = Category::select('id', 'slug', 'title', 'parent_id')->where('id', $category->parent_id)->first();
            array_push($arraySave, $parentCategory);
            $this->breadcrumbs($parentCategory, $arraySave);
        }
    }
}
