<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'connection_1' => 
  array (
    'tablesByName' => 
    array (
      'customer' => '\\App\\Model\\Map\\CustomerTableMap',
      'product' => '\\App\\Model\\Map\\ProductTableMap',
      'user' => '\\App\\Model\\Map\\UserTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Customer' => '\\App\\Model\\Map\\CustomerTableMap',
      '\\Product' => '\\App\\Model\\Map\\ProductTableMap',
      '\\User' => '\\App\\Model\\Map\\UserTableMap',
    ),
  ),
));
