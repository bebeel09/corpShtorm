<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function list(Request $request) {
		$strSearch = "%" . $request->search . "%";
		$users = User::select('id', 'name', 'mobile_phone', 'work_phone', 'position')->where('name', 'like', $strSearch)
			->orWhere('mobile_phone', 'like', $strSearch)
			->orWhere('work_phone', 'like', $strSearch)
			->orWhere('position', 'like', $strSearch)

			->get()->toArray();

//		$this->posts = Post::select('title', 'slug', 'category_id')->where('title', 'like', $strSearch)->with('category:id,title,slug')->get()->toArray();
		return $users;
	}
}
