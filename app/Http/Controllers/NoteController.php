<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Input;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::paginate(25);

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
     * @return $this|\Illuminate\Http\RedirectResponse
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

        if (isset($request->images) && !is_null($request->images)) {
            foreach ($request->images as $image) {
                $extension_file = '.' . $image->getClientOriginalExtension();
                $path = public_path('upload/images');
                $link = $path . "/{$note->id}/" . uniqid() . $extension_file;
                $image->move($path, $link);
                Image::create('image' -> $link);
            }
            Image::
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
        $note = Note::find($id);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
    }

    public function import()
    {
        return view('import');
    }

    public function export()
    {
        return view('export');
    }
}
