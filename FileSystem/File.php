<?php

namespace FileSystem;

class File{
    protected $fileName;

    public function __construct($fileName){
        $this->fileName = $fileName;
    }

    public function isExists(){
        return file_exists($this->fileName);
    }

    public function getFileName(){
        return $this->fileName;
    }

    public function getContent(){
        return file_get_contents($this->fileName);
    }

    public function getLines(){
        return explode("\n", $this->getContent());
    }

    public function copy($destination){
        return copy($this->fileName, $destination);
    }

    public function deleteFile(){
        return unlink($this->fileName);
    }
}