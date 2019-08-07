@extends('layouts.app')

@section('content')
{{--    <div class="pageTitle-block">--}}
{{--        <h2>Новости</h2>--}}
{{--    </div>--}}
    <div class="box">
        <div class="box-body">
            <h3><a href="/blog/posts/electromig-550-synergic-evolyutsiya-moshchnosti">Информация по замене банковских карт.</a></h3>
            <p><a class="text-purple text-uppercase" href="https://partners.hitechsvarka.ru/blog/category/main">#Новости</a></p>


            <p>Заработная плата за июль будет перечислятся на старые имеющиеся карты!

                Тем сотрудникам, у кого карты заканчиваются июлем, необходимо карту получить!

                Карты VISA GOLD будут выданы в середине августа</p>

        </div>
        <div class="box-footer">
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col">

                    <a class="btn btn-round btn-bold btn-primary" href="/blog/posts/electromig-550-synergic-evolyutsiya-moshchnosti">Подробнее</a>
                </div>
                <div class="col">
                    <a href="index.html" class="user-profile">
                        <img src="https://pp.userapi.com/c639230/v639230484/330e0/xBUNIhelAh0.jpg?ava=1" alt="user">
                        <span>Евгения Лунина</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="box">
    <div class="box-body">
        <h3><a href="/blog/posts/electromig-550-synergic-evolyutsiya-moshchnosti">Про поиск товаров в АМО и уведомления!</a></h3>
        <div class="tags"><a class="text-purple text-uppercase" href="">#Новости</a><a class="text-purple text-uppercase" href="">#AmoCRM</a></div>

        <p>Поиск товаров в АМО починили теперь он один в один как в 1С. Спасибо вам за обратную связь, становимся лучше каждый день!

            Так же большая просьба обратить внимание на центр уведомлений в АМО он находится внизу слева...</p>

        <p>Мы произвели настройку этих уведомлений, сейчас туда будут приходить только нужные уведомления такие как:</p>
            <ul>
                <li>Задачи: Вам поставлена новая задача</li>
                <li>Задачи: За 5 минут до выполнения задачи</li>
                <li>Задачи: Поставленная вам задача выполнена / просрочена</li>
                <li>Звонки</li>
                <li>Сообщения чата (на основе сделки или просто сообщений внутри компаний)</li>
            </ul>
        <p>Теперь стоит обращать внимание на эту иконку :) Всем хорошего дня!</p>

    </div>
    <div class="box-footer">
        <div class="row align-items-center justify-content-between mt-3">
            <div class="col">

                <a class="btn btn-round btn-bold btn-primary" href="/blog/posts/electromig-550-synergic-evolyutsiya-moshchnosti">Подробнее</a>
            </div>
            <div class="col">
                <a href="index.html" class="user-profile">
                    <img src="https://pp.userapi.com/c639230/v639230484/330e0/xBUNIhelAh0.jpg?ava=1" alt="user">
                    <span>Евгения Лунина</span>
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col">
            <div id="pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
