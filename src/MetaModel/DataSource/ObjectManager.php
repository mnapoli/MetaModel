<?php

namespace MetaModel\DataSource;

/**
 * Object manager interface
 */
interface ObjectManager
{
    /**
     * Returns an object by its ID.
     *
     * Must return null if entry not found, not throw an exception.
     *
     * @param string $name Object name (class name, …)
     * @param mixed $id Object id
     *
     * @return mixed|null Object
     */
    public function getById($name, $id);
}
