<?php

namespace MetaModel\Parser\Model;

use MetaModel\MetaModel;

/**
 * Property access
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PropertyAccess
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var Selector
     */
    private $selector;

    public function execute(MetaModel $metaModel)
    {
        $object = $this->selector->execute($metaModel);

        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();

        return $propertyAccessor->getValue($object, $this->property);
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return Selector
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * @param Selector $selector
     */
    public function setSelector(Selector $selector)
    {
        $this->selector = $selector;
    }
}
