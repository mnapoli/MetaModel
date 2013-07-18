<?php

namespace MetaModel\Model;

use MetaModel\ExecutionException;
use MetaModel\MetaModel;

/**
 * Array access
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class ArrayAccess implements Node
{
    /**
     * @var string|integer
     */
    private $key;

    /**
     * @var Node
     */
    private $subNode;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        if (is_numeric($key)) {
            $key = (int) $key;
        }

        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(MetaModel $metaModel)
    {
        $array = $this->subNode->execute($metaModel);

        if ((!is_array($array)) && (!$array instanceof \ArrayAccess)) {
            throw new ExecutionException("Array access is impossible on a variable that is not an array, or implementing \\ArrayAccess");
        }

        if (!isset($array[$this->key])) {
            return null;
        }

        return $array[$this->key];
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return Node
     */
    public function getSubNode()
    {
        return $this->subNode;
    }

    /**
     * @param Node $subNode
     */
    public function setSubNode(Node $subNode)
    {
        $this->subNode = $subNode;
    }
}
