<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Helper\FileHelper;
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

        // path for export folder
        $exportPath = public_path('export-note/XmlExport/') . uniqid() . '/';

        @mkdir($exportPath, 0700, true);

        // write field to xml file
        foreach ($notes as $note) {
            $xml->startElement('data');
            $xml->writeAttribute('created_at', $note->created_at);
            $xml->writeAttribute('content', $note->content);
            $xml->writeAttribute('short_description', $note->short_description);
            $xml->writeAttribute('id', $note->id);
            $xml->endElement();

            // full path to folder with xml file and images
            $pathToFolder = $exportPath . $note->id;
            @mkdir($pathToFolder);

            // copy  images from server to export folder
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

        $exportFile = $exportPath . 'AllNotes.xml';
        file_put_contents($exportFile, $content);

        $archivePath = public_path('XmlExport.zip');

        // create archive with xml file and images
        FileHelper::createArchive($archivePath, $exportPath);
        // remove files
        FileHelper::removeFiles($exportPath);

        return response()->download($archivePath);
    }

    protected function txtExport($notes)
    {
        $exportPath = public_path('export-note/TxtExport/') . uniqid() . '/';
        @mkdir($exportPath, 0700, true);

        foreach ($notes as $note)
        {
            $file = fopen($exportPath . "id{$note->id}.txt", "a");
            fwrite($file, 'note_id# ' . $note->id . "\n");
            fwrite($file, 'note_short_description# ' . $note->short_description . "\n" );
            fwrite($file, 'note_content# ' . $note->content . "\n" );
            fclose($file);

            // path to folder with notes and images
            $pathToFolder = $exportPath . $note->id;
            // copy images to export folder
            FileHelper::copyImagesToFolder($pathToFolder, $note);

        }

        // set path for archive
        $archivePath = public_path('TxtExport.zip');
        // create archive with files
        FileHelper::createArchive($archivePath, $exportPath);
        // remove files
        FileHelper::removeFiles($exportPath);

        return response()->download($archivePath);
    }
}
