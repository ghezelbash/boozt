<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/bootstrap.php';

$bootstrap = new Bootstrap();
echo $bootstrap->router();