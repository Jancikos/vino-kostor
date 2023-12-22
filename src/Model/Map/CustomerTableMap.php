<?php

namespace App\Model\Map;

use App\Model\Customer;
use App\Model\CustomerQuery;
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
 * This class defines the structure of the 'customer' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class CustomerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.CustomerTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'connection_1';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'customer';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Customer';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Model\\Customer';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Customer';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the PK_ field
     */
    public const COL_PK_ = 'customer.PK_';

    /**
     * the column name for the FIRSTNAME field
     */
    public const COL_FIRSTNAME = 'customer.FIRSTNAME';

    /**
     * the column name for the LASTNAME field
     */
    public const COL_LASTNAME = 'customer.LASTNAME';

    /**
     * the column name for the EMAIL field
     */
    public const COL_EMAIL = 'customer.EMAIL';

    /**
     * the column name for the PHONE field
     */
    public const COL_PHONE = 'customer.PHONE';

    /**
     * the column name for the ADDRESS field
     */
    public const COL_ADDRESS = 'customer.ADDRESS';

    /**
     * the column name for the CITY field
     */
    public const COL_CITY = 'customer.CITY';

    /**
     * the column name for the NOTE field
     */
    public const COL_NOTE = 'customer.NOTE';

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
        self::TYPE_PHPNAME       => ['Pk', 'Firstname', 'Lastname', 'Email', 'Phone', 'Address', 'City', 'Note', ],
        self::TYPE_CAMELNAME     => ['pk', 'firstname', 'lastname', 'email', 'phone', 'address', 'city', 'note', ],
        self::TYPE_COLNAME       => [CustomerTableMap::COL_PK_, CustomerTableMap::COL_FIRSTNAME, CustomerTableMap::COL_LASTNAME, CustomerTableMap::COL_EMAIL, CustomerTableMap::COL_PHONE, CustomerTableMap::COL_ADDRESS, CustomerTableMap::COL_CITY, CustomerTableMap::COL_NOTE, ],
        self::TYPE_FIELDNAME     => ['PK_', 'FIRSTNAME', 'LASTNAME', 'EMAIL', 'PHONE', 'ADDRESS', 'CITY', 'NOTE', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
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
        self::TYPE_PHPNAME       => ['Pk' => 0, 'Firstname' => 1, 'Lastname' => 2, 'Email' => 3, 'Phone' => 4, 'Address' => 5, 'City' => 6, 'Note' => 7, ],
        self::TYPE_CAMELNAME     => ['pk' => 0, 'firstname' => 1, 'lastname' => 2, 'email' => 3, 'phone' => 4, 'address' => 5, 'city' => 6, 'note' => 7, ],
        self::TYPE_COLNAME       => [CustomerTableMap::COL_PK_ => 0, CustomerTableMap::COL_FIRSTNAME => 1, CustomerTableMap::COL_LASTNAME => 2, CustomerTableMap::COL_EMAIL => 3, CustomerTableMap::COL_PHONE => 4, CustomerTableMap::COL_ADDRESS => 5, CustomerTableMap::COL_CITY => 6, CustomerTableMap::COL_NOTE => 7, ],
        self::TYPE_FIELDNAME     => ['PK_' => 0, 'FIRSTNAME' => 1, 'LASTNAME' => 2, 'EMAIL' => 3, 'PHONE' => 4, 'ADDRESS' => 5, 'CITY' => 6, 'NOTE' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Pk' => 'PK_',
        'Customer.Pk' => 'PK_',
        'pk' => 'PK_',
        'customer.pk' => 'PK_',
        'CustomerTableMap::COL_PK_' => 'PK_',
        'COL_PK_' => 'PK_',
        'PK_' => 'PK_',
        'customer.PK_' => 'PK_',
        'Firstname' => 'FIRSTNAME',
        'Customer.Firstname' => 'FIRSTNAME',
        'firstname' => 'FIRSTNAME',
        'customer.firstname' => 'FIRSTNAME',
        'CustomerTableMap::COL_FIRSTNAME' => 'FIRSTNAME',
        'COL_FIRSTNAME' => 'FIRSTNAME',
        'FIRSTNAME' => 'FIRSTNAME',
        'customer.FIRSTNAME' => 'FIRSTNAME',
        'Lastname' => 'LASTNAME',
        'Customer.Lastname' => 'LASTNAME',
        'lastname' => 'LASTNAME',
        'customer.lastname' => 'LASTNAME',
        'CustomerTableMap::COL_LASTNAME' => 'LASTNAME',
        'COL_LASTNAME' => 'LASTNAME',
        'LASTNAME' => 'LASTNAME',
        'customer.LASTNAME' => 'LASTNAME',
        'Email' => 'EMAIL',
        'Customer.Email' => 'EMAIL',
        'email' => 'EMAIL',
        'customer.email' => 'EMAIL',
        'CustomerTableMap::COL_EMAIL' => 'EMAIL',
        'COL_EMAIL' => 'EMAIL',
        'EMAIL' => 'EMAIL',
        'customer.EMAIL' => 'EMAIL',
        'Phone' => 'PHONE',
        'Customer.Phone' => 'PHONE',
        'phone' => 'PHONE',
        'customer.phone' => 'PHONE',
        'CustomerTableMap::COL_PHONE' => 'PHONE',
        'COL_PHONE' => 'PHONE',
        'PHONE' => 'PHONE',
        'customer.PHONE' => 'PHONE',
        'Address' => 'ADDRESS',
        'Customer.Address' => 'ADDRESS',
        'address' => 'ADDRESS',
        'customer.address' => 'ADDRESS',
        'CustomerTableMap::COL_ADDRESS' => 'ADDRESS',
        'COL_ADDRESS' => 'ADDRESS',
        'ADDRESS' => 'ADDRESS',
        'customer.ADDRESS' => 'ADDRESS',
        'City' => 'CITY',
        'Customer.City' => 'CITY',
        'city' => 'CITY',
        'customer.city' => 'CITY',
        'CustomerTableMap::COL_CITY' => 'CITY',
        'COL_CITY' => 'CITY',
        'CITY' => 'CITY',
        'customer.CITY' => 'CITY',
        'Note' => 'NOTE',
        'Customer.Note' => 'NOTE',
        'note' => 'NOTE',
        'customer.note' => 'NOTE',
        'CustomerTableMap::COL_NOTE' => 'NOTE',
        'COL_NOTE' => 'NOTE',
        'NOTE' => 'NOTE',
        'customer.NOTE' => 'NOTE',
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
        $this->setName('customer');
        $this->setPhpName('Customer');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Model\\Customer');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PK_', 'Pk', 'INTEGER', true, null, null);
        $this->addColumn('FIRSTNAME', 'Firstname', 'VARCHAR', true, 100, null);
        $this->addColumn('LASTNAME', 'Lastname', 'VARCHAR', false, 100, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('PHONE', 'Phone', 'VARCHAR', false, 100, null);
        $this->addColumn('ADDRESS', 'Address', 'VARCHAR', false, 100, null);
        $this->addColumn('CITY', 'City', 'VARCHAR', false, 100, null);
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
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'validate' => ['rule1' => ['column' => 'firstname', 'validator' => 'NotNull'], 'rule2' => ['column' => 'firstname', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule3' => ['column' => 'lastname', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule4' => ['column' => 'email', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule5' => ['column' => 'phone', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule6' => ['column' => 'address', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule7' => ['column' => 'city', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule8' => ['column' => 'note', 'validator' => 'Length', 'options' => ['max' => 500]]],
        ];
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
        return $withPrefix ? CustomerTableMap::CLASS_DEFAULT : CustomerTableMap::OM_CLASS;
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
     * @return array (Customer object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = CustomerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CustomerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CustomerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CustomerTableMap::OM_CLASS;
            /** @var Customer $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CustomerTableMap::addInstanceToPool($obj, $key);
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
            $key = CustomerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CustomerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Customer $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CustomerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CustomerTableMap::COL_PK_);
            $criteria->addSelectColumn(CustomerTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(CustomerTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(CustomerTableMap::COL_EMAIL);
            $criteria->addSelectColumn(CustomerTableMap::COL_PHONE);
            $criteria->addSelectColumn(CustomerTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(CustomerTableMap::COL_CITY);
            $criteria->addSelectColumn(CustomerTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.PK_');
            $criteria->addSelectColumn($alias . '.FIRSTNAME');
            $criteria->addSelectColumn($alias . '.LASTNAME');
            $criteria->addSelectColumn($alias . '.EMAIL');
            $criteria->addSelectColumn($alias . '.PHONE');
            $criteria->addSelectColumn($alias . '.ADDRESS');
            $criteria->addSelectColumn($alias . '.CITY');
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
            $criteria->removeSelectColumn(CustomerTableMap::COL_PK_);
            $criteria->removeSelectColumn(CustomerTableMap::COL_FIRSTNAME);
            $criteria->removeSelectColumn(CustomerTableMap::COL_LASTNAME);
            $criteria->removeSelectColumn(CustomerTableMap::COL_EMAIL);
            $criteria->removeSelectColumn(CustomerTableMap::COL_PHONE);
            $criteria->removeSelectColumn(CustomerTableMap::COL_ADDRESS);
            $criteria->removeSelectColumn(CustomerTableMap::COL_CITY);
            $criteria->removeSelectColumn(CustomerTableMap::COL_NOTE);
        } else {
            $criteria->removeSelectColumn($alias . '.PK_');
            $criteria->removeSelectColumn($alias . '.FIRSTNAME');
            $criteria->removeSelectColumn($alias . '.LASTNAME');
            $criteria->removeSelectColumn($alias . '.EMAIL');
            $criteria->removeSelectColumn($alias . '.PHONE');
            $criteria->removeSelectColumn($alias . '.ADDRESS');
            $criteria->removeSelectColumn($alias . '.CITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(CustomerTableMap::DATABASE_NAME)->getTable(CustomerTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Customer or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Customer object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\Customer) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CustomerTableMap::DATABASE_NAME);
            $criteria->add(CustomerTableMap::COL_PK_, (array) $values, Criteria::IN);
        }

        $query = CustomerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CustomerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CustomerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return CustomerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Customer or Criteria object.
     *
     * @param mixed $criteria Criteria or Customer object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Customer object
        }

        if ($criteria->containsKey(CustomerTableMap::COL_PK_) && $criteria->keyContainsValue(CustomerTableMap::COL_PK_) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CustomerTableMap::COL_PK_.')');
        }


        // Set the correct dbName
        $query = CustomerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
