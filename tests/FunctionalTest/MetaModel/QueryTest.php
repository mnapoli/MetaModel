<?php

namespace FunctionalTest\MetaModel;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use MetaModel\Bridge\Doctrine\EntityManagerBridge;
use MetaModel\MetaModel;
use FunctionalTest\MetaModel\Fixture\Category;
use FunctionalTest\MetaModel\Fixture\Article;

class QueryTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var MetaModel
	 */
	private $metaModel;

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

		$this->metaModel = new MetaModel();
		$this->metaModel->addObjectManager(new EntityManagerBridge($this->em));
	}

	public function testGetById() {
		$article = new Article(1);
		$this->em->persist($article);
		$this->em->flush();

		$result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Article(1)');

		$this->assertSame($article, $result);
	}

	public function testGetNotFound() {
		$result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Article(1)');

		$this->assertNull($result);
	}

    public function testPropertyAccessScalar() {
        $article = new Article(1);
        $this->em->persist($article);
        $this->em->flush();

        $result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Article(1).id');

        $this->assertSame(1, $result);
    }

    public function testPropertyAccessObject() {
        $article = new Article(1);
        $category = new Category(1);
        $category->addArticle($article);
        $article->setCategory($category);
        $this->em->persist($article);
        $this->em->persist($category);
        $this->em->flush();

        $result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Article(1).category');

        $this->assertSame($category, $result);

        $result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Category(1).articles');

        $this->assertContainsOnly($article, $result);
    }

    public function testRecursivePropertyAccess() {
        $article = new Article(1);
        $category = new Category(1);
        $category->addArticle($article);
        $article->setCategory($category);
        $this->em->persist($article);
        $this->em->persist($category);
        $this->em->flush();

        $result = $this->metaModel->run('FunctionalTest\MetaModel\Fixture\Article(1).category.id');

        $this->assertSame(1, $result);
    }
}
