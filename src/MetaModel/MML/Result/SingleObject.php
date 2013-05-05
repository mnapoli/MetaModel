<?php

namespace MetaModel\MML\Result;

class SingleObject
{

    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function unwrap()
    {
        return $this->object;
    }

}
