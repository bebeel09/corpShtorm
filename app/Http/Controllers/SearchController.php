<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class SearchController extends Controller
{
    public function list(Request $request) {
		$strSearch = "%" . $request->search . "%";
		$data['users'] = User::select('id', 'name', 'mobile_phone', 'work_phone', 'position', 'email', 'avatar')->where('name', 'like', $strSearch)
			->orWhere('mobile_phone', 'like', $strSearch)
			->orWhere('work_phone', 'like', $strSearch)
			->orWhere('position', 'like', $strSearch)

			->get()->toArray();

		$data['posts'] = Post::select('title', 'slug', 'category_id')->where('title', 'like', $strSearch)->with('category:id,title,slug')->get()->toArray();
		return $data;
	}
}
