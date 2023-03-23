<?php // public/index.php

require_once dirname( __DIR__ ) . '/vendor-prefixed/autoload.php';
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use MyNamespace\Model\Mario;

$marioModel = new Mario();

$marioModel->run();
