# MetaModel

MetaModel provides a model for representing and traversing your model (Doctrine entities).

Each entity can have parents and children entities.

Work in progress

## Query syntax

Get a specific object by its ID:

    Article(1)

Model traversing (get all the articles of a category):

    Category(1)/Article(*)

Field filtering:

    Article[author="bob"]

Combination:

    Blog(12)/Category[published=true]/Article(*)
