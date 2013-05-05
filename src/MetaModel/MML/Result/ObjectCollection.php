<?php

namespace MetaModel\MML\Result;

use Doctrine\Common\Collections\ArrayCollection;

class ObjectCollection extends ArrayCollection implements Result
{

    /**
     * {@inheritdoc}
     */
    public function unwrap()
    {
        return $this->toArray();
    }
}
