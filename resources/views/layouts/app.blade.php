<div>
    @include('flash::message')
</div>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle NavigaZtion</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('index')}}">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('article.index')}}">포스트 보기<span
                                    class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('article.create')}}">포스트 작성</a>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">계정<span class="caret"></span>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('users.sessions.create')}}">로그인</a></li>
                                    <li><a href="{{route('users.register.create')}}">회원 가입</a></li>
                                    <li><a href="{{route('users.remind.create')}}">비밀번호 초기화</a>
                                </ul>
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name.'님'}} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{route('users.edit.update',auth()->user()->__get('id'))}}">
                                        회원정보 수정
                                    </a>
                                    <a href="{{route('users.sessions.destroy')}}">
                                        로그아웃
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <Form class="form-inline form-group-lg" action="{{route('search.articles.store')}}"
                              method="POST">
                            {{csrf_field()}}
                            @php ($selects = \App\Models\article\Select::get())
                                <select class="form-control input-lg" name="select">
                                    @foreach($selects as $select)
                                        <option value="{{ $select->value }}">{{$select->query}}</option>
                                    @endforeach
                                </select>
                                <input class="form-control {{ $errors->has('query')?'has-error':'' }}" type="text"
                                       placeholder="Search" name="query"
                                       value="{{old('query', isset($query) ? $query : null) }}">
                                {!! $errors->first('query', '<span class="form-error">:message</span>') !!}
                                <button class="btn btn-outline-inf btn-lg btn-success" type="submit">검색</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    @extends('layouts.footer')
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
