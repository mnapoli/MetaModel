<?php

namespace MetaModel;

/**
 * ObjectManager
 */
interface ObjectManager
{
    /**
     * @param string $name Object name (class name, …)
     * @param mixed $id Object id
     * @return mixed Object
     */
    public function getById($name, $id);
}
