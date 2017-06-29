<?php

namespace App\Http\Helper;

use Chumper\Zipper\Facades\Zipper;


class FileHelper
{
    public static function createArchive($archivePath, $exportPath)
    {
        Zipper::make($archivePath)
            ->add($exportPath)
            ->close();
    }

    public static function removeFiles($path)
    {
        // remove files from export directory
        \File::deleteDirectory($path, true);
        // remove export folder
        rmdir($path);
    }

    public static function copyImagesToFolder($pathToFolder, $note)
    {
        @mkdir($pathToFolder);

        // copy  images from server to export folder
        foreach ($note->image as $image) {
            copy(
                public_path($image->link),
                $pathToFolder . '/' . pathinfo($image->link, PATHINFO_BASENAME)
            );
        }
    }
}