<?php

namespace System\Collections;

use System\Interfaces\Arrayable;
use System\Interfaces\Jsonable;

class Collection implements Jsonable, Arrayable, \Countable {
    protected array $elements = [];

    public function push($element, $key = null){
        if(!$key){
            $this->elements[] = $element;
            return;
        }
        $this->elements[$key] = $element;
    }

    public static function collect(array $elements): Collection {
        $newCollection = new self;

        foreach($elements as $key => $element){
            $newCollection->push($element, $key);
        }

        return $newCollection;
    }

    public function each($callBack) : void {
        foreach($this->elements as $key => $element){

        }
    }

    public function map($callBack) : Collection {
        return array_map($callBack,$this->elements);
    }

    public function toArray() : array {
        return $this->elements;
    }

    public function toJson(): bool|string {
        return json_encode($this->elements);
    }

    public function count() : int{
        return count($this->elements);
    }
}