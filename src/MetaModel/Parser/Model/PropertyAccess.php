<?php

namespace MetaModel\Parser\Model;

use MetaModel\MetaModel;

/**
 * Property access
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class PropertyAccess implements Node
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var Node
     */
    private $subNode;

    /**
     * {@inheritdoc}
     */
    public function execute(MetaModel $metaModel)
    {
        $object = $this->subNode->execute($metaModel);

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
    public function getSubNode()
    {
        return $this->subNode;
    }

    /**
     * @param Node $node
     */
    public function setSubNode(Node $node)
    {
        $this->subNode = $node;
    }
}
