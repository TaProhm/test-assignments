<?php

namespace Trial\Box;

final class FileBox extends AbstractBox
{
    public function __construct(BoxFilePersistence $filePersistence)
    {
        $this->persistence = $filePersistence;
    }
}