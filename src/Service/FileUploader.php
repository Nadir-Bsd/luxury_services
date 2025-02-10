<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct( private string $targetDirectory, private SluggerInterface $slugger) 
    {

    }

    public function upload(UploadedFile $file, object $entity, string $fieldName, string $folder): string
    {
        // get the original file name without the extension
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // tranformed the file name to a safe file name be changing space & special characters to a -
        $safeFilename = $this->slugger->slug($originalFilename);

        // take the safe file name add - & uniqid & . & the file extension
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            // move the file to the target directory with the new file name
            $file->move($this->getTargetDirectory() . '/' . $folder, $fileName);
        } catch (FileException $e) {
            throw new Exception('There was a problem uploading your file. Please try again.');
        }

        // deletes the old file
        $this->removeOldFile($entity, $fieldName, $folder);

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        // target directory come form the service configuration (services.yaml), dependencie injection
        return $this->targetDirectory;
    }

    private function removeOldFile(object $entity, string $fieldName, string $folder): void
    {
        // make getter method with the field name
        $getter = 'get'. 'File' . ucfirst($fieldName);

        // get the file name form the entity
        $oldFile = $entity->$getter();

        // check if the entity has a file
        if ($oldFile) {

            // get the old file path & delete it
            $oldFilePath = $this->getTargetDirectory() . '/' . $folder . '/' . $oldFile;

            // check if the path exists
            if (file_exists($oldFilePath)) {

                // delete the file
                unlink($oldFilePath);
            }
        }
    }
}