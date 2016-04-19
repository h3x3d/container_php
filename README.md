# Container #

```php

$cont = new \H3x3d\Container();
// $cont = \H3x3d\Container::instance();
$cont->set('test', function ($c) {
    return 10;
});

$cont->set('test1', function ($c, $test) {
    echo $test;

    return $test;
});

$cont->get('test1', 'I\'m test variable');

$f = $cont->factory('test1');

$f('test123');

```
