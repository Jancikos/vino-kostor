<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\Order as ChildOrder;
use App\Model\OrderQuery as ChildOrderQuery;
use App\Model\Map\OrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `myorder` table.
 *
 * @method     ChildOrderQuery orderByPk($order = Criteria::ASC) Order by the PK_ column
 * @method     ChildOrderQuery orderByCustomerPk($order = Criteria::ASC) Order by the CUSTOMER_PK_ column
 * @method     ChildOrderQuery orderByUserPk($order = Criteria::ASC) Order by the USER_PK_ column
 * @method     ChildOrderQuery orderByStatus($order = Criteria::ASC) Order by the STATUS column
 * @method     ChildOrderQuery orderByCreated($order = Criteria::ASC) Order by the CREATED column
 * @method     ChildOrderQuery orderByPacked($order = Criteria::ASC) Order by the PACKED column
 * @method     ChildOrderQuery orderByShipped($order = Criteria::ASC) Order by the SHIPPED column
 * @method     ChildOrderQuery orderByPaied($order = Criteria::ASC) Order by the PAIED column
 * @method     ChildOrderQuery orderByRealPrice($order = Criteria::ASC) Order by the REAL_PRICE column
 * @method     ChildOrderQuery orderByNote($order = Criteria::ASC) Order by the NOTE column
 *
 * @method     ChildOrderQuery groupByPk() Group by the PK_ column
 * @method     ChildOrderQuery groupByCustomerPk() Group by the CUSTOMER_PK_ column
 * @method     ChildOrderQuery groupByUserPk() Group by the USER_PK_ column
 * @method     ChildOrderQuery groupByStatus() Group by the STATUS column
 * @method     ChildOrderQuery groupByCreated() Group by the CREATED column
 * @method     ChildOrderQuery groupByPacked() Group by the PACKED column
 * @method     ChildOrderQuery groupByShipped() Group by the SHIPPED column
 * @method     ChildOrderQuery groupByPaied() Group by the PAIED column
 * @method     ChildOrderQuery groupByRealPrice() Group by the REAL_PRICE column
 * @method     ChildOrderQuery groupByNote() Group by the NOTE column
 *
 * @method     ChildOrderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrderQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrderQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrder|null findOne(?ConnectionInterface $con = null) Return the first ChildOrder matching the query
 * @method     ChildOrder findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildOrder matching the query, or a new ChildOrder object populated from the query conditions when no match is found
 *
 * @method     ChildOrder|null findOneByPk(int $PK_) Return the first ChildOrder filtered by the PK_ column
 * @method     ChildOrder|null findOneByCustomerPk(int $CUSTOMER_PK_) Return the first ChildOrder filtered by the CUSTOMER_PK_ column
 * @method     ChildOrder|null findOneByUserPk(int $USER_PK_) Return the first ChildOrder filtered by the USER_PK_ column
 * @method     ChildOrder|null findOneByStatus(int $STATUS) Return the first ChildOrder filtered by the STATUS column
 * @method     ChildOrder|null findOneByCreated(string $CREATED) Return the first ChildOrder filtered by the CREATED column
 * @method     ChildOrder|null findOneByPacked(string $PACKED) Return the first ChildOrder filtered by the PACKED column
 * @method     ChildOrder|null findOneByShipped(string $SHIPPED) Return the first ChildOrder filtered by the SHIPPED column
 * @method     ChildOrder|null findOneByPaied(string $PAIED) Return the first ChildOrder filtered by the PAIED column
 * @method     ChildOrder|null findOneByRealPrice(double $REAL_PRICE) Return the first ChildOrder filtered by the REAL_PRICE column
 * @method     ChildOrder|null findOneByNote(string $NOTE) Return the first ChildOrder filtered by the NOTE column
 *
 * @method     ChildOrder requirePk($key, ?ConnectionInterface $con = null) Return the ChildOrder by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOne(?ConnectionInterface $con = null) Return the first ChildOrder matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrder requireOneByPk(int $PK_) Return the first ChildOrder filtered by the PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByCustomerPk(int $CUSTOMER_PK_) Return the first ChildOrder filtered by the CUSTOMER_PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByUserPk(int $USER_PK_) Return the first ChildOrder filtered by the USER_PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByStatus(int $STATUS) Return the first ChildOrder filtered by the STATUS column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByCreated(string $CREATED) Return the first ChildOrder filtered by the CREATED column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByPacked(string $PACKED) Return the first ChildOrder filtered by the PACKED column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByShipped(string $SHIPPED) Return the first ChildOrder filtered by the SHIPPED column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByPaied(string $PAIED) Return the first ChildOrder filtered by the PAIED column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByRealPrice(double $REAL_PRICE) Return the first ChildOrder filtered by the REAL_PRICE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrder requireOneByNote(string $NOTE) Return the first ChildOrder filtered by the NOTE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrder[]|Collection find(?ConnectionInterface $con = null) Return ChildOrder objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildOrder> find(?ConnectionInterface $con = null) Return ChildOrder objects based on current ModelCriteria
 *
 * @method     ChildOrder[]|Collection findByPk(int|array<int> $PK_) Return ChildOrder objects filtered by the PK_ column
 * @psalm-method Collection&\Traversable<ChildOrder> findByPk(int|array<int> $PK_) Return ChildOrder objects filtered by the PK_ column
 * @method     ChildOrder[]|Collection findByCustomerPk(int|array<int> $CUSTOMER_PK_) Return ChildOrder objects filtered by the CUSTOMER_PK_ column
 * @psalm-method Collection&\Traversable<ChildOrder> findByCustomerPk(int|array<int> $CUSTOMER_PK_) Return ChildOrder objects filtered by the CUSTOMER_PK_ column
 * @method     ChildOrder[]|Collection findByUserPk(int|array<int> $USER_PK_) Return ChildOrder objects filtered by the USER_PK_ column
 * @psalm-method Collection&\Traversable<ChildOrder> findByUserPk(int|array<int> $USER_PK_) Return ChildOrder objects filtered by the USER_PK_ column
 * @method     ChildOrder[]|Collection findByStatus(int|array<int> $STATUS) Return ChildOrder objects filtered by the STATUS column
 * @psalm-method Collection&\Traversable<ChildOrder> findByStatus(int|array<int> $STATUS) Return ChildOrder objects filtered by the STATUS column
 * @method     ChildOrder[]|Collection findByCreated(string|array<string> $CREATED) Return ChildOrder objects filtered by the CREATED column
 * @psalm-method Collection&\Traversable<ChildOrder> findByCreated(string|array<string> $CREATED) Return ChildOrder objects filtered by the CREATED column
 * @method     ChildOrder[]|Collection findByPacked(string|array<string> $PACKED) Return ChildOrder objects filtered by the PACKED column
 * @psalm-method Collection&\Traversable<ChildOrder> findByPacked(string|array<string> $PACKED) Return ChildOrder objects filtered by the PACKED column
 * @method     ChildOrder[]|Collection findByShipped(string|array<string> $SHIPPED) Return ChildOrder objects filtered by the SHIPPED column
 * @psalm-method Collection&\Traversable<ChildOrder> findByShipped(string|array<string> $SHIPPED) Return ChildOrder objects filtered by the SHIPPED column
 * @method     ChildOrder[]|Collection findByPaied(string|array<string> $PAIED) Return ChildOrder objects filtered by the PAIED column
 * @psalm-method Collection&\Traversable<ChildOrder> findByPaied(string|array<string> $PAIED) Return ChildOrder objects filtered by the PAIED column
 * @method     ChildOrder[]|Collection findByRealPrice(double|array<double> $REAL_PRICE) Return ChildOrder objects filtered by the REAL_PRICE column
 * @psalm-method Collection&\Traversable<ChildOrder> findByRealPrice(double|array<double> $REAL_PRICE) Return ChildOrder objects filtered by the REAL_PRICE column
 * @method     ChildOrder[]|Collection findByNote(string|array<string> $NOTE) Return ChildOrder objects filtered by the NOTE column
 * @psalm-method Collection&\Traversable<ChildOrder> findByNote(string|array<string> $NOTE) Return ChildOrder objects filtered by the NOTE column
 *
 * @method     ChildOrder[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildOrder> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class OrderQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Model\Base\OrderQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'connection_1', $modelName = '\\App\\Model\\Order', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildOrderQuery) {
            return $criteria;
        }
        $query = new ChildOrderQuery();
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
     * @return ChildOrder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrderTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOrder A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT PK_, CUSTOMER_PK_, USER_PK_, STATUS, CREATED, PACKED, SHIPPED, PAIED, REAL_PRICE, NOTE FROM myorder WHERE PK_ = :p0';
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
            /** @var ChildOrder $obj */
            $obj = new ChildOrder();
            $obj->hydrate($row);
            OrderTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOrder|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(OrderTableMap::COL_PK_, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(OrderTableMap::COL_PK_, $keys, Criteria::IN);

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
                $this->addUsingAlias(OrderTableMap::COL_PK_, $pk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pk['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_PK_, $pk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_PK_, $pk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the CUSTOMER_PK_ column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerPk(1234); // WHERE CUSTOMER_PK_ = 1234
     * $query->filterByCustomerPk(array(12, 34)); // WHERE CUSTOMER_PK_ IN (12, 34)
     * $query->filterByCustomerPk(array('min' => 12)); // WHERE CUSTOMER_PK_ > 12
     * </code>
     *
     * @param mixed $customerPk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCustomerPk($customerPk = null, ?string $comparison = null)
    {
        if (is_array($customerPk)) {
            $useMinMax = false;
            if (isset($customerPk['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_CUSTOMER_PK_, $customerPk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerPk['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_CUSTOMER_PK_, $customerPk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_CUSTOMER_PK_, $customerPk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the USER_PK_ column
     *
     * Example usage:
     * <code>
     * $query->filterByUserPk(1234); // WHERE USER_PK_ = 1234
     * $query->filterByUserPk(array(12, 34)); // WHERE USER_PK_ IN (12, 34)
     * $query->filterByUserPk(array('min' => 12)); // WHERE USER_PK_ > 12
     * </code>
     *
     * @param mixed $userPk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUserPk($userPk = null, ?string $comparison = null)
    {
        if (is_array($userPk)) {
            $useMinMax = false;
            if (isset($userPk['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_USER_PK_, $userPk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userPk['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_USER_PK_, $userPk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_USER_PK_, $userPk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the STATUS column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE STATUS = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE STATUS IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE STATUS > 12
     * </code>
     *
     * @param mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStatus($status = null, ?string $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_STATUS, $status, $comparison);

        return $this;
    }

    /**
     * Filter the query on the CREATED column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated('2011-03-14'); // WHERE CREATED = '2011-03-14'
     * $query->filterByCreated('now'); // WHERE CREATED = '2011-03-14'
     * $query->filterByCreated(array('max' => 'yesterday')); // WHERE CREATED > '2011-03-13'
     * </code>
     *
     * @param mixed $created The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreated($created = null, ?string $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_CREATED, $created, $comparison);

        return $this;
    }

    /**
     * Filter the query on the PACKED column
     *
     * Example usage:
     * <code>
     * $query->filterByPacked('2011-03-14'); // WHERE PACKED = '2011-03-14'
     * $query->filterByPacked('now'); // WHERE PACKED = '2011-03-14'
     * $query->filterByPacked(array('max' => 'yesterday')); // WHERE PACKED > '2011-03-13'
     * </code>
     *
     * @param mixed $packed The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPacked($packed = null, ?string $comparison = null)
    {
        if (is_array($packed)) {
            $useMinMax = false;
            if (isset($packed['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_PACKED, $packed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packed['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_PACKED, $packed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_PACKED, $packed, $comparison);

        return $this;
    }

    /**
     * Filter the query on the SHIPPED column
     *
     * Example usage:
     * <code>
     * $query->filterByShipped('2011-03-14'); // WHERE SHIPPED = '2011-03-14'
     * $query->filterByShipped('now'); // WHERE SHIPPED = '2011-03-14'
     * $query->filterByShipped(array('max' => 'yesterday')); // WHERE SHIPPED > '2011-03-13'
     * </code>
     *
     * @param mixed $shipped The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByShipped($shipped = null, ?string $comparison = null)
    {
        if (is_array($shipped)) {
            $useMinMax = false;
            if (isset($shipped['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_SHIPPED, $shipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shipped['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_SHIPPED, $shipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_SHIPPED, $shipped, $comparison);

        return $this;
    }

    /**
     * Filter the query on the PAIED column
     *
     * Example usage:
     * <code>
     * $query->filterByPaied('2011-03-14'); // WHERE PAIED = '2011-03-14'
     * $query->filterByPaied('now'); // WHERE PAIED = '2011-03-14'
     * $query->filterByPaied(array('max' => 'yesterday')); // WHERE PAIED > '2011-03-13'
     * </code>
     *
     * @param mixed $paied The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPaied($paied = null, ?string $comparison = null)
    {
        if (is_array($paied)) {
            $useMinMax = false;
            if (isset($paied['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_PAIED, $paied['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paied['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_PAIED, $paied['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_PAIED, $paied, $comparison);

        return $this;
    }

    /**
     * Filter the query on the REAL_PRICE column
     *
     * Example usage:
     * <code>
     * $query->filterByRealPrice(1234); // WHERE REAL_PRICE = 1234
     * $query->filterByRealPrice(array(12, 34)); // WHERE REAL_PRICE IN (12, 34)
     * $query->filterByRealPrice(array('min' => 12)); // WHERE REAL_PRICE > 12
     * </code>
     *
     * @param mixed $realPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByRealPrice($realPrice = null, ?string $comparison = null)
    {
        if (is_array($realPrice)) {
            $useMinMax = false;
            if (isset($realPrice['min'])) {
                $this->addUsingAlias(OrderTableMap::COL_REAL_PRICE, $realPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($realPrice['max'])) {
                $this->addUsingAlias(OrderTableMap::COL_REAL_PRICE, $realPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(OrderTableMap::COL_REAL_PRICE, $realPrice, $comparison);

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

        $this->addUsingAlias(OrderTableMap::COL_NOTE, $note, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildOrder $order Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($order = null)
    {
        if ($order) {
            $this->addUsingAlias(OrderTableMap::COL_PK_, $order->getPk(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the myorder table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderTableMap::clearInstancePool();
            OrderTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrderTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
