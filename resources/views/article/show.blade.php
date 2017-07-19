@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Post Content Column -->
            <div class="col-lg-8">
                <!-- Title -->
                <h1 class="mt-4">{{$article->subject}}</h1>
                <div class="pull-right">
                    {!! Form::model($article, ['route' => ['article.destroy', $article->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('삭제', array('class' => 'btn-sm btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
                <div class="pull-right">
                    {!! Form::model($article, ['route' => ['article.edit', $article->id], 'method' => 'GET']) !!}
                    {!! Form::submit('수정', array('class' => 'btn-sm btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
                <p class="lead">
                    <!-- Author -->
                    Posted by {{$article->name}}<br/>
                    <!-- Date/Time -->
                    Posted on {{$article->updated_at}}
                </p>
                <hr>
                <!-- Post Content -->
                <div class="article">
                    {!! $article->content!!}
                </div>
                <hr>
                <!-- Comments Form -->
                <div class="card my-4">
                    <h5 class="card-header">댓글 남기기</h5>
                    <div class="card-block">
                        <Form action="{{route('comment.store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="article" value="{{$article->id}}">
                            <input type="hidden" name="name" value="{{auth()->user()->__get('name')}}">
                            <div class="form-group {{ $errors->has('comment')?'has-error':'' }}">
                                <textarea name="comment" class="form-control" rows="3"></textarea>
                                {!! $errors->first('comment', '<span class="form-error">:message</span>') !!}
                            </div>
                            <button type="submit" class="btn btn-primary">댓글 작성</button>
                        </form>
                    </div>
                </div>
                <!-- Single Comment -->
                <h1>Comments</h1>
                @foreach($comments as $comment)
                    <div class="media mb-4">
                        <div class="media-body">
                            <h5 class="mt-0">
                                작성자 {{$comment->name}}
                                <div class="pull-right">
                                    {!! Form::model($comment, ['route' => ['comment.destroy', $comment->id], 'method' => 'DELETE']) !!}
                                    {!! Form::submit('삭제', array('class' => 'btn-sm btn-primary')) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="pull-right">
                                    {!! Form::model($comment, ['route' => ['comment.edit', $comment->id], 'method' => 'GET']) !!}
                                    {!! Form::submit('수정', array('class' => 'btn-sm btn-primary')) !!}
                                    {!! Form::close() !!}
                                </div>
                            </h5>
                            {{$comment->comment}}
                        </div>

                    </div>
                @endforeach
            </div>


            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Search Widget -->
                <div class="card my-4">
                    <h5 class="card-header lead">검색</h5>
                    <div class="card-block">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="검색">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Categories Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Categories</h5>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">HTML</a></li>
                                    <li><a href="#">Freebies</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">JavaScript</a></li>
                                    <li><a href="#">CSS</a></li>
                                    <li><a href="#">Tutorials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side Widget -->
                <div class="card my-4">
                    <h5 class="card-header">Side Widget</h5>
                    <div class="card-block">
                        You can put anything you want inside of these side widgets. They are easy to use, and feature
                        the
                        new Bootstrap 4 card containers!
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@stop

@section('js')
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script>
@stop

@section('css')
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
@stop
