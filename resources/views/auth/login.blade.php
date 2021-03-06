@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">로그인</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('users.sessions.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('email')?'has-error':'' }}">
                                <label for="email" class="col-md-4 control-label">이메일 주소</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>
                                </div>
                                {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password')?'has-error':'' }}">
                                <label for="password" class="col-md-4 control-label">비밀번호</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> 기억하기
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        로그인
                                    </button>
                                    <a class="btn btn-link" href="{{route('users.remind.create')}}">
                                        비밀번호를 잊어버리셨습니까?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
