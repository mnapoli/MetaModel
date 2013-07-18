<?php

namespace MetaModel\DataSource;

/**
 * Container interface
 */
interface Container
{
    /**
     * Returns an object by its entry name in the container.
     *
     * Must return null if entry not found, not throw an exception.
     *
     * @param string $name Entry name
     *
     * @return mixed|null
     */
    public function get($name);
}
