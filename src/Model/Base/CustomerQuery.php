<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\Customer as ChildCustomer;
use App\Model\CustomerQuery as ChildCustomerQuery;
use App\Model\Map\CustomerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `customer` table.
 *
 * @method     ChildCustomerQuery orderByPk($order = Criteria::ASC) Order by the PK_ column
 * @method     ChildCustomerQuery orderByFirstname($order = Criteria::ASC) Order by the FIRSTNAME column
 * @method     ChildCustomerQuery orderByLastname($order = Criteria::ASC) Order by the LASTNAME column
 * @method     ChildCustomerQuery orderByEmail($order = Criteria::ASC) Order by the EMAIL column
 * @method     ChildCustomerQuery orderByPhone($order = Criteria::ASC) Order by the PHONE column
 * @method     ChildCustomerQuery orderByAddress($order = Criteria::ASC) Order by the ADDRESS column
 * @method     ChildCustomerQuery orderByCity($order = Criteria::ASC) Order by the CITY column
 * @method     ChildCustomerQuery orderByNote($order = Criteria::ASC) Order by the NOTE column
 *
 * @method     ChildCustomerQuery groupByPk() Group by the PK_ column
 * @method     ChildCustomerQuery groupByFirstname() Group by the FIRSTNAME column
 * @method     ChildCustomerQuery groupByLastname() Group by the LASTNAME column
 * @method     ChildCustomerQuery groupByEmail() Group by the EMAIL column
 * @method     ChildCustomerQuery groupByPhone() Group by the PHONE column
 * @method     ChildCustomerQuery groupByAddress() Group by the ADDRESS column
 * @method     ChildCustomerQuery groupByCity() Group by the CITY column
 * @method     ChildCustomerQuery groupByNote() Group by the NOTE column
 *
 * @method     ChildCustomerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCustomerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCustomerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCustomerQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildCustomerQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildCustomerQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildCustomerQuery joinWithOrder($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Order relation
 *
 * @method     ChildCustomerQuery leftJoinWithOrder() Adds a LEFT JOIN clause and with to the query using the Order relation
 * @method     ChildCustomerQuery rightJoinWithOrder() Adds a RIGHT JOIN clause and with to the query using the Order relation
 * @method     ChildCustomerQuery innerJoinWithOrder() Adds a INNER JOIN clause and with to the query using the Order relation
 *
 * @method     \App\Model\OrderQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCustomer|null findOne(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query
 * @method     ChildCustomer findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query, or a new ChildCustomer object populated from the query conditions when no match is found
 *
 * @method     ChildCustomer|null findOneByPk(int $PK_) Return the first ChildCustomer filtered by the PK_ column
 * @method     ChildCustomer|null findOneByFirstname(string $FIRSTNAME) Return the first ChildCustomer filtered by the FIRSTNAME column
 * @method     ChildCustomer|null findOneByLastname(string $LASTNAME) Return the first ChildCustomer filtered by the LASTNAME column
 * @method     ChildCustomer|null findOneByEmail(string $EMAIL) Return the first ChildCustomer filtered by the EMAIL column
 * @method     ChildCustomer|null findOneByPhone(string $PHONE) Return the first ChildCustomer filtered by the PHONE column
 * @method     ChildCustomer|null findOneByAddress(string $ADDRESS) Return the first ChildCustomer filtered by the ADDRESS column
 * @method     ChildCustomer|null findOneByCity(string $CITY) Return the first ChildCustomer filtered by the CITY column
 * @method     ChildCustomer|null findOneByNote(string $NOTE) Return the first ChildCustomer filtered by the NOTE column
 *
 * @method     ChildCustomer requirePk($key, ?ConnectionInterface $con = null) Return the ChildCustomer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOne(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer requireOneByPk(int $PK_) Return the first ChildCustomer filtered by the PK_ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByFirstname(string $FIRSTNAME) Return the first ChildCustomer filtered by the FIRSTNAME column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastname(string $LASTNAME) Return the first ChildCustomer filtered by the LASTNAME column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByEmail(string $EMAIL) Return the first ChildCustomer filtered by the EMAIL column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByPhone(string $PHONE) Return the first ChildCustomer filtered by the PHONE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByAddress(string $ADDRESS) Return the first ChildCustomer filtered by the ADDRESS column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByCity(string $CITY) Return the first ChildCustomer filtered by the CITY column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByNote(string $NOTE) Return the first ChildCustomer filtered by the NOTE column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer[]|Collection find(?ConnectionInterface $con = null) Return ChildCustomer objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildCustomer> find(?ConnectionInterface $con = null) Return ChildCustomer objects based on current ModelCriteria
 *
 * @method     ChildCustomer[]|Collection findByPk(int|array<int> $PK_) Return ChildCustomer objects filtered by the PK_ column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByPk(int|array<int> $PK_) Return ChildCustomer objects filtered by the PK_ column
 * @method     ChildCustomer[]|Collection findByFirstname(string|array<string> $FIRSTNAME) Return ChildCustomer objects filtered by the FIRSTNAME column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByFirstname(string|array<string> $FIRSTNAME) Return ChildCustomer objects filtered by the FIRSTNAME column
 * @method     ChildCustomer[]|Collection findByLastname(string|array<string> $LASTNAME) Return ChildCustomer objects filtered by the LASTNAME column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByLastname(string|array<string> $LASTNAME) Return ChildCustomer objects filtered by the LASTNAME column
 * @method     ChildCustomer[]|Collection findByEmail(string|array<string> $EMAIL) Return ChildCustomer objects filtered by the EMAIL column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByEmail(string|array<string> $EMAIL) Return ChildCustomer objects filtered by the EMAIL column
 * @method     ChildCustomer[]|Collection findByPhone(string|array<string> $PHONE) Return ChildCustomer objects filtered by the PHONE column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByPhone(string|array<string> $PHONE) Return ChildCustomer objects filtered by the PHONE column
 * @method     ChildCustomer[]|Collection findByAddress(string|array<string> $ADDRESS) Return ChildCustomer objects filtered by the ADDRESS column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByAddress(string|array<string> $ADDRESS) Return ChildCustomer objects filtered by the ADDRESS column
 * @method     ChildCustomer[]|Collection findByCity(string|array<string> $CITY) Return ChildCustomer objects filtered by the CITY column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByCity(string|array<string> $CITY) Return ChildCustomer objects filtered by the CITY column
 * @method     ChildCustomer[]|Collection findByNote(string|array<string> $NOTE) Return ChildCustomer objects filtered by the NOTE column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByNote(string|array<string> $NOTE) Return ChildCustomer objects filtered by the NOTE column
 *
 * @method     ChildCustomer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildCustomer> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class CustomerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Model\Base\CustomerQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'connection_1', $modelName = '\\App\\Model\\Customer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomerQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomerQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCustomerQuery) {
            return $criteria;
        }
        $query = new ChildCustomerQuery();
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CustomerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCustomer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT PK_, FIRSTNAME, LASTNAME, EMAIL, PHONE, ADDRESS, CITY, NOTE FROM customer WHERE PK_ = :p0';
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
            /** @var ChildCustomer $obj */
            $obj = new ChildCustomer();
            $obj->hydrate($row);
            CustomerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(CustomerTableMap::COL_PK_, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(CustomerTableMap::COL_PK_, $keys, Criteria::IN);

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
                $this->addUsingAlias(CustomerTableMap::COL_PK_, $pk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pk['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_PK_, $pk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_PK_, $pk, $comparison);

        return $this;
    }

    /**
     * Filter the query on the FIRSTNAME column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE FIRSTNAME = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE FIRSTNAME LIKE '%fooValue%'
     * $query->filterByFirstname(['foo', 'bar']); // WHERE FIRSTNAME IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $firstname The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_FIRSTNAME, $firstname, $comparison);

        return $this;
    }

    /**
     * Filter the query on the LASTNAME column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE LASTNAME = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE LASTNAME LIKE '%fooValue%'
     * $query->filterByLastname(['foo', 'bar']); // WHERE LASTNAME IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $lastname The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_LASTNAME, $lastname, $comparison);

        return $this;
    }

    /**
     * Filter the query on the EMAIL column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE EMAIL = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE EMAIL LIKE '%fooValue%'
     * $query->filterByEmail(['foo', 'bar']); // WHERE EMAIL IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $email The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmail($email = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_EMAIL, $email, $comparison);

        return $this;
    }

    /**
     * Filter the query on the PHONE column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE PHONE = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE PHONE LIKE '%fooValue%'
     * $query->filterByPhone(['foo', 'bar']); // WHERE PHONE IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $phone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPhone($phone = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_PHONE, $phone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ADDRESS column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE ADDRESS = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE ADDRESS LIKE '%fooValue%'
     * $query->filterByAddress(['foo', 'bar']); // WHERE ADDRESS IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $address The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAddress($address = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_ADDRESS, $address, $comparison);

        return $this;
    }

    /**
     * Filter the query on the CITY column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE CITY = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE CITY LIKE '%fooValue%'
     * $query->filterByCity(['foo', 'bar']); // WHERE CITY IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $city The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCity($city = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_CITY, $city, $comparison);

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

        $this->addUsingAlias(CustomerTableMap::COL_NOTE, $note, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \App\Model\Order object
     *
     * @param \App\Model\Order|ObjectCollection $order the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrder($order, ?string $comparison = null)
    {
        if ($order instanceof \App\Model\Order) {
            $this
                ->addUsingAlias(CustomerTableMap::COL_PK_, $order->getCustomerPk(), $comparison);

            return $this;
        } elseif ($order instanceof ObjectCollection) {
            $this
                ->useOrderQuery()
                ->filterByPrimaryKeys($order->getPrimaryKeys())
                ->endUse();

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
     * Exclude object from result
     *
     * @param ChildCustomer $customer Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($customer = null)
    {
        if ($customer) {
            $this->addUsingAlias(CustomerTableMap::COL_PK_, $customer->getPk(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomerTableMap::clearInstancePool();
            CustomerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CustomerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
