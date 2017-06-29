@extends('layouts.notes')

@section('content')
    <div class="well">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group col-xs-12">
                <input type="file" name="file" class="form-control">
            </div>
            <div class="form-group col-xs-12 text-right">
                <button class="btn btn-primary" type="submit">Импортировать</button>
            </div>
        </form>
    </div>
@endsection