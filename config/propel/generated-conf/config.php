<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion(2);
$serviceContainer->setAdapterClass('custom_database_name', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle('custom_database_name');
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=custom_database_name',
  'user' => 'root',
  'password' => '',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$serviceContainer->setConnectionManager($manager);
$serviceContainer->setDefaultDatasource('custom_database_name');
require_once __DIR__ . '\./loadDatabase.php';
