<?php

namespace System\FileSystem;

class File{
    protected string $fileName;

    public function __construct($fileName){
        $this->fileName = $fileName;
    }

    public function isExists() : bool {
        return file_exists($this->fileName);
    }

    public function getFileName() : string {
        return $this->fileName;
    }

    public function getContent() : string {
        return file_get_contents($this->fileName);
    }

    public function getLines() : array {
        return explode("\n", $this->getContent());
    }

    public function copy($destination) : bool {
        return copy($this->fileName, $destination);
    }

    public function deleteFile() : bool {
        return unlink($this->fileName);
    }
}