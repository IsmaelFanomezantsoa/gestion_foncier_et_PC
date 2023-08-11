<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class UploaderFile {

    public function __construct(private SluggerInterface $slugger)
    {}
    public function uploadFile( UploadedFile $file , string $directoryImage){

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $directoryImage,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                return $newFilename;
    }
}
