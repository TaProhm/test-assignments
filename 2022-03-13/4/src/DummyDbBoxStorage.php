<?php

namespace Trial\Box;

class DummyDbBoxStorage
{
    // private $db;

    public function insert(array $data)
    {
        // $db->insert($data);
    }

    public function update(array $data)
    {
        foreach ($data as $key => $value) {
            // $db->update($key, $value);
        }
    }

    public function all(): array
    {
        $rows = [];
        // $rows = $db->selectAll()
        return $rows;
    }
}