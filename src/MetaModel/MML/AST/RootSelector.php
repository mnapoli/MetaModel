<?php

namespace MetaModel\MML\AST;

use Doctrine\ORM\EntityManager;
use MetaModel\MML\Result\ObjectCollection;
use MetaModel\MML\Result\SingleObject;

class RootSelector extends Node
{

    /**
     * @var string
     */
    private $className;

    /**
     * @var mixed|null
     */
    private $id;

    /**
     * @param string     $className
     * @param mixed|null $id
     */
    public function __construct($className, $id = null)
    {
        $this->className = $className;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(EntityManager $entityManager)
    {
        if ($this->hasId()) {
            $object = $entityManager->find($this->className, $this->id);

            $wrappedObject = new SingleObject($object);
            return $wrappedObject;
        } else {
            $qb = $entityManager->createQueryBuilder();
            $qb->select('class');
            $qb->from($this->className, 'class');
            $objects = $qb->getQuery()->getResult();

            $collection = new ObjectCollection($objects);
            return $collection;
        }
    }

    /**
     * @return bool
     */
    private function hasId()
    {
        return $this->id !== null;
    }

}
