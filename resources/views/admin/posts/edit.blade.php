@extends('layouts.admin')

@section('content')

    <h1>Edit Post</h1>

    @include('includes.form_errors')

    {{ Form::model($post, ['method' => 'patch', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) }}

    <div class="form-group">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('category_id', 'Category:') }}
        {{ Form::select('category_id', [''=>'Choose Category'] + $categories, null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('photo_id', 'Photo:') }}
        {{ Form::file('photo_id', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('body', 'Description:') }}
        {{ Form::textarea('body', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Update Post', ['class' => 'btn btn-primary col-sm-6']) }}
    </div>

    {{ Form::close() }}

    {{ Form::open(['method' => 'delete', 'action' => ['AdminPostsController@destroy', $post->id]]) }}
    <div class="form-group">
        {{ Form::submit('Delete Post', ['class' => 'btn btn-danger col-sm-6']) }}
    </div>
    {{ Form::close() }}

@endsection
