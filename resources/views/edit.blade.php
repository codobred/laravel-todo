@extends('layouts.notes')

@section('content')
    <div class="row">
        <div class="page-header">
            <h1>Редактировать заметку</h1>
        </div>

        <div class="col-xs-12" style="margin-bottom: 50px;">
            <form action="{{ action('NoteController@update', ['id' => $note->id]) }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group">
                    <label for="short_description">Краткое Содержимое</label>
                    <textarea name="short_description"
                              required="required"
                              id="short_description"
                              rows="5"
                              class="form-control"
                              placeholder="Краткое содержимое заметки (200 символов)"
                              maxlength="200"
                    >{{ $note->short_description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Заметка</label>
                    <textarea name="content"
                              required="required"
                              id="content"
                              rows="5"
                              class="form-control summernote"
                              placeholder="Текст заметки"
                    >{{ $note->content }}</textarea>
                </div>

                <div class="form-group well">
                    @if( count($note->image) )
                        <p>Картинки, которые Вы загрузили ранее</p>
                        <ol>
                            @foreach($note->image as $img)
                                <li>
                                    <button class="btn btn-danger pull-right delete-image"
                                            data-image-id="{{ $img->id }}"
                                            data-loading-text="<i class='glyphicon glyphicon-refresh gly-spin'></i> Удаляем.."
                                    >
                                        Удалить картинку
                                    </button>
                                    <a href="{{ url($img->link) }}">
                                        <img src="{{ url($img->link) }}" alt="" style="width: 50px; height: 50px;">
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p>Вы ещё не загрузили ни одной картинки..</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="thumbs">Картинки заметки</label>
                    <input name="images[]" type="file" id="thumbs" multiple>
                    <p class="help-block">Можно загрузить несколько картинок</p>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<!-- include summernote css -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- include summernote js -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script type="text/javascript">
    $(function() {
        // delete note image button listener
        var $delbtn = $('.delete-image').on('click', function(event) {
            event.preventDefault();

            var $this = $(this);

            $this.button('loading');
            $.ajax({
                url: '{{ route('ajax.delete-image') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    image_id: $this.data('image-id')
                },
                success: function(resp) {
                    if (resp.status) $this.parents('li').remove();
                },
                error: function() {
                    alert('Не удалось удалить!');
                }
            }).always(function() {
                $delbtn.button('reset');
            });

        });
    });
</script>
@endpush