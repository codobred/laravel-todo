<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Image;
use XMLWriter;

class ExportController extends Controller
{
    public function export()
    {
        if (request()->getMethod() === 'POST') {
            // get all notes from database
            $format = request()->get('format');

            $notes = Note::all();

            if ($format === 'xml') {
                return $this->xmlExport($notes);
            } elseif ($format === 'txt') {
                return $this->txtExport($notes);
            }
        }

        return view('export');
    }

    protected function xmlExport($notes)
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('notes');

        $exportPath = public_path('export-note/XmlExport/') . uniqid() . '/';

        @mkdir($exportPath, 0700, true);

        foreach ($notes as $note) {
            $xml->startElement('data');
            $xml->writeAttribute('created_at', $note->created_at);
            $xml->writeAttribute('content', $note->content);
            $xml->writeAttribute('short_description', $note->short_description);
            $xml->writeAttribute('id', $note->id);
            $xml->endElement();

            $pathToFolder = $exportPath . $note->id;
            @mkdir($pathToFolder);

            foreach ($note->image as $image) {
                copy(
                    public_path($image->link),
                    $pathToFolder . '/' . pathinfo($image->link, PATHINFO_BASENAME)
                );
            }
        }

        $xml->endElement();
        $xml->endDocument();

        // clean memory
        $content = $xml->outputMemory();
        $xml = null;

        $exportFile = public_path('export-note/xmlExport-'. uniqid() .'.xml');
        file_put_contents($exportFile, $content);


        \File::deleteDirectory($exportPath, true);
        rmdir($exportPath);

        return response()->download($exportFile);
    }

    protected function txtExport($notes)
    {
        //
    }
}
