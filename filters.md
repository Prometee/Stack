Filters
=======

*Filters* on grids are a kind of search prepared for each grid. Having
a grid of objects you can filter out only those with a specified name,
or value etc. Here you can find the supported filters. Keep in mind you
can very easily define your own ones!

String
------

Simplest filter type. It can filter by one or multiple fields.

```yaml
sylius_grid:
    grids:
        app_user:
            filters:
                username:
                    type: string
                email:
                    type: string
                firstName:
                    type: string
                lastName:
                    type: string
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(Filter::create('username', 'string'))
        ->addFilter(Filter::create('email', 'string'))
        ->addFilter(Filter::create('firstName', 'string'))
        ->addFilter(Filter::create('lastName', 'string'))
    )
};
```

The filter allows the user to select following search options:

-   contains
-   not contains
-   equal
-   not equal
-   starts with
-   ends with
-   empty
-   not empty
-   in
-   not in

If you don't want display all theses matching possibilities, you can
choose just one of them. Then only the input field will be displayed.
You can achieve it like that:

```yaml
sylius_grid:
    grids:
        app_user:
            filters:
                username:
                    type: string
                    form_options:
                        type: contains
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('username', 'string')
                ->setFormOptions([
                    'type' => 'contains',
                ])
        )
    )
};
```

By configuring a filter like above you will have only an input field for
filtering users objects that `contain` a given string in their username.

Boolean
-------

This filter checks if a value is true or false.

```yaml
sylius_grid:
    grids:
        app_channel:
            filters:
                enabled:
                    type: boolean
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('enabled', 'boolean')
        )
    )
};
```

Date
----

This filter checks if a chosen datetime field is between given dates.

```yaml
sylius_grid:
    grids:
        app_order:
            filters:
                createdAt:
                    type: date
                completedAt:
                    type: date
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(Filter::create('createdAt', 'date'))
        ->addFilter(Filter::create('completedAt', 'date'))
    )
};
```

Entity
------

This type filters by a chosen entity.

```yaml
sylius_grid:
    grids:
        app_order:
            filters:
                channel:
                    type: entity
                    form_options:
                        class: "%app.model.channel.class%"
                customer:
                    type: entity
                    form_options:
                        class: "%app.model.customer.class%"
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('channel', 'entity')
                ->setFormOptions(['class' => '%app.model.channel.class%'])
        )
        ->addFilter(
            Filter::create('customer', 'entity')
                ->setFormOptions(['class' => '%app.model.customer.class%'])
        )
    )
};
```

Money
-----

This filter checks if an amount is in range and in a specified currency

```yaml
sylius_grid:
    grids:
        app_order:
            filters:
                total:
                    type: money
                    form_options:
                        scale: 3
                    options:
                        currency_field: currencyCode
                        scale: 3
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('total', 'money')
                ->setFormOptions(['scale' => 3])
                ->setOptions([
                    'currency_field' => 'currencyCode',
                    'scale' => 3,
                ])
        )
    )
};
```

### *Warning*

Providing different `scale` between *form_options* and *options*
may cause unwanted, and plausibly volatile results.

Exists
------

This filter checks if the specified field contains any value

```yaml
sylius_grid:
    grids:
        app_order:
            filters:
                date:
                    type: exists
                    options:
                        field: completedAt
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('date', 'exists')
                ->setOptions(['field' => 'completedAt'])
        )
    )
};
```

Select
------

This type filters by a value chosen from the defined list

```yaml
sylius_grid:
    grids:
        app_order:
            filters:
                state:
                    type: select
                    form_options:
                        choices:
                            sylius.ui.ready: Ready
                            sylius.ui.shipped: Shipped
```

```php
<?php

use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilder;
use Sylius\Bundle\GridBundle\Config\GridConfig;

return static function (GridConfig $grid) {
    $grid->addGrid(GridBuilder::create('app_user', '%app.model.user.class%')
        ->addFilter(
            Filter::create('state', 'select')
                ->setFormOptions([
                    'choices' => [
                        'sylius.ui.ready' => 'Ready',
                        'sylius.ui.shipped' => 'Shipped',
                    ],
                ])
        )
    )
};
```

Custom Filters
--------------

### *Tip*

If you need to create a custom filter,
read the docs [here](custom_filter.md).
