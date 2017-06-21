<?php

namespace Dhii\Data;

/**
 * Something that has a key.
 *
 * @since [*next-version*]
 */
trait KeyAwareTrait
{
    /**
     * The key.
     *
     * @since [*next-version*]
     *
     * @var string
     */
    protected $key;

    /**
     * Retrieves the key.
     *
     * @since [*next-version*]
     *
     * @return string
     */
    protected function _getKey()
    {
        return $this->key;
    }

    /**
     * Sets the key.
     *
     * @since [*next-version*]
     *
     * @param string $key The key.
     *
     * @return $this
     */
    protected function _setKey($key)
    {
        $this->key = $key;

        return $this;
    }
}
