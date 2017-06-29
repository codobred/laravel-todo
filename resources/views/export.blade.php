@extends('layouts.notes')

@section('content')
    <div class="row">
        <div class="page-header">
            <h1>Выберите формат для экспорта</h1>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-12 col-md-6">
                <form action="{{ route('export') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group col-xs-12">
                        <label for="export_method">Формат для экспорта заметок</label>
                        <select name="format" id="export_method" class="form-control">
                            <option value="xml">xml</option>
                            <option value="txt">txt</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 text-right">
                        <button class="btn btn-primary" type="submit">Экспортировать</button>
                    </div>
                </form>
            </div>

            <div class="col-xs-12 col-md-6 well" style="margin-top: 25px;">
                <p>Выберите слева формат для экспорта и нажмите кнопку &laquo;Экспортировать&raquo;</p>
            </div>
        </div>
    </div>
@endsection