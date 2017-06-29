<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\ImportRequest;
use SimpleXMLElement;

class ImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(ImportRequest $request)
    {
        $file = $request->file('file');
        $content = file_get_contents($file->path());
        if (!strlen($content))
            return back()->withErrors(['error' => 'file is empty']);

        if ($file->extension() === "xml") {
            $xmlFile = new SimpleXMLElement($content);
            foreach ($xmlFile as $field) {
                Note::create([
                    'short_description' => $field['short_description'],
                    'content' => $field['content'],
                ]);
            }
        } elseif ($file->extension() === "txt") {
            $dump = explode('||##||', $content);
            if (count($dump) != 3) {
                return back()->withErrors(['error' => "can't parse this file"]);
            }

            Note::create([
                'short_description' => $dump[1],
                'content' => $dump[2],
            ]);
        }

        return redirect('/');
    }

}
