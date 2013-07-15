<?php

namespace MetaModel\Parser\Model;

/**
 * Selector
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Selector
{
    /**
     * Class name
     * @var string
     */
    private $name;

    /**
     * ID selector
     * @var mixed|null
     */
    private $id;

    /**
     * @var Filter[]
     */
    private $filters = [];

    /**
     * @param string $class
     * @param mixed  $id ID selector
     * @return Selector
     */
    public static function createSelectorById($class, $id)
    {
        $selector = new self();

        $selector->name = $class;
        $selector->id = $id;

        return $selector;
    }

    /**
     * @param string   $class
     * @param Filter[] $filters
     * @return Selector
     */
    public static function createSelectorByFilters($class, array $filters)
    {
        $selector = new self();

        $selector->name = $class;
        $selector->filters = $filters;

        return $selector;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Filter[]
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
