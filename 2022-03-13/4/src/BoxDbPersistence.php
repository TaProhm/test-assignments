<?php

namespace Trial\Box;

use Trial\Box\Interfaces\BoxPersistenceInterface;

class BoxDbPersistence implements BoxPersistenceInterface
{
    private DummyDbBoxStorage $dbBoxStorage;

    public function __construct(DummyDbBoxStorage $dbBoxStorage)
    {
        $this->dbBoxStorage = $dbBoxStorage;
    }

    public function flush(AbstractBox $box)
    {
        $insert = [];
        foreach ($box->getNew() as $key) {
            $insert[$key] = $box->getData($key);
        }
        $this->dbBoxStorage->insert($insert);

        $update = [];
        foreach ($box->getDirty() as $key) {
            $update[$key] = $box->getData($key);
        }
        $this->dbBoxStorage->update($update);

        $box->persisted();

    }

    public function fetch(): array
    {
        $data = [];
        foreach ($this->dbBoxStorage->all() as $row) {
            $data[$row['key']] = $row['value'];
        }

        return $data;
    }
}