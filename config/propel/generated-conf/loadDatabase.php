<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'connection_1' => 
  array (
    'tablesByName' => 
    array (
      'product' => '\\App\\Model\\Map\\ProductTableMap',
      'user' => '\\App\\Model\\Map\\UserTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Product' => '\\App\\Model\\Map\\ProductTableMap',
      '\\User' => '\\App\\Model\\Map\\UserTableMap',
    ),
  ),
));
