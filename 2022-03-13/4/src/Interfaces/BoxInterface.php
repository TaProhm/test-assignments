<?php

namespace Trial\Box\Interfaces;

interface BoxInterface
{
    public function setData($key, $value): self;
    public function getData($key);
    public function save();
    public function load();
}