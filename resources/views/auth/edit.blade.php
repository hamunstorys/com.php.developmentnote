@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Edit Profile</h1>
        <hr>
        <div class="row">
            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <div class="alert alert-info alert-dismissable">
                    <a class="panel-close close" data-dismiss="alert">×</a>
                    <i class="fa fa-coffee"></i><strong>회원 정보 수정</strong>
                </div>
                <h3>Personal info</h3>
                <Form action="{{route('users.edit.update',$user->id)}}" method="post">
                    {{csrf_field()}}
                    <input name="_method" type="hidden" value="PUT">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">이름:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="name" type="text" value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="email" type="text" value="{{$user->email}}"
                                   disabled=disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">비밀번호:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" value="" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">비밀번호 확인:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" value="" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">회원정보 수정</button>
                            <span></span>
                            <input type="reset" class="btn btn-default" value="Cancel">
                        </div>
                    </div>
                </Form>
            </div>
        </div>
    </div>
    <hr>
@endsection