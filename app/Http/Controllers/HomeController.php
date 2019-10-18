<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Catalog;
use App\catalogPost;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  // public function index()
  // {
  //   $postsData = Post::select('slug', 'title', 'excerpt', 'content_html', 'created_at', 'user_id', 'category_id')
  //     ->where('category_id','1')
  //     ->with(['category:id,slug,title'])
  //     ->with(['user:id,last_name,sur_name,first_name,avatar'])
  //     ->paginate(15);

  //   return view('home', compact('postsData'));
  // }

  public function getPhoneBookPage()
  {
    $users = User::select('id', 'email', 'first_name', 'sur_name', 'last_name', 'mobile_phone', 'work_phone', 'position', 'avatar', 'department_id', 'office_id')->orderBy('office_id')
      ->with(['department:id,department_appellation'])
      ->with(['office:id,office_appellation'])
      ->get();

    return view('phoneBook', compact('users'));
  }

  public function getProfilePage($id)
  {

    $userMetaData = User::select('id', 'first_name', 'sur_name', 'last_name', 'email', 'mobile_phone', 'work_phone', 'position', 'avatar', 'department_id', 'office_id')
      ->with(['department:id,department_appellation'])
      ->with(['office:id,office_appellation'])
      ->findOrFail($id);

    return view('profile', compact('userMetaData'));
  }

  public function showCategory($slug)
  {

    $category = Category::where('slug', $slug)->first();

    $postsData = Post::select('slug', 'title', 'excerpt', 'content_html', 'created_at', 'user_id', 'category_id')
      ->where('category_id', $category->id)
      ->with(['category:id,slug,title'])
      ->with(['user:id,last_name,sur_name,first_name,avatar'])
      ->orderBy('id', 'DESC')
      ->paginate(15);

    // ->with(['category'=> function($category) use ($slug){
    //   return $category->select('id', 'slug', 'title')->where('slug','=',$slug)->first();
    //  }])

    return view('categoryPage', compact('postsData', 'category'));
  }

  public function getCatalog($catalogSlug)
  {

    $currentCatalog = Catalog::where('slug', $catalogSlug)->first();
    $catalogPosts = catalogPost::where('catalog_id', $currentCatalog->id)->get();
    $subcatalogs = Catalog::where('parent_id', $currentCatalog->id)->get();

    return view("catalog", compact('currentCatalog', 'catalogPosts', 'subcatalogs'));
  }
}
