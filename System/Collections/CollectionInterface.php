<?php

namespace System\Collections;

interface CollectionInterface
{
    public function push ($element, $key = null);

    public function each ($callBack): void;

    public function map ($callBack): Collection;

    public function toArray (): array;

    public function toJson (): bool|string;

    public function count (): int;
}