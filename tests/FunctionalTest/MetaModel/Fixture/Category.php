<?php

namespace FunctionalTest\MetaModel\Fixture;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Category
{

	/**
	 * @Id
	 * @Column(type="integer")
	 */
	private $id;

	/**
	 * @OneToMany(targetEntity="Article", mappedBy="category")
	 **/
	private $articles;

	public function __construct($id) {
		$this->id = $id;
		$this->articles = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function getArticles() {
		return $this->articles;
	}

	public function addArticle(Article $article) {
		$this->articles->add($article);
		$article->setCategory($this);
	}

}
