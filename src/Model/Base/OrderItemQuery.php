<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\OrderItem as ChildOrderItem;
use App\Model\OrderItemQuery as ChildOrderItemQuery;
use App\Model\Map\OrderItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `myorder_item` table.
 *
 * @method     ChildOrderItemQuery orderByPk($order = Criteria::ASC) Order by the PK_ column
 * @method     ChildOrderItemQuery orderByOrderPk($order = Criteria::ASC) Order by the ORDER_PK_ column
 * @method     ChildOrderItemQuery orderByProductPk($order = Criteria::ASC) Order by the PRODUCT_PK_ column
 * @method     ChildOrderItemQuery orderByQuantity($order = Criteria::ASC) Order by the QUANTITY column
 * @method     ChildOrderItemQuery orderByPrice($order = Criteria::ASC) Order by the PRICE column
 * @method     ChildOrderItemQuery orderByNote($order = Criteria::ASC) Order by the NOTE column
 *
 * @method     ChildOrderItemQuery groupByPk() Group by the PK_ column
 * @method     ChildOrderItemQuery groupByOrderPk() Group by the ORDER_PK_ column
 * @method     ChildOrderItemQuery groupByProductPk() Group by the PRODUCT_PK_ column
 * @method     ChildOrderItemQuery groupByQuantity() Group by the QUANTITY column
 * @method     ChildOrderItemQuery groupByPrice() Group by the PRICE column
 * @method     ChildOrderItemQuery groupByNote() Group by the NOTE column
 *
 * @method     ChildOrderItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrderItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrderItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrderItemQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildOrderItemQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildOrderItemQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildOrderItemQuery joinWithOrder($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Order relation
 *
 * @method     ChildOrderItemQuery leftJoinWithOrder() Adds a LEFT JOIN clause and with to the query using the Order relation
 * @method     ChildOrderItemQuery rightJoinWithOrder() Adds a RIGHT JOIN clause and with to the query using the Order relation
 * @method     ChildOrderItemQuery innerJoinWithOrder() Adds a INNER JOIN clause and with to the query using the Order relation
 *
 * @method     ChildOrderItemQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildOrderItemQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildOrderItemQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildOrderItemQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildOrderItemQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildOrderItemQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildOrderItemQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     \App\Model\OrderQuery|\App\Model\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrderItem|null findOne(?ConnectionInterface $con = null) Return the first ChildOrderItem matching the query
 * @method     ChildOrderItem findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildOrderItem matching the query, or a new ChildOrderItem object populated from the query conditions when no match is found
 *
 * @method     ChildOrderItem|null findOneByPk(int $PK_) Return the first ChildOrderItem filtered by the PK_ column
 * @method     ChildOrderItem|null findOneByOrderPk(int $ORDER_PK_) Return the first ChildOrderItem filtered by the ORDER_PK_ column
 * @method     ChildOrderItem|null findOneByProductPk(int $PRODUCT_PK_) Return the first ChildOrderItem filtered by the PRODUCT_PK_ column
 * @method     ChildOrderItem|null findOneByQuantity(int $QUANTITY) Return the first ChildOrderItem filtered by the QUANTITY column
 * @method     ChildOrderItem|null findOneByPrice(double $PRICE) Return the first ChildOrderItem filtered by the PRICE column
 * @method     ChildOrderItem|null findOneByNote(string $NOTE) Return the first ChildOrderItem filtered by the NOTE column
 *
 * @method     ChildOrderItem requirePk($key, ?ConnectionInterface $con = null) Return the ChildOrderItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOne(?ConnectionInterface $con = null) Return the first ChildOrderItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrderItem requireOneByPk(int $PK_) Return the first ChildOrderItem filtered by the PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOneByOrderPk(int $ORDER_PK_) Return the first ChildOrderItem filtered by the ORDER_PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOneByProductPk(int $PRODUCT_PK_) Return the first ChildOrderItem filtered by the PRODUCT_PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOneByQuantity(int $QUANTITY) Return the first ChildOrderItem filtered by the QUANTITY column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOneByPrice(double $PRICE) Return the first ChildOrderItem filtered by the PRICE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrderItem requireOneByNote(string $NOTE) Return the first ChildOrderItem filtered by the NOTE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrderItem[]|Collection find(?ConnectionInterface $con = null) Return ChildOrderItem objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildOrderItem> find(?ConnectionInterface $con = null) Return ChildOrderItem objects based on current ModelCriteria
 *
 * @method     ChildOrderItem[]|Collection findByPk(int|array<int> $PK_) Return ChildOrderItem objects filtered by the PK_ column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByPk(int|array<int> $PK_) Return ChildOrderItem objects filtered by the PK_ column
 * @method     ChildOrderItem[]|Collection findByOrderPk(int|array<int> $ORDER_PK_) Return ChildOrderItem objects filtered by the ORDER_PK_ column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByOrderPk(int|array<int> $ORDER_PK_) Return ChildOrderItem objects filtered by the ORDER_PK_ column
 * @method     ChildOrderItem[]|Collection findByProductPk(int|array<int> $PRODUCT_PK_) Return ChildOrderItem objects filtered by the PRODUCT_PK_ column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByProductPk(int|array<int> $PRODUCT_PK_) Return ChildOrderItem objects filtered by the PRODUCT_PK_ column
 * @method     ChildOrderItem[]|Collection findByQuantity(int|array<int> $QUANTITY) Return ChildOrderItem objects filtered by the QUANTITY column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByQuantity(int|array<int> $QUANTITY) Return ChildOrderItem objects filtered by the QUANTITY column
 * @method     ChildOrderItem[]|Collection findByPrice(double|array<double> $PRICE) Return ChildOrderItem objects filtered by the PRICE column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByPrice(double|array<double> $PRICE) Return ChildOrderItem objects filtered by the PRICE column
 * @method     ChildOrderItem[]|Collection findByNote(string|array<string> $NOTE) Return ChildOrderItem objects filtered by the NOTE column
 * @psalm-method Collection&\Traversable<ChildOrderItem> findByNote(string|array<string> $NOTE) Return ChildOrderItem objects filtered by the NOTE column
 *
 * @method     ChildOrderItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildOrderItem> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class OrderItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Model\Base\OrderItemQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'connection_1', $modelName = '\\App\\Model\\OrderItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderItemQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderItemQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildOrderItemQuery) {
            return $criteria;
        }
        $query = new ChildOrderItemQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrderItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrderItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrderItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT PK_, ORDER_PK_, PRODUCT_PK_, QUANTITY, PRICE, NOTE FROM myorder_item WHERE PK_ = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildOrderItem $obj */
            $obj = new ChildOrderItem();
            $obj->hydrate($row);
            OrderItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildOrderItem|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(OrderItemTableMap::COL_PK_, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(OrderItemTableMap::COL_PK_, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the PK_ column
     *
     * Example usage:
     * <code>
     * $query->filterByPk(1234); // WHERE PK_ = 1234
     * $query->filterByPk(array(12, 34)); // WHERE PK_ IN (12, 34)
     * $query->filterByPk(array('min' => 12)); // WHERE PK_ > 12
     * </code>
     *
     * @param mixed $pk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPk($pk = null, ?string $comparison = null)
    {
        if (is_array($pk)) {
            $useMinMax = false;
            if (isset($pk['min'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PK_, $pk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pk['max'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PK_, $pk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_PK_, $pk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ORDER_PK_ column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderPk(1234); // WHERE ORDER_PK_ = 1234
     * $query->filterByOrderPk(array(12, 34)); // WHERE ORDER_PK_ IN (12, 34)
     * $query->filterByOrderPk(array('min' => 12)); // WHERE ORDER_PK_ > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param mixed $orderPk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderPk($orderPk = null, ?string $comparison = null)
    {
        if (is_array($orderPk)) {
            $useMinMax = false;
            if (isset($orderPk['min'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_ORDER_PK_, $orderPk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderPk['max'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_ORDER_PK_, $orderPk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_ORDER_PK_, $orderPk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the PRODUCT_PK_ column
     *
     * Example usage:
     * <code>
     * $query->filterByProductPk(1234); // WHERE PRODUCT_PK_ = 1234
     * $query->filterByProductPk(array(12, 34)); // WHERE PRODUCT_PK_ IN (12, 34)
     * $query->filterByProductPk(array('min' => 12)); // WHERE PRODUCT_PK_ > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param mixed $productPk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProductPk($productPk = null, ?string $comparison = null)
    {
        if (is_array($productPk)) {
            $useMinMax = false;
            if (isset($productPk['min'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PRODUCT_PK_, $productPk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productPk['max'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PRODUCT_PK_, $productPk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_PRODUCT_PK_, $productPk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the QUANTITY column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE QUANTITY = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE QUANTITY IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE QUANTITY > 12
     * </code>
     *
     * @param mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, ?string $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_QUANTITY, $quantity, $comparison);

        return $this;
    }

    /**
     * Filter the query on the PRICE column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE PRICE = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE PRICE IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE PRICE > 12
     * </code>
     *
     * @param mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrice($price = null, ?string $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(OrderItemTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_PRICE, $price, $comparison);

        return $this;
    }

    /**
     * Filter the query on the NOTE column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE NOTE = 'fooValue'
     * $query->filterByNote('%fooValue%', Criteria::LIKE); // WHERE NOTE LIKE '%fooValue%'
     * $query->filterByNote(['foo', 'bar']); // WHERE NOTE IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $note The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByNote($note = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderItemTableMap::COL_NOTE, $note, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \App\Model\Order object
     *
     * @param \App\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrder($order, ?string $comparison = null)
    {
        if ($order instanceof \App\Model\Order) {
            return $this
                ->addUsingAlias(OrderItemTableMap::COL_ORDER_PK_, $order->getPk(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderItemTableMap::COL_ORDER_PK_, $order->toKeyValue('PrimaryKey', 'Pk'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \App\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinOrder(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\App\Model\OrderQuery');
    }

    /**
     * Use the Order relation Order object
     *
     * @param callable(\App\Model\OrderQuery):\App\Model\OrderQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withOrderQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useOrderQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Order table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Model\OrderQuery The inner query object of the EXISTS statement
     */
    public function useOrderExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \App\Model\OrderQuery */
        $q = $this->useExistsQuery('Order', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Order table for a NOT EXISTS query.
     *
     * @see useOrderExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Model\OrderQuery The inner query object of the NOT EXISTS statement
     */
    public function useOrderNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Model\OrderQuery */
        $q = $this->useExistsQuery('Order', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Order table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \App\Model\OrderQuery The inner query object of the IN statement
     */
    public function useInOrderQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \App\Model\OrderQuery */
        $q = $this->useInQuery('Order', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Order table for a NOT IN query.
     *
     * @see useOrderInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \App\Model\OrderQuery The inner query object of the NOT IN statement
     */
    public function useNotInOrderQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Model\OrderQuery */
        $q = $this->useInQuery('Order', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \App\Model\Product object
     *
     * @param \App\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByProduct($product, ?string $comparison = null)
    {
        if ($product instanceof \App\Model\Product) {
            return $this
                ->addUsingAlias(OrderItemTableMap::COL_PRODUCT_PK_, $product->getPk(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(OrderItemTableMap::COL_PRODUCT_PK_, $product->toKeyValue('PrimaryKey', 'Pk'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \App\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinProduct(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\App\Model\ProductQuery');
    }

    /**
     * Use the Product relation Product object
     *
     * @param callable(\App\Model\ProductQuery):\App\Model\ProductQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withProductQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useProductQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Product table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \App\Model\ProductQuery The inner query object of the EXISTS statement
     */
    public function useProductExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \App\Model\ProductQuery */
        $q = $this->useExistsQuery('Product', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Product table for a NOT EXISTS query.
     *
     * @see useProductExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \App\Model\ProductQuery The inner query object of the NOT EXISTS statement
     */
    public function useProductNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Model\ProductQuery */
        $q = $this->useExistsQuery('Product', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Product table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \App\Model\ProductQuery The inner query object of the IN statement
     */
    public function useInProductQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \App\Model\ProductQuery */
        $q = $this->useInQuery('Product', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Product table for a NOT IN query.
     *
     * @see useProductInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \App\Model\ProductQuery The inner query object of the NOT IN statement
     */
    public function useNotInProductQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \App\Model\ProductQuery */
        $q = $this->useInQuery('Product', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildOrderItem $orderItem Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($orderItem = null)
    {
        if ($orderItem) {
            $this->addUsingAlias(OrderItemTableMap::COL_PK_, $orderItem->getPk(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the myorder_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderItemTableMap::clearInstancePool();
            OrderItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrderItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
