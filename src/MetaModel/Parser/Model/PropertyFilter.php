<?php

namespace MetaModel\Parser\Model;

/**
 * Property filter
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PropertyFilter implements Filter
{
    const OPERATOR_EQUALS = '=';

    /**
     * Object property to apply the filter to
     * @var string
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var int
     */
    private $operator;
}
