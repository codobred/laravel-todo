@extends('layouts.notes')

@section('content')
    <div class="row">
        <div class="page-header">
            <h1>Все заметки</h1>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-12 text-right">
                        <a href="{{ action('NoteController@create') }}" type="button" class="btn btn-sm btn-primary btn-create">Добавить</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th class="hidden-xs">#</th>
                            <th>Краткое содержимое</th>
                            <th>Картинки</th>
                            <th><em class="fa fa-cog"></em></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td class="hidden-xs text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $note->short_description }}
                                </td>
                                <td>
                                    images
                                </td>
                                <td style="width: 150px;" align="center">
                                    <a class="btn btn-default"
                                       href="{{ action('NoteController@edit', ['id' => $note->id]) }}"
                                    >
                                        <em class="glyphicon glyphicon-edit"></em>
                                    </a>
                                    <a class="btn btn-danger"
                                        href="{{ action('NoteController@destroy') }}"
                                    >
                                        <em class="glyphicon glyphicon-remove"></em>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col col-xs-12 text-right">
                        {{ $notes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection