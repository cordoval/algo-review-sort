<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/sort/{algorithm}', function ($algorithm) use ($app) {
    $total = 6;
    $elements = array();

    for ($index = 0; $index < $total; $index++) {
        $elements[$index] = mt_rand(0, 360);
    }

    $snaphots = new Sorting\IterationSnapshots();
    $algorithm = new Sorting\QuickSort($elements);
    $algorithm->addObserver($snaphots);
    $algorithm->sort();

    return 'Sorted';
});

$app->run();