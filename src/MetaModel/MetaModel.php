<?php

namespace MetaModel;

use Doctrine\ORM\EntityManager;

class MetaModel
{

	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * @param string $query
	 * @return mixed
	 */
	public function get($query)
	{
		$matches = array();
		$result = preg_match('/^([\\a-zA-Z0-9]+)\(([a-zA-Z0-9]+|\*)\)$/', $query, $matches);
		if ($result === 1) {
			$class = $matches[1];
			$id = $matches[2];
			if ($id !== '*') {
				return $this->entityManager->find($class, $id);
			} else {
				$qb = $this->entityManager->createQueryBuilder();
				$qb->select('class');
				$qb->from($class, 'class');
				return $qb->getQuery()->getResult();
			}
		}
		return null;
	}

	/**
	 * @return EntityManager
	 */
	public function getEntityManager() {
		return $this->entityManager;
	}

	/**
	 * @param EntityManager $entityManager
	 */
	public function setEntityManager(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

}
