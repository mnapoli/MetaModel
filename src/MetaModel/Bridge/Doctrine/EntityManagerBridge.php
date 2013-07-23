<?php

namespace MetaModel\Bridge\Doctrine;

use Doctrine\ORM\EntityManager;
use MetaModel\DataSource\ObjectManager;

/**
 * Bridge to Doctrine's entity manager
 */
class EntityManagerBridge implements ObjectManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($name, $id)
    {
        return $this->entityManager->find($name, $id);
    }

    /**
     * Returns all the objects of a type.
     *
     * @param string $name Object name (class name, …)
     *
     * @return array Object
     */
    public function getAllByName($name)
    {
        return $this->entityManager->getRepository($name)->findAll();
    }
}
