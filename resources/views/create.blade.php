@extends('layouts.notes')

@section('content')
    <div class="row">
        <div class="page-header">
            <h1>Создать новую заметку</h1>
        </div>

        <div class="col-xs-12">
            <form action="{{ action('NoteController@store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="short_description">Краткое Содержимое</label>
                    <textarea name="short_description"
                              required="required"
                              id="short_description"
                              rows="5"
                              class="form-control"
                              placeholder="Краткое содержимое заметки (200 символов)"
                              maxlength="200"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="content">Заметка</label>
                    <textarea name="content"
                              required="required"
                              id="content"
                              rows="5"
                              class="form-control"
                              placeholder="Текст заметки"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="thumbs">Картинки заметки</label>
                    <input type="file" required="required" id="thumbs" multiple>
                    <p class="help-block">Можно загрузить несколько картинок</p>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </form>
        </div>
    </div>
@endsection