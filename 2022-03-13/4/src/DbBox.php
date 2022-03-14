<?php

namespace Trial\Box;

final class DbBox extends AbstractBox
{
    public function __construct(BoxDbPersistence $dbPersistence)
    {
        $this->persistence = $dbPersistence;
    }
}