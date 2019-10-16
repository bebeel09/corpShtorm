<?php

namespace App\Http\ViewComposers;

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

		$dateCurrentWeek = $this->x_week_range(date('Y-m-d'));
		$events = Event::select('title', 'start', 'end', 'className', 'id')->where('start', '>=', $dateCurrentWeek[0])->where('end', '<=', $dateCurrentWeek[1])->orderBy('start')->get();

		$eventsDate = [];

		foreach ($events as $event) {
			$eventsDate[$event->start] = [];
		}

		foreach ($eventsDate as $key => $value) {
			foreach ($events as $event) {
				if ($key == $event->start) {
					array_push($eventsDate[$key], $event);
					// $eventDate[$key] = $event;
				}
			}
		}

		// dd($currentUser);
		$view->with('currentUser', $currentUser);
		$view->with('typeCategory', $typeCategory);
		$view->with('eventsDate', $eventsDate);
		$view->with('mainCatalogs', $mainCatalogs);
	}

	function x_week_range($date)
	{
		$dateRet = [];
		$ts = strtotime($date);
		$start = (date('w', $ts) == 1) ? $ts : strtotime('last monday', $ts);
		$dateRet[0] = date('Y-m-d', $start);
		$dateRet[1] = date('Y-m-d', strtotime('next sunday', $start));
		return $dateRet;
	}
}
