# MetaModel

MetaModel provides a model for representing, traversing and performing actions on your model (Doctrine entities).

[![Build Status](https://travis-ci.org/mnapoli/MetaModel.png?branch=master)](https://travis-ci.org/mnapoli/MetaModel) [![Coverage Status](https://coveralls.io/repos/mnapoli/MetaModel/badge.png?branch=master)](https://coveralls.io/r/mnapoli/MetaModel?branch=master)

Work in progress

## MML Syntax (MetaModel Language)

Get a specific object by its ID:

```php
Article(1)

// Multiple primary keys can also be supported (watch for the order):
Article(1,12)
```

Object graph traversing (get all the articles of a category):

    Category(1).articles

Field filtering:

    Article[author="bob"]

Field filtering over an association:

    Article[author=User(1)]

Combinations:

    // All the articles of the blogs of User 1
    Blog[owner=User(1)].categories.articles

Operators:

    UserGroup[ users.contains(User(1)) ]
    UserGroup[ users.count() > 0 ]

Call methods:

```php
User[email="me@example.com"].resetPassword()

// Will call generateExtract() on all articles
Article(*).generateExtract()
```

## Integration

MetaModel finds objects in data sources.
You can add any data source by implementing the simple interfaces: `ObjectManager` and `Container`.

Some libraries are already supported natively:

- Doctrine's Entity Manager: `MetaModel\Bridge\Doctrine\EntityManagerBridge`

Add your own by submitting a pull request.

## Usages

Those are both ideas and work in progress. To be completed.

* [Simplified Model/DB manipulation from console](https://github.com/mnapoli/MetaConsole) (instead of using phpMyAdmin, or building an admin interface, you can manipulate the DB with high level object queries)

* Simplified object queries (from database)

* Advanced replacement for [PropertyAccess](https://github.com/symfony/PropertyAccess), e.g. to build forms, templates (Twig?)

* Paths for anything meta on your model: logs, AOP, ACL (e.g. "`User(1)` can edit `Category(12).articles`")

Projects using MetaModel:

- [MetaConsole](https://github.com/mnapoli/MetaConsole)
- [Xport](https://github.com/myclabs/Xport)
