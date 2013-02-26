# MetaModel

MetaModel provides a model for representing and traversing your model (Doctrine entities).

Each entity can have parents and children entities.

Work in progress

## Description of the object graph

```php
class Article
{
	/**
	 * @ParentObject
	 * @var Category
	 **/
	private $category;

	/**
	 * @ParentObjects
	 * @var Tag[]
	 **/
	private $tags;

	/**
	 * @SubObjects
	 * @var Comment[]
	 **/
	private $comments;

	// ...
}
```

## Query syntax

Get a specific object by its ID:

    Article(1)

Object graph traversing (get all the articles of a category):

    Category(1)/Article(*)

Field filtering:

    Article[author="bob"]

Combination:

    Blog(12)/Category[published=true]/Article(*)
