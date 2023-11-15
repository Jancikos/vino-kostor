<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'connection_1' => 
  array (
    'tablesByName' => 
    array (
      'product' => '\\App\\Model\\Map\\ProductTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Product' => '\\App\\Model\\Map\\ProductTableMap',
    ),
  ),
));
