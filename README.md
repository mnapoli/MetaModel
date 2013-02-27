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

Multiple primary keys can also be supported (watch for the order):

    Article(1,12)

Object graph traversing (get all the articles of a category):

    Category(1)/Article(*)

Field filtering:

    Article[author="bob"]

Field filtering over an association:

    Article[author=User(1)]

Combinations:

    Blog[owner=User(1)]/Category(*)/Article(*)

## Usages

Those are both ideas and work in progress. To be completed.

* Simplified object queries (from database)
* Simplified Model/DB manipulation from console (e.g. instead of using phpMyAdmin, or building an admin interface, you can manipulate the DB with high level object queries)
* Paths for anything meta on your model: logs, AOP, ACL (e.g. `User(1)` can edit `Category(12)/Article(*)`)
