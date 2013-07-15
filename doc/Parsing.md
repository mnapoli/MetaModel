# Parsing

## Selector

### ID

    Article(1)

parses to:

    Selector {
        name = "Article"
        id = 1
    }

### Filter

    Article[author="bob"]

parses to:

    Selector {
        name = "Article"
        filters = [
            PropertyFilter {
                property = "author"
                value = "bob"
                operator = EQUALS
            }
        ]
    }

## Property access

    Article(1).author

parses to:

    PropertyAccess {
        property = "author"
        target = Selector { … }
    }

## Method call

    Article(1).delete()

parses to:

    MethodCall {
        method = "delete"
        parameters = []
        target = Selector { … }
    }
