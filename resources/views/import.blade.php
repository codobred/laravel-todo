@extends('layouts.notes')

@section('content')
    <div class="row">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group col-xs-12">
                <label for="file">Выберите файл в формате txt или xml</label>
                <input id="file" type="file" name="file" class="form-control">
            </div>
            <div class="form-group col-xs-12 text-right">
                <button class="btn btn-primary" type="submit">Импортировать</button>
            </div>
        </form>
    </div>
@endsection