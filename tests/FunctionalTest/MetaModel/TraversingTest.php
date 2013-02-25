<?php

namespace FunctionalTest\MetaModel;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use MetaModel\MetaModelService;
use FunctionalTest\MetaModel\Fixture\Category;
use FunctionalTest\MetaModel\Fixture\Article;

class TraversingTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var EntityManager
	 */
	private $em;

	public function setUp() {
		$dbParams = array(
			'dbname' => 'metamodel_test',
			'memory' => 'true',
			'driver' => 'pdo_sqlite',
		);
		$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/Fixture"), true);
		$this->em = EntityManager::create($dbParams, $config);
		$tool = new SchemaTool($this->em);
		$tool->createSchema($this->em->getMetadataFactory()->getAllMetadata());
	}

	public function test1() {
		$service = new MetaModelService();
		$service->setEntityManager($this->em);
		$service->addChildrenAssociation('FunctionalTest\MetaModel\Fixture\Category', 'articles');

		$article = new Article(1);
		$category = new Category(1);
		$category->addArticle($article);
		$this->em->persist($category);
		$this->em->persist($article);
		$this->em->flush();

		$children = $service->getChildren($category);

		$this->assertCount(1, $children);
		$this->assertContains($article, $children);
	}

}
