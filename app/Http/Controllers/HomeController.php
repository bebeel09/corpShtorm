<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;

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
    $users = User::select('id', 'email', 'first_name', 'sur_name', 'last_name', 'mobile_phone', 'work_phone', 'position', 'avatar', 'region_id', 'department_id', 'office_id')->orderBy('office_id')
      ->with(['region:id,region_appellation'])
      ->with(['department:id,department_appellation'])
      ->with(['office:id,office_appellation'])
      ->get();

    return view('phoneBook', compact('users'));
  }

  public function getProfilePage($id){

    $userMetaData= User::select('id', 'first_name', 'sur_name', 'last_name', 'email', 'mobile_phone', 'work_phone', 'position', 'avatar', 'region_id', 'department_id', 'office_id')
    ->with(['region:id,region_appellation'])
    ->with(['department:id,department_appellation'])
    ->with(['office:id,office_appellation'])
    ->findOrFail($id);

    return view('profile', compact('userMetaData'));

  }

  public function getRubricTypeList($idRubric){

    $currentCategory=Category::find($idRubric);
    $postsСategories=Post::where('category_id',$idRubric)->get();
    $subcategories=Category::where('parent_id',$idRubric)->get();

    return view('listPage', compact('currentCategory', 'postsСategories', 'subcategories'));
  }

  public function getRubricTypeCategory($idRubric){

    $postsData = Post::select('slug', 'title', 'excerpt', 'content_html', 'created_at', 'user_id', 'category_id')
      ->where('category_id', $idRubric)
      ->with(['category:id,slug,title'])
      ->with(['user:id,last_name,sur_name,first_name,avatar'])
      ->orderBy('id', 'DESC')
      ->paginate(15);

    return view('categoryPage', compact('postsData'));
  }

  public function getPostCatalog($catalogSlug, $catalogPostSlug){

  }
}
