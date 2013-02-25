<?php

namespace MetaModel;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccess;

class MetaModelService
{

	/**
	 * @var EntityManager
	 */
	private $entityManager;

	private $children = [];

	/**
	 * @param object $entity
	 * @return array
	 */
	public function getChildren($entity) {
		$entityName = get_class($entity);

		if (!array_key_exists($entityName, $this->children)) {
			return [];
		}
		$propertyAccessor = PropertyAccess::getPropertyAccessor();

		$children = [];
		foreach ($this->children[$entityName] as $fieldName) {
			$value = $propertyAccessor->getValue($entity, $fieldName);
			if (is_array($value) or $value instanceof Collection) {
				foreach ($value as $child) {
					$children[] = $child;
				}
			} else {
				$children[] = $value;
			}
		}

		return $children;
	}

	public function addChildrenAssociation($entityName, $fieldName) {
		$this->children[$entityName][] = $fieldName;
	}

	public function setEntityManager(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

}
