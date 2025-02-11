<?php

namespace App\Services;

use App\Entity\Candidate;
use App\Interfaces\FileHandlerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHandler implements FileHandlerInterface
{
    private FileUploader $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        // when the dependency is injected, it will be an instance of FileUploader
        $this->fileUploader = $fileUploader;
    }

    
    public function handleFiles(Candidate $candidate, array $files): void
    {
        foreach ($files as $field => $file) {

            // check if the file is an instance of UploadedFile
            if ($file instanceof UploadedFile) {

                // create the setter method name
                $methodName = 'set'. 'File' . ucfirst($field);

                // 
                $fileName = $this->fileUploader->upload($file, $candidate, $field, $this->getUploadDirectory($field));

                // check if the candidate has the setter method
                if (method_exists($candidate, $methodName)) {

                    // set the candidate property with the new file name
                    $candidate->$methodName($fileName);
                }
            }
        }
    }

    private function getUploadDirectory(string $field): string
    {
        return match ($field) {
            'profilPicture' => 'profile-pictures',
            'passport' => 'passport',
            'cv' => 'curriculum-vitae',
            default => 'uploads',
        };
    }
}