@extends('layouts.admin')


@section('content')

    <h1>Edit Category</h1>

    @include('includes.form_errors')

    <div class="col-sm-6">

        {{ Form::model($category, ['method' => 'patch', 'action' => ['AdminCategoriesController@update', $category->id]]) }}

        <div class="form-group">
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Update Category', ['class' => 'btn btn-primary col-sm-6']) }}
        </div>

        {{ Form::close() }}

        {{ Form::open(['method' => 'delete', 'action' => ['AdminCategoriesController@destroy', $category->id]]) }}

        <div class="form-group">
            {{ Form::submit('Delete Category', ['class' => 'btn btn-danger col-sm-6']) }}
        </div>

        {{ Form::close() }}

    </div>

@endsection