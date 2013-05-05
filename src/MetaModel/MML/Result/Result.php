<?php

namespace MetaModel\MML\Result;

interface Result
{

    /**
     * Returns the content of the wrapping Result object
     *
     * @return mixed
     */
    public function unwrap();

}
