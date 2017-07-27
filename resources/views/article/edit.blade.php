@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    {{ Form::model($article, ['route' => ['article.update', $article->id], 'method' => 'POST']) }}
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="control-label">
                            게시물 수정
                        </label>
                    </div>
                    <div class="form-group {{ $errors->has('subject')?'has-error':'' }}">
                        <label class="control-label " for="subject">
                            Subject
                        </label>
                        <input class="form-control" id="subject" name="subject" type="text"
                               value="{{$article->subject}}"/>
                        {!! $errors->first('subject', '<span class="form-error">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('content')?'has-error':'' }}">
                        <label class="control-label " for="message">
                            Content
                        </label>
                        <textarea id="content" name="content">{{$article->content}}</textarea>
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
                    {{ Form::close() }}
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
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "#content",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };
        tinymce.init(editor_config);
    </script>
@stop