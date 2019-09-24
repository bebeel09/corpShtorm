@extends('layouts.admin.app')


@section('additional_css')

<!-- fullCalendar -->
<!-- <link rel="stylesheet" href="{{ asset('vendor_components/fullcalendar/dist/fullcalendar.css') }}"> -->
<link rel="stylesheet" href="{{ asset('vendor_components/fullcalendar/css/fullcalendar.min.css') }}">

@endsection


@section('content')
<div class="content-body">
	<div class="container-fluid">
		<div class="row page-titles">
			<div class="col content-header">
				<h1>Календарь событий</h1>
			</div>

		</div>
		<div class="row content pl-0 pr-0">
			<!-- <div class="col-lg-3">
				<div class="card">
					<div class="card-body">
						<h4 class="card-intro-title">События</h4>

						<div class="">
							<div id="external-events" class="my-3">
								<p>Перетащи или кликни по календарю чтобы создать событие</p>
								<div class="external-event bg-primary " data-class="bg-primary"><i class="fa fa-move"></i>New Theme Release</div>
								<div class="external-event bg-success text-dark" data-class="bg-success"><i class="fa fa-move"></i>My Event</div>
								<div class="external-event bg-warning text-dark" data-class="bg-warning"><i class="fa fa-move"></i>Meet manager</div>
								<div class="external-event bg-dark " data-class="bg-dark"><i class="fa fa-move"></i>Create New theme</div>
							</div>
							
							<div class="checkbox checkbox-event pt-3 pb-5">
								<input id="drop-remove" class="styled-checkbox" type="checkbox">
								<label class="text-dark" for="drop-remove">Удалить после перетаскивания</label>
							</div>
							<a href="javascript:void()" data-toggle="modal" data-target="#add-category" class="btn btn-primary btn-event">
								<span class="align-middle"><i class="ti-plus"></i></span>
								Создать новый
							</a>
						</div>
					</div>
				</div>
			</div> -->
			<div class="col">
				<div class="card">
					<div class="card-body">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
			<!-- BEGIN MODAL -->
			<div class="modal fade none-border" id="event-modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><strong>Добавить новое событие</strong></h4>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Закрыть</button>
							<button type="button" class="btn btn-success save-event waves-effect waves-light">Создать
								событие</button>

							<button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Удалить</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal Add Category -->
			<!-- <div class="modal fade none-border" id="add-category">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><strong>Добавить событие</strong></h4>
						</div>
						<div class="modal-body">
							<form>
								<div class="row">
									<div class="col-md-6">
										<label class="control-label">Название события</label>
										<input class="form-control form-white" placeholder="Введите название" type="text" name="category-name">
									</div>
									<div class="col-md-6">
										<label class="control-label">Выбирете цвет события</label>
										<select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
											<option value="success">Успех</option>
											<option value="danger">Опасный</option>
											<option value="info">Инфо</option>
											<option value="pink">Розовый</option>
											<option value="primary">Важный</option>
											<option value="warning">Предупреждение</option>
										</select>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Закрыть</button>
							<button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Сохранить</button>
						</div>
					</div>
				</div>
			</div> -->


		</div>
	</div>
	<!-- #/ container -->
</div>

@endsection

@section('additional_js')
<script>
	var urlRouteAdd="{{route('admin.addEvent')}}",
		urlRouteDelete="{{route('admin.deleteEvent')}}",
		urlRouteUpdate="{{route('admin.updateEvent')}}",
		token = "{{csrf_token()}}",
		eventData = {!!$eventData!!};
</script>

<!-- fullCalendar -->
<script src="{{asset('vendor_components/moment/moment.min.js') }}"></script>
<script src="{{asset('vendor_components/fullcalendar/js/fullcalendar.min.js') }}"></script>
<script src="{{asset('vendor_components/fullcalendar/local/ru.js') }}"></script>
<script src="{{asset('js/plugins-init/fullcalendar-init.js') }}"></script>

@endsection