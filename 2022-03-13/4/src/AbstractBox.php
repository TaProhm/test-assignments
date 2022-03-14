<?php

namespace Trial\Box;

use Trial\Box\Interfaces\BoxInterface;
use Trial\Box\Interfaces\BoxPersistenceInterface;

/**
 * Делаю иерархию классов/интерфейсов как в задании.
 * Но вообще, можно обойтись без наследования и сделать просто класс Box в который через композицию передавать объект
 * BoxPersistenceInterface для работы с постоянным хранилищем данных. BoxInterface, DbBox и FileBox тогда ненужны.
 * Еще можно вывести функционал save/load в отдельный класс, чтобы уменьшить ответственность (поводы для изменения) Box.
 */
abstract class AbstractBox implements BoxInterface
{
    protected array $data = [];
    protected array $new = [];
    protected array $dirty = [];

    protected BoxPersistenceInterface $persistence;

    /**
     * @param mixed $key
     * @param bool|int|float|string|array $value
     * @return $this
     */
    public function setData($key, $value): self
    {
        if (array_key_exists($key, $this->data)) {
            if ($this->data[$key] !== $value && !in_array($key, $this->dirty)) {
                $this->dirty[] = $key;
            }
        } else {
            $this->new[] = $key;
        }

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function getData($key)
    {
        if (!array_key_exists($key, $this->data)) {
            throw new \RuntimeException("Missing box storage key: $key");
        }

        return $this->data[$key];
    }

    public function save()
    {
        return $this->persistence->flush($this);
    }

    public function load()
    {
        $this->data = $this->persistence->fetch();
    }

    public function getAllData(): array
    {
        return $this->data;
    }

    public function getNew(): array
    {
        return $this->new;
    }

    public function getDirty(): array
    {
        return $this->dirty;
    }

    public function resetNew(): self
    {
        $this->new = [];

        return $this;
    }

    public function resetDirty(): self
    {
        $this->dirty = [];

        return $this;
    }

    public function persisted(): self
    {
        $this->resetDirty()->resetNew();

        return $this;
    }
}