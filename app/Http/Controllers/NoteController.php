<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->merge([
            'short_description' => strip_tags($request->short_description),
        ]);

        $this->validate($request, [
            'short_description' => 'required|max:200',
            'content' => 'required',
            'images' => 'required|image',
        ]);


        try {
            Note::create($request->all());
        } catch ( QueryException $exception ) {
            dd($exception->getMessage());
            return back()->withErrors([
               'error' => 'Не удалось создать заметку.',
            ]);
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
