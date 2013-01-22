<?php

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['elements.total'] = 6;
$app['elements.min'] = 0;
$app['elements.max'] = 360;

$app['elements.random'] = function ($app) {
    $elements = array();

    for ($index = 0; $index < $app['elements.total']; $index++) {
        $elements[$index] = mt_rand($app['elements.min'], $app['elements.max']);
    }

    return $elements;
};

$app['elements'] = $app['elements.random'];

$app['sort.insertionsort'] = function () {
    return new Sorting\InsertionSort();
};

$app['sort.quicksort'] = function () {
    return new Sorting\InsertionSort();
};

$app['sort'] = $app['sort.insertionsort'];

$app['observer.snapshots'] = function() {
    return new Sorting\IterationSnapshots();
};

$app->get('/sort/{algorithm}', function ($algorithm) use ($app) {
    $snapshots = $app['observer.snapshots'];
    $algorithm = $app['sort'];
    $algorithm->addObserver($snapshots);
    $algorithm->sort($app['elements']);

    return $app['twig']->render('horizontal.html.twig', array(
        'snapshots' => $snapshots,
    ));
});

return $app;