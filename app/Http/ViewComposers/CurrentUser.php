<?php

namespace App\Http\ViewComposers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Category;
use App\Event;
use App\Catalog;

class CurrentUser
{
	public function compose(View $view)
	{
		$currentUser = Auth::user();
	
		$typeCategory = Category::select('parent_id', 'id', 'slug', 'title')->where('parent_id', 0)->get();

		$mainCatalogs = Catalog::select('parent_id', 'id', 'slug', 'title')->where('parent_id', 0)->get();

		$startWeek = Carbon::now()->startOfWeek();
		$endWeek = Carbon::now()->endOfWeek();

		$events = Event::select('title','start','className')->where('start', '>=', $startWeek)->where('end', '<=', $endWeek)->orderBy('start')->get()->groupBy('start');

		$view->with('currentUser', $currentUser);
		$view->with('typeCategory', $typeCategory);
		$view->with('events', $events);
		$view->with('mainCatalogs', $mainCatalogs);
	}
}
