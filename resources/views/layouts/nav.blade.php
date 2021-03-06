<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li class="{{ $ekko->isActive(['/', '/posts/create', '/posts/*/edit', '/posts/*']) }}"><a href="{{ url('/') }}">文章</a></li>
                <li class="{{ $ekko->isActive(['/threads', '/threads/*', '/threads/create', '/threads/edit']) }}"><a href="{{ url('/threads') }}">问答</a></li>
                <li class="{{ $ekko->isActive('/docs') }}"><a href="{{ url('docs') }}">文档</a></li>
                @include('layouts.search')
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><i class=""></i><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    <li>
                        <a href="#" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="fa fa-plus text-md"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>
                                <a class="button no-pjax" href="{{ url('posts/create') }}" >
                                    <i class="fa fa-paint-brush text-md"></i> 创作文章
                                </a>
                            </li>

                            <li>
                                <a class="button no-pjax" href="{{ url('threads/create') }}">
                                    <i class="fa fa-comment text-md"></i> 发帖
                                </a>
                            </li>
                        </ul>
                    </li>

                    <user-notifications></user-notifications>

                    <li class="dropdown" style="height: 50px">
                        <div class="navbar-form dropdown-toggle" data-toggle="dropdown" role="button"
                              aria-expanded="false" style="padding-left: 1px;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="{{ Auth::user()->avatar_path }}" alt="" class="img-thumbnail" style="width: 30px">&nbsp;
                            {{ str_limit(Auth::user()->name, 10) }} <span class="caret"></span>
                        </div>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('profile', Auth::user()) }}">个人中心</a>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    退出
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>