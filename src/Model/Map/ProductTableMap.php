<?php

namespace App\Model\Map;

use App\Model\Product;
use App\Model\ProductQuery;
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
 * This class defines the structure of the 'product' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class ProductTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.ProductTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'connection_1';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'product';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Product';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\App\\Model\\Product';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Product';

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
    public const COL_PK_ = 'product.PK_';

    /**
     * the column name for the TITLE field
     */
    public const COL_TITLE = 'product.TITLE';

    /**
     * the column name for the SUBTITLE field
     */
    public const COL_SUBTITLE = 'product.SUBTITLE';

    /**
     * the column name for the PRICE field
     */
    public const COL_PRICE = 'product.PRICE';

    /**
     * the column name for the ACTIVE field
     */
    public const COL_ACTIVE = 'product.ACTIVE';

    /**
     * the column name for the IMAGE field
     */
    public const COL_IMAGE = 'product.IMAGE';

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
        self::TYPE_PHPNAME       => ['Pk', 'Title', 'Subtitle', 'Price', 'Active', 'Image', ],
        self::TYPE_CAMELNAME     => ['pk', 'title', 'subtitle', 'price', 'active', 'image', ],
        self::TYPE_COLNAME       => [ProductTableMap::COL_PK_, ProductTableMap::COL_TITLE, ProductTableMap::COL_SUBTITLE, ProductTableMap::COL_PRICE, ProductTableMap::COL_ACTIVE, ProductTableMap::COL_IMAGE, ],
        self::TYPE_FIELDNAME     => ['PK_', 'TITLE', 'SUBTITLE', 'PRICE', 'ACTIVE', 'IMAGE', ],
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
        self::TYPE_PHPNAME       => ['Pk' => 0, 'Title' => 1, 'Subtitle' => 2, 'Price' => 3, 'Active' => 4, 'Image' => 5, ],
        self::TYPE_CAMELNAME     => ['pk' => 0, 'title' => 1, 'subtitle' => 2, 'price' => 3, 'active' => 4, 'image' => 5, ],
        self::TYPE_COLNAME       => [ProductTableMap::COL_PK_ => 0, ProductTableMap::COL_TITLE => 1, ProductTableMap::COL_SUBTITLE => 2, ProductTableMap::COL_PRICE => 3, ProductTableMap::COL_ACTIVE => 4, ProductTableMap::COL_IMAGE => 5, ],
        self::TYPE_FIELDNAME     => ['PK_' => 0, 'TITLE' => 1, 'SUBTITLE' => 2, 'PRICE' => 3, 'ACTIVE' => 4, 'IMAGE' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Pk' => 'PK_',
        'Product.Pk' => 'PK_',
        'pk' => 'PK_',
        'product.pk' => 'PK_',
        'ProductTableMap::COL_PK_' => 'PK_',
        'COL_PK_' => 'PK_',
        'PK_' => 'PK_',
        'product.PK_' => 'PK_',
        'Title' => 'TITLE',
        'Product.Title' => 'TITLE',
        'title' => 'TITLE',
        'product.title' => 'TITLE',
        'ProductTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'TITLE' => 'TITLE',
        'product.TITLE' => 'TITLE',
        'Subtitle' => 'SUBTITLE',
        'Product.Subtitle' => 'SUBTITLE',
        'subtitle' => 'SUBTITLE',
        'product.subtitle' => 'SUBTITLE',
        'ProductTableMap::COL_SUBTITLE' => 'SUBTITLE',
        'COL_SUBTITLE' => 'SUBTITLE',
        'SUBTITLE' => 'SUBTITLE',
        'product.SUBTITLE' => 'SUBTITLE',
        'Price' => 'PRICE',
        'Product.Price' => 'PRICE',
        'price' => 'PRICE',
        'product.price' => 'PRICE',
        'ProductTableMap::COL_PRICE' => 'PRICE',
        'COL_PRICE' => 'PRICE',
        'PRICE' => 'PRICE',
        'product.PRICE' => 'PRICE',
        'Active' => 'ACTIVE',
        'Product.Active' => 'ACTIVE',
        'active' => 'ACTIVE',
        'product.active' => 'ACTIVE',
        'ProductTableMap::COL_ACTIVE' => 'ACTIVE',
        'COL_ACTIVE' => 'ACTIVE',
        'ACTIVE' => 'ACTIVE',
        'product.ACTIVE' => 'ACTIVE',
        'Image' => 'IMAGE',
        'Product.Image' => 'IMAGE',
        'image' => 'IMAGE',
        'product.image' => 'IMAGE',
        'ProductTableMap::COL_IMAGE' => 'IMAGE',
        'COL_IMAGE' => 'IMAGE',
        'IMAGE' => 'IMAGE',
        'product.IMAGE' => 'IMAGE',
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
        $this->setName('product');
        $this->setPhpName('Product');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Model\\Product');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PK_', 'Pk', 'INTEGER', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 100, null);
        $this->addColumn('SUBTITLE', 'Subtitle', 'VARCHAR', false, 50, null);
        $this->addColumn('PRICE', 'Price', 'DOUBLE', true, null, null);
        $this->addColumn('ACTIVE', 'Active', 'TINYINT', false, null, 1);
        $this->addColumn('IMAGE', 'Image', 'LONGVARBINARY', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('OrderItem', '\\App\\Model\\OrderItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':PRODUCT_PK_',
    1 => ':PK_',
  ),
), null, null, 'OrderItems', false);
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
            'validate' => ['rule1' => ['column' => 'title', 'validator' => 'NotNull'], 'rule2' => ['column' => 'title', 'validator' => 'Length', 'options' => ['max' => 100]], 'rule3' => ['column' => 'price', 'validator' => 'NotNull'], 'rule4' => ['column' => 'price', 'validator' => 'GreaterThan', 'options' => ['value' => 0]], 'rule5' => ['column' => 'subtitle', 'validator' => 'Length', 'options' => ['max' => 50]]],
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
        return $withPrefix ? ProductTableMap::CLASS_DEFAULT : ProductTableMap::OM_CLASS;
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
     * @return array (Product object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = ProductTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProductTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductTableMap::OM_CLASS;
            /** @var Product $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProductTableMap::addInstanceToPool($obj, $key);
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
            $key = ProductTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Product $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProductTableMap::COL_PK_);
            $criteria->addSelectColumn(ProductTableMap::COL_TITLE);
            $criteria->addSelectColumn(ProductTableMap::COL_SUBTITLE);
            $criteria->addSelectColumn(ProductTableMap::COL_PRICE);
            $criteria->addSelectColumn(ProductTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(ProductTableMap::COL_IMAGE);
        } else {
            $criteria->addSelectColumn($alias . '.PK_');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.SUBTITLE');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.ACTIVE');
            $criteria->addSelectColumn($alias . '.IMAGE');
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
            $criteria->removeSelectColumn(ProductTableMap::COL_PK_);
            $criteria->removeSelectColumn(ProductTableMap::COL_TITLE);
            $criteria->removeSelectColumn(ProductTableMap::COL_SUBTITLE);
            $criteria->removeSelectColumn(ProductTableMap::COL_PRICE);
            $criteria->removeSelectColumn(ProductTableMap::COL_ACTIVE);
            $criteria->removeSelectColumn(ProductTableMap::COL_IMAGE);
        } else {
            $criteria->removeSelectColumn($alias . '.PK_');
            $criteria->removeSelectColumn($alias . '.TITLE');
            $criteria->removeSelectColumn($alias . '.SUBTITLE');
            $criteria->removeSelectColumn($alias . '.PRICE');
            $criteria->removeSelectColumn($alias . '.ACTIVE');
            $criteria->removeSelectColumn($alias . '.IMAGE');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProductTableMap::DATABASE_NAME)->getTable(ProductTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Product or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Product object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\Product) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductTableMap::DATABASE_NAME);
            $criteria->add(ProductTableMap::COL_PK_, (array) $values, Criteria::IN);
        }

        $query = ProductQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ProductTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ProductTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return ProductQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Product or Criteria object.
     *
     * @param mixed $criteria Criteria or Product object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Product object
        }

        if ($criteria->containsKey(ProductTableMap::COL_PK_) && $criteria->keyContainsValue(ProductTableMap::COL_PK_) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProductTableMap::COL_PK_.')');
        }


        // Set the correct dbName
        $query = ProductQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
