<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Category;
use App\Event;

class CurrentUser
{
	public function compose(View $view)
	{
		$currentUser = Auth::user();
		$typeList = Category::select('parent_id', 'id', 'type_id', 'slug', 'title')->where('parent_id', 0)
			->where('type_id', 2)
			->with(['type:id,name'])
			->get();

		$typeCategory = Category::select('parent_id', 'id', 'type_id', 'slug', 'title')->where('parent_id', 0)
			->where('type_id', 1)
			->with(['type:id,name'])
			->get();



		$dateCurrentWeek = $this->x_week_range(date('Y-m-d'));

		$events = Event::select('title', 'start', 'end', 'className', 'id')->where('start', '>=', $dateCurrentWeek[0])->where('end', '<=', $dateCurrentWeek[1])->orderBy('start')->get();
		// dd($events);
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
		$view->with('typeList', $typeList);
		$view->with('eventsDate', $eventsDate);
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
