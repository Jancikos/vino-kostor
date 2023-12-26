<?php

namespace App\Model\Map;

use App\Model\Order;
use App\Model\OrderQuery;
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
 * This class defines the structure of the 'order' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class OrderTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.OrderTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'connection_1';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'order';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Order';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Model\\Order';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Order';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the PK_ field
     */
    public const COL_PK_ = 'order.PK_';

    /**
     * the column name for the CUSTOMER_PK_ field
     */
    public const COL_CUSTOMER_PK_ = 'order.CUSTOMER_PK_';

    /**
     * the column name for the USER_PK_ field
     */
    public const COL_USER_PK_ = 'order.USER_PK_';

    /**
     * the column name for the STATUS field
     */
    public const COL_STATUS = 'order.STATUS';

    /**
     * the column name for the CREATED field
     */
    public const COL_CREATED = 'order.CREATED';

    /**
     * the column name for the PACKED field
     */
    public const COL_PACKED = 'order.PACKED';

    /**
     * the column name for the SHIPPED field
     */
    public const COL_SHIPPED = 'order.SHIPPED';

    /**
     * the column name for the PAIED field
     */
    public const COL_PAIED = 'order.PAIED';

    /**
     * the column name for the REAL_PRICE field
     */
    public const COL_REAL_PRICE = 'order.REAL_PRICE';

    /**
     * the column name for the NOTE field
     */
    public const COL_NOTE = 'order.NOTE';

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
        self::TYPE_PHPNAME       => ['Pk', 'CustomerPk', 'UserPk', 'Status', 'Created', 'Packed', 'Shipped', 'Paied', 'RealPrice', 'Note', ],
        self::TYPE_CAMELNAME     => ['pk', 'customerPk', 'userPk', 'status', 'created', 'packed', 'shipped', 'paied', 'realPrice', 'note', ],
        self::TYPE_COLNAME       => [OrderTableMap::COL_PK_, OrderTableMap::COL_CUSTOMER_PK_, OrderTableMap::COL_USER_PK_, OrderTableMap::COL_STATUS, OrderTableMap::COL_CREATED, OrderTableMap::COL_PACKED, OrderTableMap::COL_SHIPPED, OrderTableMap::COL_PAIED, OrderTableMap::COL_REAL_PRICE, OrderTableMap::COL_NOTE, ],
        self::TYPE_FIELDNAME     => ['PK_', 'CUSTOMER_PK_', 'USER_PK_', 'STATUS', 'CREATED', 'PACKED', 'SHIPPED', 'PAIED', 'REAL_PRICE', 'NOTE', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
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
        self::TYPE_PHPNAME       => ['Pk' => 0, 'CustomerPk' => 1, 'UserPk' => 2, 'Status' => 3, 'Created' => 4, 'Packed' => 5, 'Shipped' => 6, 'Paied' => 7, 'RealPrice' => 8, 'Note' => 9, ],
        self::TYPE_CAMELNAME     => ['pk' => 0, 'customerPk' => 1, 'userPk' => 2, 'status' => 3, 'created' => 4, 'packed' => 5, 'shipped' => 6, 'paied' => 7, 'realPrice' => 8, 'note' => 9, ],
        self::TYPE_COLNAME       => [OrderTableMap::COL_PK_ => 0, OrderTableMap::COL_CUSTOMER_PK_ => 1, OrderTableMap::COL_USER_PK_ => 2, OrderTableMap::COL_STATUS => 3, OrderTableMap::COL_CREATED => 4, OrderTableMap::COL_PACKED => 5, OrderTableMap::COL_SHIPPED => 6, OrderTableMap::COL_PAIED => 7, OrderTableMap::COL_REAL_PRICE => 8, OrderTableMap::COL_NOTE => 9, ],
        self::TYPE_FIELDNAME     => ['PK_' => 0, 'CUSTOMER_PK_' => 1, 'USER_PK_' => 2, 'STATUS' => 3, 'CREATED' => 4, 'PACKED' => 5, 'SHIPPED' => 6, 'PAIED' => 7, 'REAL_PRICE' => 8, 'NOTE' => 9, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Pk' => 'PK_',
        'Order.Pk' => 'PK_',
        'pk' => 'PK_',
        'order.pk' => 'PK_',
        'OrderTableMap::COL_PK_' => 'PK_',
        'COL_PK_' => 'PK_',
        'PK_' => 'PK_',
        'order.PK_' => 'PK_',
        'CustomerPk' => 'CUSTOMER_PK_',
        'Order.CustomerPk' => 'CUSTOMER_PK_',
        'customerPk' => 'CUSTOMER_PK_',
        'order.customerPk' => 'CUSTOMER_PK_',
        'OrderTableMap::COL_CUSTOMER_PK_' => 'CUSTOMER_PK_',
        'COL_CUSTOMER_PK_' => 'CUSTOMER_PK_',
        'CUSTOMER_PK_' => 'CUSTOMER_PK_',
        'order.CUSTOMER_PK_' => 'CUSTOMER_PK_',
        'UserPk' => 'USER_PK_',
        'Order.UserPk' => 'USER_PK_',
        'userPk' => 'USER_PK_',
        'order.userPk' => 'USER_PK_',
        'OrderTableMap::COL_USER_PK_' => 'USER_PK_',
        'COL_USER_PK_' => 'USER_PK_',
        'USER_PK_' => 'USER_PK_',
        'order.USER_PK_' => 'USER_PK_',
        'Status' => 'STATUS',
        'Order.Status' => 'STATUS',
        'status' => 'STATUS',
        'order.status' => 'STATUS',
        'OrderTableMap::COL_STATUS' => 'STATUS',
        'COL_STATUS' => 'STATUS',
        'STATUS' => 'STATUS',
        'order.STATUS' => 'STATUS',
        'Created' => 'CREATED',
        'Order.Created' => 'CREATED',
        'created' => 'CREATED',
        'order.created' => 'CREATED',
        'OrderTableMap::COL_CREATED' => 'CREATED',
        'COL_CREATED' => 'CREATED',
        'CREATED' => 'CREATED',
        'order.CREATED' => 'CREATED',
        'Packed' => 'PACKED',
        'Order.Packed' => 'PACKED',
        'packed' => 'PACKED',
        'order.packed' => 'PACKED',
        'OrderTableMap::COL_PACKED' => 'PACKED',
        'COL_PACKED' => 'PACKED',
        'PACKED' => 'PACKED',
        'order.PACKED' => 'PACKED',
        'Shipped' => 'SHIPPED',
        'Order.Shipped' => 'SHIPPED',
        'shipped' => 'SHIPPED',
        'order.shipped' => 'SHIPPED',
        'OrderTableMap::COL_SHIPPED' => 'SHIPPED',
        'COL_SHIPPED' => 'SHIPPED',
        'SHIPPED' => 'SHIPPED',
        'order.SHIPPED' => 'SHIPPED',
        'Paied' => 'PAIED',
        'Order.Paied' => 'PAIED',
        'paied' => 'PAIED',
        'order.paied' => 'PAIED',
        'OrderTableMap::COL_PAIED' => 'PAIED',
        'COL_PAIED' => 'PAIED',
        'PAIED' => 'PAIED',
        'order.PAIED' => 'PAIED',
        'RealPrice' => 'REAL_PRICE',
        'Order.RealPrice' => 'REAL_PRICE',
        'realPrice' => 'REAL_PRICE',
        'order.realPrice' => 'REAL_PRICE',
        'OrderTableMap::COL_REAL_PRICE' => 'REAL_PRICE',
        'COL_REAL_PRICE' => 'REAL_PRICE',
        'REAL_PRICE' => 'REAL_PRICE',
        'order.REAL_PRICE' => 'REAL_PRICE',
        'Note' => 'NOTE',
        'Order.Note' => 'NOTE',
        'note' => 'NOTE',
        'order.note' => 'NOTE',
        'OrderTableMap::COL_NOTE' => 'NOTE',
        'COL_NOTE' => 'NOTE',
        'NOTE' => 'NOTE',
        'order.NOTE' => 'NOTE',
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
        $this->setName('order');
        $this->setPhpName('Order');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Model\\Order');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PK_', 'Pk', 'INTEGER', true, null, null);
        $this->addColumn('CUSTOMER_PK_', 'CustomerPk', 'INTEGER', true, null, null);
        $this->addColumn('USER_PK_', 'UserPk', 'INTEGER', true, null, null);
        $this->addColumn('STATUS', 'Status', 'INTEGER', true, null, null);
        $this->addColumn('CREATED', 'Created', 'TIMESTAMP', true, null, null);
        $this->addColumn('PACKED', 'Packed', 'TIMESTAMP', false, null, null);
        $this->addColumn('SHIPPED', 'Shipped', 'TIMESTAMP', false, null, null);
        $this->addColumn('PAIED', 'Paied', 'TIMESTAMP', false, null, null);
        $this->addColumn('REAL_PRICE', 'RealPrice', 'FLOAT', false, null, null);
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
        return $withPrefix ? OrderTableMap::CLASS_DEFAULT : OrderTableMap::OM_CLASS;
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
     * @return array (Order object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = OrderTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderTableMap::OM_CLASS;
            /** @var Order $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderTableMap::addInstanceToPool($obj, $key);
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
            $key = OrderTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Order $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OrderTableMap::COL_PK_);
            $criteria->addSelectColumn(OrderTableMap::COL_CUSTOMER_PK_);
            $criteria->addSelectColumn(OrderTableMap::COL_USER_PK_);
            $criteria->addSelectColumn(OrderTableMap::COL_STATUS);
            $criteria->addSelectColumn(OrderTableMap::COL_CREATED);
            $criteria->addSelectColumn(OrderTableMap::COL_PACKED);
            $criteria->addSelectColumn(OrderTableMap::COL_SHIPPED);
            $criteria->addSelectColumn(OrderTableMap::COL_PAIED);
            $criteria->addSelectColumn(OrderTableMap::COL_REAL_PRICE);
            $criteria->addSelectColumn(OrderTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.PK_');
            $criteria->addSelectColumn($alias . '.CUSTOMER_PK_');
            $criteria->addSelectColumn($alias . '.USER_PK_');
            $criteria->addSelectColumn($alias . '.STATUS');
            $criteria->addSelectColumn($alias . '.CREATED');
            $criteria->addSelectColumn($alias . '.PACKED');
            $criteria->addSelectColumn($alias . '.SHIPPED');
            $criteria->addSelectColumn($alias . '.PAIED');
            $criteria->addSelectColumn($alias . '.REAL_PRICE');
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
            $criteria->removeSelectColumn(OrderTableMap::COL_PK_);
            $criteria->removeSelectColumn(OrderTableMap::COL_CUSTOMER_PK_);
            $criteria->removeSelectColumn(OrderTableMap::COL_USER_PK_);
            $criteria->removeSelectColumn(OrderTableMap::COL_STATUS);
            $criteria->removeSelectColumn(OrderTableMap::COL_CREATED);
            $criteria->removeSelectColumn(OrderTableMap::COL_PACKED);
            $criteria->removeSelectColumn(OrderTableMap::COL_SHIPPED);
            $criteria->removeSelectColumn(OrderTableMap::COL_PAIED);
            $criteria->removeSelectColumn(OrderTableMap::COL_REAL_PRICE);
            $criteria->removeSelectColumn(OrderTableMap::COL_NOTE);
        } else {
            $criteria->removeSelectColumn($alias . '.PK_');
            $criteria->removeSelectColumn($alias . '.CUSTOMER_PK_');
            $criteria->removeSelectColumn($alias . '.USER_PK_');
            $criteria->removeSelectColumn($alias . '.STATUS');
            $criteria->removeSelectColumn($alias . '.CREATED');
            $criteria->removeSelectColumn($alias . '.PACKED');
            $criteria->removeSelectColumn($alias . '.SHIPPED');
            $criteria->removeSelectColumn($alias . '.PAIED');
            $criteria->removeSelectColumn($alias . '.REAL_PRICE');
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
        return Propel::getServiceContainer()->getDatabaseMap(OrderTableMap::DATABASE_NAME)->getTable(OrderTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Order or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Order object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\Order) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderTableMap::DATABASE_NAME);
            $criteria->add(OrderTableMap::COL_PK_, (array) $values, Criteria::IN);
        }

        $query = OrderQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OrderTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OrderTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return OrderQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Order or Criteria object.
     *
     * @param mixed $criteria Criteria or Order object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Order object
        }

        if ($criteria->containsKey(OrderTableMap::COL_PK_) && $criteria->keyContainsValue(OrderTableMap::COL_PK_) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OrderTableMap::COL_PK_.')');
        }


        // Set the correct dbName
        $query = OrderQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
