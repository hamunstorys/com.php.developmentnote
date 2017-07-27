@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">회원가입</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('users.register.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group  {{ $errors->has('name')?'has-error':'' }}">
                                <label for="name" class="col-md-4 control-label">이름</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" autofocus>
                                    {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">이메일 주소</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}">
                                    {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">비밀번호</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                    {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">비밀번호 확인</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation">
                                </div>
                                {!! $errors->first('password_confirmation', '<span class="form-error">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        회원가입
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
