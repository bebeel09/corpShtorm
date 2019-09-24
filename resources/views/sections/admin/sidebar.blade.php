        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header nav-small-cap"></li>
                    @role('admin')
                        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('news') }}">
                                <i class="fa fa-arrow-left"></i> <span>Перейти на сайт</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{route('admin.dashboard')}}">
                                <i class="fa fa-lock"></i> <span>Админ-панель</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('admin.events') ? 'active' : '' }}">
                            <a href="{{route('admin.events')}}">
                                <i class="fa fa-lock"></i> <span>События</span>
                            </a>
                        </li>
                      
                        <li class="{{ (Request::routeIs('admin.users.*')) ? 'active' : '' }}">
                            <a href="{{route('admin.users.index')}}">
                                <i class="fa fa-newspaper-o"></i> <span>Пользователи</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('admin.users.create')}}"><i class="fa fa-circle-thin"></i>Добавить</a></li>
                                <li><a href="{{route('admin.users.index')}}"><i class="fa fa-circle-thin"></i>Список пользователей</a></li>
                            </ul>
                        </li>
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
                    @endrole
                </ul>
            </section>
        </aside>