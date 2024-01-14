<?php
// $context is loaded from public/index.php

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion(2);
$serviceContainer->setAdapterClass('connection_1', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle('connection_1');
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => $context['PROPEL_DSN'],
  'user' => $context['PROPEL_USER'],
  'password' => $context['PROPEL_PASSWORD'],
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$serviceContainer->setConnectionManager($manager);
$serviceContainer->setDefaultDatasource('connection_1');
// require_once __DIR__ . '\./loadDatabase.php';
require_once __DIR__ . '/loadDatabase.php';
