<?php

namespace MetaModel\Model;

use MetaModel\MetaModel;

/**
 * Method call
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class MethodCall implements Node
{
    /**
     * @var string
     */
    private $method;

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

        $reflectionMethod = new \ReflectionMethod($object, $this->method);

        // God mode
        if ($reflectionMethod->isPrivate() || $reflectionMethod->isProtected()) {
            $reflectionMethod->setAccessible(true);
        }

        return $reflectionMethod->invoke($object);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $property
     */
    public function setMethod($property)
    {
        $this->method = $property;
    }

    /**
     * @return IdSelector
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
