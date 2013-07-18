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
}
