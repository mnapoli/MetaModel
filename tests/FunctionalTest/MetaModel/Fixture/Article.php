<?php

namespace FunctionalTest\MetaModel\Fixture;

/**
 * @Entity
 */
class Article
{

	/**
	 * @Id @Column(type="integer")
	 */
	private $id;

	/**
	 * @ManyToOne(targetEntity="Category", inversedBy="articles")
	 **/
	private $category;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory(Category $category) {
		$this->category = $category;
	}

}
