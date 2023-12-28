<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'connection_1' => 
  array (
    'tablesByName' => 
    array (
      'customer' => '\\App\\Model\\Map\\CustomerTableMap',
      'myorder' => '\\App\\Model\\Map\\OrderTableMap',
      'myorder_item' => '\\App\\Model\\Map\\OrderItemTableMap',
      'product' => '\\App\\Model\\Map\\ProductTableMap',
      'user' => '\\App\\Model\\Map\\UserTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Customer' => '\\App\\Model\\Map\\CustomerTableMap',
      '\\Order' => '\\App\\Model\\Map\\OrderTableMap',
      '\\OrderItem' => '\\App\\Model\\Map\\OrderItemTableMap',
      '\\Product' => '\\App\\Model\\Map\\ProductTableMap',
      '\\User' => '\\App\\Model\\Map\\UserTableMap',
    ),
  ),
));
