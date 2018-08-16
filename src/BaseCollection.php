<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Class BaseCollection
 * @package Wearesho\Bobra\Portmone
 */
abstract class BaseCollection extends \ArrayObject implements \JsonSerializable
{
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = \ArrayIterator::class)
    {
        foreach ($input as $item) {
            $this->validateInstance($item);
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    abstract public function type(): string;

    public function jsonSerialize(): array
    {
        return (array)$this;
    }

    public function append($value): void
    {
        $this->validateInstance($value);

        parent::append($value);
    }

    public function offsetSet($index, $newval): void
    {
        $this->validateInstance($newval);

        parent::offsetSet($index, $newval);
    }

    protected function validateInstance($element): void
    {
        $type = $this->type();

        if (!$element instanceof $type) {
            throw new \InvalidArgumentException('Element must be instance of ' . $type);
        }
    }
}
