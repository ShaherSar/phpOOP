<?php

namespace System\FileSystem;

interface FileInterface
{
    public function isExists (): bool;

    public function getFileName (): string;

    public function getContent (): string;

    public function getLines (): array;

    public function copy ($destination): bool;

    public function deleteFile (): bool;
}