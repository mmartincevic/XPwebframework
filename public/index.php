<?php
/**
 * XPF
 *
 * @author      djomla <mladen.martincevic@g.com>
 * @copyright   2014 djomla
 * @link        http://github.com/mmartincevic/
 * @version     1.0
 * @package     XPF
 *
*/
require '../vendor/autoload.php';
require '../config/bootstrap.php';

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Slim-Skeleton '/' route");
    // Render index view
    $app->render('index.html');
});

// Run app
$app->run();
