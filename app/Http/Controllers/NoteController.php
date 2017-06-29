<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Note;


class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::orderByDesc('created_at')->paginate(25);

        return view('index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }


    /**
     * @param StoreNoteRequest $request
     * @return mixed
     */
    public function store(StoreNoteRequest $request)
    {
        try {
            $note = Note::create($request->all());
        } catch (QueryException $exception) {
            return back()->withErrors([
                'error' => 'Не удалось создать заметку.',
            ]);
        }

        // check if have uploaded image
        if (isset($request->images) && !is_null($request->images)) {
            $this->storeNoteImages($request->images, $note->id);

        }

        return redirect()->action('NoteController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::firstOrFail($id);
        if (!$note)
            return response('Page not found', 404);

        return view('show', compact($note));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = Note::find($id);

        return view('edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreNoteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNoteRequest $request, $id)
    {
        $note = Note::findOrFail($id);


        try {
            $note->update($request->all());
        } catch (QueryException $exception) {
            return back()->withErrors([
                'error' => 'Не удалось отредактировать заметку.',
            ]);
        }

        // check if have uploaded image
        if (isset($request->images) && !is_null($request->images)) {
            $this->storeNoteImages($request->images, $note->id);

        }

        return redirect()->action('NoteController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect('/notes');
    }

    public function import()
    {
        return view('import');
    }

    public function deleteImage(Request $request)
    {
        Image::findOrFail($request->image_id)->delete();

        return response()->json(['status' => 'ok']);
    }

    protected function storeNoteImages($images, $note_id)
    {
        foreach ($images as $image) {
            $extension_file = '.' . $image->getClientOriginalExtension();
            $path = 'upload/images';
            $link = $path . "/{$note_id}id" . uniqid() . $extension_file;

            // save image on a server
            $image->move($path, public_path($link));

            // store to DB
            Image::create([
                'note_id' => $note_id,
                'link' => $link,
            ]);
        }
    }
}
