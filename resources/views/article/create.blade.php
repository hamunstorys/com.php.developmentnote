@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <Form action="{{route('article.store')}}" enctype="multipart/form-data" method="post">
                        {!!csrf_field()!!}
                        <div class="form-group">
                            <label class="control-label">
                                게시물 작성
                            </label>
                        </div>
                        <div class="form-group {{ $errors->has('thumbnail')?'has-error':'' }}">
                            <label class="control-label">
                                Thumbnail
                            </label>
                            <input type="file" name="thumbnail" class="form-control">
                            {!! $errors->first('thumbnail', '<span class="form-error">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('subject')?'has-error':'' }}">
                            <label class="control-label" for="subject">
                                Subject
                            </label>
                            <input class="form-control" id="subject" name="subject" type="text"/>
                            {!! $errors->first('subject', '<span class="form-error">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('content')?'has-error':'' }}">
                            <label class="control-label" for="content">
                                Content
                            </label>
                            <textarea name="content" id="content">{{old('content')}}</textarea>
                            {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
                        </div>
                        <div class="form-group row" style="text-align: center">
                            <div class="col-xs-12">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-lg" type="submit">확인</button>
                                    <button class="btn btn-default btn-lg" type="button">취소</button>
                                </div>
                            </div>
                        </div>
                    </Form>
                </div>
                <div class="col-sm-2 col-md-2"></div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @extends('layouts.footer')
@endsection

@section('js')
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };

        CKEDITOR.replace('content', options);
    </script>
@stop