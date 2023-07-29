<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderImage {

    public function __construct(private SluggerInterface $slugger)
    {}
    public function uploadImage( UploadedFile $imageFile , string $directoryImage){

        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $directoryImage,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                return $newFilename;
    }
}
