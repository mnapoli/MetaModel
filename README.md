# MetaModel

Meta is a **DSL** that enables to represent, traverse and operate on PHP objects.

[![Build Status](https://travis-ci.org/mnapoli/MetaModel.png?branch=master)](https://travis-ci.org/mnapoli/MetaModel) [![Coverage Status](https://coveralls.io/repos/mnapoli/MetaModel/badge.png?branch=master)](https://coveralls.io/r/mnapoli/MetaModel?branch=master)


## Syntax

- Get a specific object by its ID:

```php
Article(1)
```

MetaModel integrates with **Doctrine**, but can be connected to anything.

- Get all objects of a type

```php
Article(*)
```

- Object graph traversing (get all the articles of a category):

```php
Category(1).articles
```

- Call methods:

```php
// Will call generateExtract() on all articles
Article(*).generateExtract()
```

- Field filtering (not implemented yet):

```php
Article[author="bob"]
```

Operators:

```php
UserGroup[ users.contains(User(1)) ]
UserGroup[ users.count() > 0 ]
```

- Service:

```php
CacheService.flush()
```

MetaModel integrates with containers, registries, anything…


## Integration

MetaModel finds objects in data sources.
You can add any data source by implementing the simple interfaces: `ObjectManager` or `Container`.

Some libraries are already supported natively:

- **Doctrine**'s Entity Manager: `MetaModel\Bridge\Doctrine\EntityManagerBridge`

    ```php
    $metaModel = new MetaModel();
    $metaModel->addObjectManager(new EntityManagerBridge($entityManager));
    ```

- [**PHP-DI**](https://github.com/mnapoli/PHP-DI) container: `MetaModel\Bridge\PHPDI\PHPDIBridge`

    ```php
    $metaModel = new MetaModel();
    $metaModel->addContainer(new PHPDIBridge($container));
    ```

Add your own by submitting a pull request.

## Usages

Those are both ideas and work in progress.

* **MetaConsole**: [Simplified Model/DB manipulation from console](https://github.com/mnapoli/MetaConsole)

Instead of using phpMyAdmin, or building an admin interface, you can manipulate the DB with high level object queries.

* Advanced replacement for [PropertyAccess](https://github.com/symfony/PropertyAccess), e.g. to build forms, templates (Twig?)

* Simplified object queries (from database)

* Paths for anything meta on your model: logs, AOP, ACL (e.g. "`User(1)` can edit `Category(12).articles`")

Projects using MetaModel:

- [MetaConsole](https://github.com/mnapoli/MetaConsole)
- [Xport](https://github.com/myclabs/Xport)
