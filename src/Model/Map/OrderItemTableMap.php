<?php

namespace App\Model\Map;

use App\Model\OrderItem;
use App\Model\OrderItemQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'order_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class OrderItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.OrderItemTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'connection_1';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'order_item';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'OrderItem';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Model\\OrderItem';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'OrderItem';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the PK_ field
     */
    public const COL_PK_ = 'order_item.PK_';

    /**
     * the column name for the ORDER_PK_ field
     */
    public const COL_ORDER_PK_ = 'order_item.ORDER_PK_';

    /**
     * the column name for the PRODUCT_PK_ field
     */
    public const COL_PRODUCT_PK_ = 'order_item.PRODUCT_PK_';

    /**
     * the column name for the QUANTITY field
     */
    public const COL_QUANTITY = 'order_item.QUANTITY';

    /**
     * the column name for the PRICE field
     */
    public const COL_PRICE = 'order_item.PRICE';

    /**
     * the column name for the NOTE field
     */
    public const COL_NOTE = 'order_item.NOTE';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Pk', 'OrderPk', 'ProductPk', 'Quantity', 'Price', 'Note', ],
        self::TYPE_CAMELNAME     => ['pk', 'orderPk', 'productPk', 'quantity', 'price', 'note', ],
        self::TYPE_COLNAME       => [OrderItemTableMap::COL_PK_, OrderItemTableMap::COL_ORDER_PK_, OrderItemTableMap::COL_PRODUCT_PK_, OrderItemTableMap::COL_QUANTITY, OrderItemTableMap::COL_PRICE, OrderItemTableMap::COL_NOTE, ],
        self::TYPE_FIELDNAME     => ['PK_', 'ORDER_PK_', 'PRODUCT_PK_', 'QUANTITY', 'PRICE', 'NOTE', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Pk' => 0, 'OrderPk' => 1, 'ProductPk' => 2, 'Quantity' => 3, 'Price' => 4, 'Note' => 5, ],
        self::TYPE_CAMELNAME     => ['pk' => 0, 'orderPk' => 1, 'productPk' => 2, 'quantity' => 3, 'price' => 4, 'note' => 5, ],
        self::TYPE_COLNAME       => [OrderItemTableMap::COL_PK_ => 0, OrderItemTableMap::COL_ORDER_PK_ => 1, OrderItemTableMap::COL_PRODUCT_PK_ => 2, OrderItemTableMap::COL_QUANTITY => 3, OrderItemTableMap::COL_PRICE => 4, OrderItemTableMap::COL_NOTE => 5, ],
        self::TYPE_FIELDNAME     => ['PK_' => 0, 'ORDER_PK_' => 1, 'PRODUCT_PK_' => 2, 'QUANTITY' => 3, 'PRICE' => 4, 'NOTE' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Pk' => 'PK_',
        'OrderItem.Pk' => 'PK_',
        'pk' => 'PK_',
        'orderItem.pk' => 'PK_',
        'OrderItemTableMap::COL_PK_' => 'PK_',
        'COL_PK_' => 'PK_',
        'PK_' => 'PK_',
        'order_item.PK_' => 'PK_',
        'OrderPk' => 'ORDER_PK_',
        'OrderItem.OrderPk' => 'ORDER_PK_',
        'orderPk' => 'ORDER_PK_',
        'orderItem.orderPk' => 'ORDER_PK_',
        'OrderItemTableMap::COL_ORDER_PK_' => 'ORDER_PK_',
        'COL_ORDER_PK_' => 'ORDER_PK_',
        'ORDER_PK_' => 'ORDER_PK_',
        'order_item.ORDER_PK_' => 'ORDER_PK_',
        'ProductPk' => 'PRODUCT_PK_',
        'OrderItem.ProductPk' => 'PRODUCT_PK_',
        'productPk' => 'PRODUCT_PK_',
        'orderItem.productPk' => 'PRODUCT_PK_',
        'OrderItemTableMap::COL_PRODUCT_PK_' => 'PRODUCT_PK_',
        'COL_PRODUCT_PK_' => 'PRODUCT_PK_',
        'PRODUCT_PK_' => 'PRODUCT_PK_',
        'order_item.PRODUCT_PK_' => 'PRODUCT_PK_',
        'Quantity' => 'QUANTITY',
        'OrderItem.Quantity' => 'QUANTITY',
        'quantity' => 'QUANTITY',
        'orderItem.quantity' => 'QUANTITY',
        'OrderItemTableMap::COL_QUANTITY' => 'QUANTITY',
        'COL_QUANTITY' => 'QUANTITY',
        'QUANTITY' => 'QUANTITY',
        'order_item.QUANTITY' => 'QUANTITY',
        'Price' => 'PRICE',
        'OrderItem.Price' => 'PRICE',
        'price' => 'PRICE',
        'orderItem.price' => 'PRICE',
        'OrderItemTableMap::COL_PRICE' => 'PRICE',
        'COL_PRICE' => 'PRICE',
        'PRICE' => 'PRICE',
        'order_item.PRICE' => 'PRICE',
        'Note' => 'NOTE',
        'OrderItem.Note' => 'NOTE',
        'note' => 'NOTE',
        'orderItem.note' => 'NOTE',
        'OrderItemTableMap::COL_NOTE' => 'NOTE',
        'COL_NOTE' => 'NOTE',
        'NOTE' => 'NOTE',
        'order_item.NOTE' => 'NOTE',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('order_item');
        $this->setPhpName('OrderItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Model\\OrderItem');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PK_', 'Pk', 'INTEGER', true, null, null);
        $this->addColumn('ORDER_PK_', 'OrderPk', 'INTEGER', true, null, null);
        $this->addColumn('PRODUCT_PK_', 'ProductPk', 'INTEGER', true, null, null);
        $this->addColumn('QUANTITY', 'Quantity', 'INTEGER', true, null, null);
        $this->addColumn('PRICE', 'Price', 'FLOAT', true, null, null);
        $this->addColumn('NOTE', 'Note', 'VARCHAR', false, 500, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? OrderItemTableMap::CLASS_DEFAULT : OrderItemTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (OrderItem object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = OrderItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderItemTableMap::OM_CLASS;
            /** @var OrderItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderItemTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = OrderItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var OrderItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderItemTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(OrderItemTableMap::COL_PK_);
            $criteria->addSelectColumn(OrderItemTableMap::COL_ORDER_PK_);
            $criteria->addSelectColumn(OrderItemTableMap::COL_PRODUCT_PK_);
            $criteria->addSelectColumn(OrderItemTableMap::COL_QUANTITY);
            $criteria->addSelectColumn(OrderItemTableMap::COL_PRICE);
            $criteria->addSelectColumn(OrderItemTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.PK_');
            $criteria->addSelectColumn($alias . '.ORDER_PK_');
            $criteria->addSelectColumn($alias . '.PRODUCT_PK_');
            $criteria->addSelectColumn($alias . '.QUANTITY');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.NOTE');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(OrderItemTableMap::COL_PK_);
            $criteria->removeSelectColumn(OrderItemTableMap::COL_ORDER_PK_);
            $criteria->removeSelectColumn(OrderItemTableMap::COL_PRODUCT_PK_);
            $criteria->removeSelectColumn(OrderItemTableMap::COL_QUANTITY);
            $criteria->removeSelectColumn(OrderItemTableMap::COL_PRICE);
            $criteria->removeSelectColumn(OrderItemTableMap::COL_NOTE);
        } else {
            $criteria->removeSelectColumn($alias . '.PK_');
            $criteria->removeSelectColumn($alias . '.ORDER_PK_');
            $criteria->removeSelectColumn($alias . '.PRODUCT_PK_');
            $criteria->removeSelectColumn($alias . '.QUANTITY');
            $criteria->removeSelectColumn($alias . '.PRICE');
            $criteria->removeSelectColumn($alias . '.NOTE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(OrderItemTableMap::DATABASE_NAME)->getTable(OrderItemTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a OrderItem or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or OrderItem object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\OrderItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderItemTableMap::DATABASE_NAME);
            $criteria->add(OrderItemTableMap::COL_PK_, (array) $values, Criteria::IN);
        }

        $query = OrderItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OrderItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OrderItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return OrderItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OrderItem or Criteria object.
     *
     * @param mixed $criteria Criteria or OrderItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OrderItem object
        }

        if ($criteria->containsKey(OrderItemTableMap::COL_PK_) && $criteria->keyContainsValue(OrderItemTableMap::COL_PK_) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OrderItemTableMap::COL_PK_.')');
        }


        // Set the correct dbName
        $query = OrderItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
