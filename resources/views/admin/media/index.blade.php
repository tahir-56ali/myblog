@extends('layouts.admin')

@section('content')

    <h1>Photos</h1>

    @if(Session::has('deleted_image'))
        <p class="bg-danger">{{session('deleted_image')}}</p>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        @if ($photos)
            @foreach($photos as $photo)
                <tr>
                    <td>{{$photo->id}}</td>
                    <td><img height="50" src="{{$photo->file ? $photo->file : 'no photo'}}" alt=""></td>
                    <td>{{$photo->created_at->diffForHumans()}}</td>
                    <td>

                        {{ Form::open(['method' => 'delete', 'action' => ['AdminMediasController@destroy', $photo->id]]) }}
                        <div class="form-group">
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger col-sm-6']) }}
                        </div>
                        {{ Form::close() }}

                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

@endsection
