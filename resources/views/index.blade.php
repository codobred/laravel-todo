@extends('layouts.notes')

@section('content')
    <div class="well">
        Список всех заметок здесь
        <div>
            @foreach($notes as $note)
                {{ $loop->iteration }} ----- {{ $note->note_name }} ----- {{ $note->note_short_description }}<br />
            @endforeach
        </div>
    </div>
@endsection