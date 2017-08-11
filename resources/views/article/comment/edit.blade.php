@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-8">
            <div class="card my-4">
                <div class="card-block">
                    <Form action="{{route('comment.update',$comment->id)}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="name" value="{{auth()->user()->__get('name')}}">
                        <div class="form-group {{ $errors->has('comment')?'has-error':'' }}">
                            <textarea name="comment" class="form-control" rows="3">{{$comment->comment}}</textarea>
                            {!! $errors->first('comment', '<span class="form-error">:message</span>') !!}
                        </div>
                        <button type="submit" class="btn btn-primary">수정</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop