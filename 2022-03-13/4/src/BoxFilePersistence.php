<?php

namespace Trial\Box;

use Trial\Box\Interfaces\BoxPersistenceInterface;

/**
 * Если предполагается хранить большие объемны данных, то можно перейти на иерархическое хранение данных в папках
 * и отдельных файлах для каждого ключа. Чтобы не превысить лимиты файловой системы и снизить цену изменения данных.
 */
class BoxFilePersistence implements BoxPersistenceInterface
{
    private \SplFileInfo $fileInfo;

    public function __construct(\SplFileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function flush(AbstractBox $box)
    {
        file_put_contents($this->fileInfo->getRealPath(), serialize($box->getAllData()));
        $box->persisted();
    }

    public function fetch(): array
    {
        $filePath = $this->fileInfo->getRealPath();
        $serializedData = file_get_contents($filePath);

        if ($serializedData === false) {
            throw new \RuntimeException("File storage can't be properly read, file: $filePath");
        }

        if ($serializedData === "") {
            return [];
        }

        $data =  unserialize($serializedData);
        if ($data === false) {
            throw new \RuntimeException("File storage can't be properly deserialized, file: $filePath");
        }

        return $data;
    }
}