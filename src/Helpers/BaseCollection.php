<?php

namespace Wearesho\Bobra\Portmone\Helpers;

/**
 * Class BaseCollection
 * @package Wearesho\Bobra\Portmone\Helpers
 */
abstract class BaseCollection extends \ArrayObject implements \JsonSerializable
{
    protected const TYPE = null;

    /**
     * BaseCollection constructor.
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iterator_class
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $input = [], int $flags = 0, string $iterator_class = \ArrayIterator::class)
    {
        foreach ($input as $item) {
            $this->validateInstance($item);
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    final public function type(): string
    {
        return static::TYPE;
    }

    public function jsonSerialize(): array
    {
        return (array)$this;
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function append($value): void
    {
        $this->validateInstance($value);

        parent::append($value);
    }

    /**
     * @param mixed $index
     * @param mixed $newval
     *
     * @throws \InvalidArgumentException
     */
    public function offsetSet($index, $newval): void
    {
        $this->validateInstance($newval);

        parent::offsetSet($index, $newval);
    }

    /**
     * @param $element
     *
     * @throws \InvalidArgumentException
     */
    protected function validateInstance($element): void
    {
        $type = $this->type();

        if (!$element instanceof $type) {
            throw new \InvalidArgumentException('Element must be instance of ' . $type);
        }
    }
}
