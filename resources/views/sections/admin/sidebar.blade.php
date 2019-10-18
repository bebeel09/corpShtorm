        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header nav-small-cap"></li>

                    <li>
                        <a href="{{ route('showCategory', 'novosti') }}">
                            <i class="fa fa-arrow-left"></i> <span>Перейти на сайт</span>
                        </a>
                    </li>

                    
                    @hasanyrole('posts editor|grant admin')
                    <li class="{{ Request::routeIs('admin.events') ? 'active' : '' }}">
                        <a href="{{route('admin.events')}}">
                            <i class="fa fa-calendar"></i> <span>События</span>
                        </a>
                    </li>
                    @endhasanyrole

                    @hasanyrole('admin|grant admin')
                    <li class="{{ (Request::routeIs('admin.users.*')) ? 'active' : '' }}">
                        <a href="{{route('admin.users.index')}}">
                            <i class="fa fa-users"></i> <span>Пользователи</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('admin.users.create')}}"><i class="fa fa-circle-thin"></i>Добавить</a></li>
                            <li><a href="{{route('admin.users.index')}}"><i class="fa fa-circle-thin"></i>Список пользователей</a></li>
                        </ul>
                    </li>
                    @endhasanyrole

                    @hasanyrole('admin|grant admin')
                    <li class="{{ (Request::routeIs('admin.roles.*')) ? 'active' : '' }}">
                        <a href="{{route('admin.roles.index')}}">
                            <i class="fa fa-shield"></i> <span>Роли</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('admin.roles.index')}}"><i class="fa fa-circle-thin"></i>Список ролей</a></li>
                        </ul>
                    </li>
                    @endhasanyrole

                    @hasanyrole('posts editor|grant admin')
                    <li class="{{ (Request::routeIs('admin.posts.*')) ? 'active' : '' }}">
                        <a href="{{route('admin.posts.index')}}">
                            <i class="fa fa-newspaper-o"></i> <span>Посты</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('admin.posts.create')}}"><i class="fa fa-circle-thin"></i>Добавить пост</a></li>
                            <li><a href="{{route('admin.posts.index')}}"><i class="fa fa-circle-thin"></i>Список постов</a></li>
                        </ul>
                    </li>
                    @endhasanyrole

                    @hasanyrole('catalogs editor|grant admin')
                    <li class="{{ (Request::routeIs('admin.catalogPost.*')) ? 'active' : '' }}">
                        <a href="{{route('admin.catalogPost.index')}}">
                            <i class="fa fa-folder-open "></i> <span>Каталоги</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('admin.catalogPost.create')}}"><i class="fa fa-circle-thin"></i>Добавить каталог</a></li>
                            <li><a href="{{route('admin.catalogPost.index')}}"><i class="fa fa-circle-thin"></i>Список каталогов</a></li>
                        </ul>
                    </li>
                    @endhasanyrole
                </ul>
            </section>
        </aside>