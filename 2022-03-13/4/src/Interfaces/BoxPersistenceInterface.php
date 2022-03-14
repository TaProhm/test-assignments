<?php

namespace Trial\Box\Interfaces;

use Trial\Box\AbstractBox;

interface BoxPersistenceInterface
{
    public function flush(AbstractBox $box);
    public function fetch(): array;
}