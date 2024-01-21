<?php

namespace App\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Model\Customer as ChildCustomer;
use App\Model\CustomerQuery as ChildCustomerQuery;
use App\Model\Order as ChildOrder;
use App\Model\OrderItem as ChildOrderItem;
use App\Model\OrderItemQuery as ChildOrderItemQuery;
use App\Model\OrderQuery as ChildOrderQuery;
use App\Model\User as ChildUser;
use App\Model\UserQuery as ChildUserQuery;
use App\Model\Map\OrderItemTableMap;
use App\Model\Map\OrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'myorder' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Order implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\App\\Model\\Map\\OrderTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the pk_ field.
     *
     * @var        int
     */
    protected $pk_;

    /**
     * The value for the customer_pk_ field.
     *
     * @var        int
     */
    protected $customer_pk_;

    /**
     * The value for the user_pk_ field.
     * user, ktory spravuje tuto objednavku
     * @var        int
     */
    protected $user_pk_;

    /**
     * The value for the status field.
     *
     * @var        int
     */
    protected $status;

    /**
     * The value for the created field.
     *
     * @var        DateTime
     */
    protected $created;

    /**
     * The value for the packed field.
     *
     * @var        DateTime|null
     */
    protected $packed;

    /**
     * The value for the shipped field.
     *
     * @var        DateTime|null
     */
    protected $shipped;

    /**
     * The value for the paied field.
     *
     * @var        DateTime|null
     */
    protected $paied;

    /**
     * The value for the real_price field.
     * cena, ktoru zakaznik naozaj zakaznik zaplatil
     * @var        double|null
     */
    protected $real_price;

    /**
     * The value for the note field.
     *
     * @var        string|null
     */
    protected $note;

    /**
     * @var        ChildCustomer
     */
    protected $aCustomer;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|ChildOrderItem[] Collection to store aggregation of ChildOrderItem objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildOrderItem> Collection to store aggregation of ChildOrderItem objects.
     */
    protected $collOrderItems;
    protected $collOrderItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildOrderItem[]
     * @phpstan-var ObjectCollection&\Traversable<ChildOrderItem>
     */
    protected $orderItemsScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Model\Base\Order object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Order</code> instance.  If
     * <code>obj</code> is an instance of <code>Order</code>, delegates to
     * <code>equals(Order)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [pk_] column value.
     *
     * @return int
     */
    public function getPk()
    {
        return $this->pk_;
    }

    /**
     * Get the [customer_pk_] column value.
     *
     * @return int
     */
    public function getCustomerPk()
    {
        return $this->customer_pk_;
    }

    /**
     * Get the [user_pk_] column value.
     * user, ktory spravuje tuto objednavku
     * @return int
     */
    public function getUserPk()
    {
        return $this->user_pk_;
    }

    /**
     * Get the [status] column value.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime : string)
     */
    public function getCreated($format = null)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTimeInterface ? $this->created->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [packed] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getPacked($format = null)
    {
        if ($format === null) {
            return $this->packed;
        } else {
            return $this->packed instanceof \DateTimeInterface ? $this->packed->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [shipped] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getShipped($format = null)
    {
        if ($format === null) {
            return $this->shipped;
        } else {
            return $this->shipped instanceof \DateTimeInterface ? $this->shipped->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [paied] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getPaied($format = null)
    {
        if ($format === null) {
            return $this->paied;
        } else {
            return $this->paied instanceof \DateTimeInterface ? $this->paied->format($format) : null;
        }
    }

    /**
     * Get the [real_price] column value.
     * cena, ktoru zakaznik naozaj zakaznik zaplatil
     * @return double|null
     */
    public function getRealPrice()
    {
        return $this->real_price;
    }

    /**
     * Get the [note] column value.
     *
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of [pk_] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setPk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->pk_ !== $v) {
            $this->pk_ = $v;
            $this->modifiedColumns[OrderTableMap::COL_PK_] = true;
        }

        return $this;
    }

    /**
     * Set the value of [customer_pk_] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCustomerPk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_pk_ !== $v) {
            $this->customer_pk_ = $v;
            $this->modifiedColumns[OrderTableMap::COL_CUSTOMER_PK_] = true;
        }

        if ($this->aCustomer !== null && $this->aCustomer->getPk() !== $v) {
            $this->aCustomer = null;
        }

        return $this;
    }

    /**
     * Set the value of [user_pk_] column.
     * user, ktory spravuje tuto objednavku
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUserPk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_pk_ !== $v) {
            $this->user_pk_ = $v;
            $this->modifiedColumns[OrderTableMap::COL_USER_PK_] = true;
        }

        if ($this->aUser !== null && $this->aUser->getPk() !== $v) {
            $this->aUser = null;
        }

        return $this;
    }

    /**
     * Set the value of [status] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[OrderTableMap::COL_STATUS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created->format("Y-m-d H:i:s.u")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OrderTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [packed] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setPacked($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->packed !== null || $dt !== null) {
            if ($this->packed === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->packed->format("Y-m-d H:i:s.u")) {
                $this->packed = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OrderTableMap::COL_PACKED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [shipped] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setShipped($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->shipped !== null || $dt !== null) {
            if ($this->shipped === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->shipped->format("Y-m-d H:i:s.u")) {
                $this->shipped = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OrderTableMap::COL_SHIPPED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [paied] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setPaied($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->paied !== null || $dt !== null) {
            if ($this->paied === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->paied->format("Y-m-d H:i:s.u")) {
                $this->paied = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OrderTableMap::COL_PAIED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [real_price] column.
     * cena, ktoru zakaznik naozaj zakaznik zaplatil
     * @param double|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setRealPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->real_price !== $v) {
            $this->real_price = $v;
            $this->modifiedColumns[OrderTableMap::COL_REAL_PRICE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [note] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[OrderTableMap::COL_NOTE] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OrderTableMap::translateFieldName('Pk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pk_ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OrderTableMap::translateFieldName('CustomerPk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_pk_ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OrderTableMap::translateFieldName('UserPk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_pk_ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OrderTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OrderTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OrderTableMap::translateFieldName('Packed', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->packed = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : OrderTableMap::translateFieldName('Shipped', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->shipped = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : OrderTableMap::translateFieldName('Paied', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->paied = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : OrderTableMap::translateFieldName('RealPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->real_price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : OrderTableMap::translateFieldName('Note', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = OrderTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\Order'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aCustomer !== null && $this->customer_pk_ !== $this->aCustomer->getPk()) {
            $this->aCustomer = null;
        }
        if ($this->aUser !== null && $this->user_pk_ !== $this->aUser->getPk()) {
            $this->aUser = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOrderQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCustomer = null;
            $this->aUser = null;
            $this->collOrderItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Order::setDeleted()
     * @see Order::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildOrderQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                OrderTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCustomer !== null) {
                if ($this->aCustomer->isModified() || $this->aCustomer->isNew()) {
                    $affectedRows += $this->aCustomer->save($con);
                }
                $this->setCustomer($this->aCustomer);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->orderItemsScheduledForDeletion !== null) {
                if (!$this->orderItemsScheduledForDeletion->isEmpty()) {
                    \App\Model\OrderItemQuery::create()
                        ->filterByPrimaryKeys($this->orderItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderItemsScheduledForDeletion = null;
                }
            }

            if ($this->collOrderItems !== null) {
                foreach ($this->collOrderItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[OrderTableMap::COL_PK_] = true;
        if (null !== $this->pk_) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrderTableMap::COL_PK_ . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrderTableMap::COL_PK_)) {
            $modifiedColumns[':p' . $index++]  = 'PK_';
        }
        if ($this->isColumnModified(OrderTableMap::COL_CUSTOMER_PK_)) {
            $modifiedColumns[':p' . $index++]  = 'CUSTOMER_PK_';
        }
        if ($this->isColumnModified(OrderTableMap::COL_USER_PK_)) {
            $modifiedColumns[':p' . $index++]  = 'USER_PK_';
        }
        if ($this->isColumnModified(OrderTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }
        if ($this->isColumnModified(OrderTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED';
        }
        if ($this->isColumnModified(OrderTableMap::COL_PACKED)) {
            $modifiedColumns[':p' . $index++]  = 'PACKED';
        }
        if ($this->isColumnModified(OrderTableMap::COL_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPED';
        }
        if ($this->isColumnModified(OrderTableMap::COL_PAIED)) {
            $modifiedColumns[':p' . $index++]  = 'PAIED';
        }
        if ($this->isColumnModified(OrderTableMap::COL_REAL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'REAL_PRICE';
        }
        if ($this->isColumnModified(OrderTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'NOTE';
        }

        $sql = sprintf(
            'INSERT INTO myorder (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'PK_':
                        $stmt->bindValue($identifier, $this->pk_, PDO::PARAM_INT);

                        break;
                    case 'CUSTOMER_PK_':
                        $stmt->bindValue($identifier, $this->customer_pk_, PDO::PARAM_INT);

                        break;
                    case 'USER_PK_':
                        $stmt->bindValue($identifier, $this->user_pk_, PDO::PARAM_INT);

                        break;
                    case 'STATUS':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);

                        break;
                    case 'CREATED':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'PACKED':
                        $stmt->bindValue($identifier, $this->packed ? $this->packed->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'SHIPPED':
                        $stmt->bindValue($identifier, $this->shipped ? $this->shipped->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'PAIED':
                        $stmt->bindValue($identifier, $this->paied ? $this->paied->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'REAL_PRICE':
                        $stmt->bindValue($identifier, $this->real_price, PDO::PARAM_STR);

                        break;
                    case 'NOTE':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setPk($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getPk();

            case 1:
                return $this->getCustomerPk();

            case 2:
                return $this->getUserPk();

            case 3:
                return $this->getStatus();

            case 4:
                return $this->getCreated();

            case 5:
                return $this->getPacked();

            case 6:
                return $this->getShipped();

            case 7:
                return $this->getPaied();

            case 8:
                return $this->getRealPrice();

            case 9:
                return $this->getNote();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Order'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Order'][$this->hashCode()] = true;
        $keys = OrderTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getPk(),
            $keys[1] => $this->getCustomerPk(),
            $keys[2] => $this->getUserPk(),
            $keys[3] => $this->getStatus(),
            $keys[4] => $this->getCreated(),
            $keys[5] => $this->getPacked(),
            $keys[6] => $this->getShipped(),
            $keys[7] => $this->getPaied(),
            $keys[8] => $this->getRealPrice(),
            $keys[9] => $this->getNote(),
        ];
        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCustomer) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'customer';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'customer';
                        break;
                    default:
                        $key = 'Customer';
                }

                $result[$key] = $this->aCustomer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collOrderItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'orderItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'myorder_items';
                        break;
                    default:
                        $key = 'OrderItems';
                }

                $result[$key] = $this->collOrderItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPk($value);
                break;
            case 1:
                $this->setCustomerPk($value);
                break;
            case 2:
                $this->setUserPk($value);
                break;
            case 3:
                $this->setStatus($value);
                break;
            case 4:
                $this->setCreated($value);
                break;
            case 5:
                $this->setPacked($value);
                break;
            case 6:
                $this->setShipped($value);
                break;
            case 7:
                $this->setPaied($value);
                break;
            case 8:
                $this->setRealPrice($value);
                break;
            case 9:
                $this->setNote($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = OrderTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPk($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCustomerPk($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserPk($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStatus($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreated($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPacked($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setShipped($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPaied($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRealPrice($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setNote($arr[$keys[9]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(OrderTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OrderTableMap::COL_PK_)) {
            $criteria->add(OrderTableMap::COL_PK_, $this->pk_);
        }
        if ($this->isColumnModified(OrderTableMap::COL_CUSTOMER_PK_)) {
            $criteria->add(OrderTableMap::COL_CUSTOMER_PK_, $this->customer_pk_);
        }
        if ($this->isColumnModified(OrderTableMap::COL_USER_PK_)) {
            $criteria->add(OrderTableMap::COL_USER_PK_, $this->user_pk_);
        }
        if ($this->isColumnModified(OrderTableMap::COL_STATUS)) {
            $criteria->add(OrderTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(OrderTableMap::COL_CREATED)) {
            $criteria->add(OrderTableMap::COL_CREATED, $this->created);
        }
        if ($this->isColumnModified(OrderTableMap::COL_PACKED)) {
            $criteria->add(OrderTableMap::COL_PACKED, $this->packed);
        }
        if ($this->isColumnModified(OrderTableMap::COL_SHIPPED)) {
            $criteria->add(OrderTableMap::COL_SHIPPED, $this->shipped);
        }
        if ($this->isColumnModified(OrderTableMap::COL_PAIED)) {
            $criteria->add(OrderTableMap::COL_PAIED, $this->paied);
        }
        if ($this->isColumnModified(OrderTableMap::COL_REAL_PRICE)) {
            $criteria->add(OrderTableMap::COL_REAL_PRICE, $this->real_price);
        }
        if ($this->isColumnModified(OrderTableMap::COL_NOTE)) {
            $criteria->add(OrderTableMap::COL_NOTE, $this->note);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildOrderQuery::create();
        $criteria->add(OrderTableMap::COL_PK_, $this->pk_);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getPk();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getPk();
    }

    /**
     * Generic method to set the primary key (pk_ column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setPk($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getPk();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \App\Model\Order (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setCustomerPk($this->getCustomerPk());
        $copyObj->setUserPk($this->getUserPk());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setPacked($this->getPacked());
        $copyObj->setShipped($this->getShipped());
        $copyObj->setPaied($this->getPaied());
        $copyObj->setRealPrice($this->getRealPrice());
        $copyObj->setNote($this->getNote());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOrderItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPk(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\Order Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildCustomer object.
     *
     * @param ChildCustomer $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setCustomer(ChildCustomer $v = null)
    {
        if ($v === null) {
            $this->setCustomerPk(NULL);
        } else {
            $this->setCustomerPk($v->getPk());
        }

        $this->aCustomer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCustomer object, it will not be re-added.
        if ($v !== null) {
            $v->addOrder($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCustomer object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildCustomer The associated ChildCustomer object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getCustomer(?ConnectionInterface $con = null)
    {
        if ($this->aCustomer === null && ($this->customer_pk_ != 0)) {
            $this->aCustomer = ChildCustomerQuery::create()->findPk($this->customer_pk_, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCustomer->addOrders($this);
             */
        }

        return $this->aCustomer;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param ChildUser $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserPk(NULL);
        } else {
            $this->setUserPk($v->getPk());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addOrder($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getUser(?ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_pk_ != 0)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_pk_, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addOrders($this);
             */
        }

        return $this->aUser;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('OrderItem' === $relationName) {
            $this->initOrderItems();
            return;
        }
    }

    /**
     * Clears out the collOrderItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addOrderItems()
     */
    public function clearOrderItems()
    {
        $this->collOrderItems = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collOrderItems collection loaded partially.
     *
     * @return void
     */
    public function resetPartialOrderItems($v = true): void
    {
        $this->collOrderItemsPartial = $v;
    }

    /**
     * Initializes the collOrderItems collection.
     *
     * By default this just sets the collOrderItems collection to an empty array (like clearcollOrderItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderItems(bool $overrideExisting = true): void
    {
        if (null !== $this->collOrderItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = OrderItemTableMap::getTableMap()->getCollectionClassName();

        $this->collOrderItems = new $collectionClassName;
        $this->collOrderItems->setModel('\App\Model\OrderItem');
    }

    /**
     * Gets an array of ChildOrderItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOrder is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOrderItem[] List of ChildOrderItem objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrderItem> List of ChildOrderItem objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getOrderItems(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collOrderItemsPartial && !$this->isNew();
        if (null === $this->collOrderItems || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collOrderItems) {
                    $this->initOrderItems();
                } else {
                    $collectionClassName = OrderItemTableMap::getTableMap()->getCollectionClassName();

                    $collOrderItems = new $collectionClassName;
                    $collOrderItems->setModel('\App\Model\OrderItem');

                    return $collOrderItems;
                }
            } else {
                $collOrderItems = ChildOrderItemQuery::create(null, $criteria)
                    ->filterByOrder($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderItemsPartial && count($collOrderItems)) {
                        $this->initOrderItems(false);

                        foreach ($collOrderItems as $obj) {
                            if (false == $this->collOrderItems->contains($obj)) {
                                $this->collOrderItems->append($obj);
                            }
                        }

                        $this->collOrderItemsPartial = true;
                    }

                    return $collOrderItems;
                }

                if ($partial && $this->collOrderItems) {
                    foreach ($this->collOrderItems as $obj) {
                        if ($obj->isNew()) {
                            $collOrderItems[] = $obj;
                        }
                    }
                }

                $this->collOrderItems = $collOrderItems;
                $this->collOrderItemsPartial = false;
            }
        }

        return $this->collOrderItems;
    }

    /**
     * Sets a collection of ChildOrderItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $orderItems A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setOrderItems(Collection $orderItems, ?ConnectionInterface $con = null)
    {
        /** @var ChildOrderItem[] $orderItemsToDelete */
        $orderItemsToDelete = $this->getOrderItems(new Criteria(), $con)->diff($orderItems);


        $this->orderItemsScheduledForDeletion = $orderItemsToDelete;

        foreach ($orderItemsToDelete as $orderItemRemoved) {
            $orderItemRemoved->setOrder(null);
        }

        $this->collOrderItems = null;
        foreach ($orderItems as $orderItem) {
            $this->addOrderItem($orderItem);
        }

        $this->collOrderItems = $orderItems;
        $this->collOrderItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrderItem objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related OrderItem objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countOrderItems(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collOrderItemsPartial && !$this->isNew();
        if (null === $this->collOrderItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderItems());
            }

            $query = ChildOrderItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrder($this)
                ->count($con);
        }

        return count($this->collOrderItems);
    }

    /**
     * Method called to associate a ChildOrderItem object to this object
     * through the ChildOrderItem foreign key attribute.
     *
     * @param ChildOrderItem $l ChildOrderItem
     * @return $this The current object (for fluent API support)
     */
    public function addOrderItem(ChildOrderItem $l)
    {
        if ($this->collOrderItems === null) {
            $this->initOrderItems();
            $this->collOrderItemsPartial = true;
        }

        if (!$this->collOrderItems->contains($l)) {
            $this->doAddOrderItem($l);

            if ($this->orderItemsScheduledForDeletion and $this->orderItemsScheduledForDeletion->contains($l)) {
                $this->orderItemsScheduledForDeletion->remove($this->orderItemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildOrderItem $orderItem The ChildOrderItem object to add.
     */
    protected function doAddOrderItem(ChildOrderItem $orderItem): void
    {
        $this->collOrderItems[]= $orderItem;
        $orderItem->setOrder($this);
    }

    /**
     * @param ChildOrderItem $orderItem The ChildOrderItem object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeOrderItem(ChildOrderItem $orderItem)
    {
        if ($this->getOrderItems()->contains($orderItem)) {
            $pos = $this->collOrderItems->search($orderItem);
            $this->collOrderItems->remove($pos);
            if (null === $this->orderItemsScheduledForDeletion) {
                $this->orderItemsScheduledForDeletion = clone $this->collOrderItems;
                $this->orderItemsScheduledForDeletion->clear();
            }
            $this->orderItemsScheduledForDeletion[]= clone $orderItem;
            $orderItem->setOrder(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Order is new, it will return
     * an empty collection; or if this Order has previously
     * been saved, it will retrieve related OrderItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Order.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildOrderItem[] List of ChildOrderItem objects
     * @phpstan-return ObjectCollection&\Traversable<ChildOrderItem}> List of ChildOrderItem objects
     */
    public function getOrderItemsJoinProduct(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderItemQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getOrderItems($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if (null !== $this->aCustomer) {
            $this->aCustomer->removeOrder($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeOrder($this);
        }
        $this->pk_ = null;
        $this->customer_pk_ = null;
        $this->user_pk_ = null;
        $this->status = null;
        $this->created = null;
        $this->packed = null;
        $this->shipped = null;
        $this->paied = null;
        $this->real_price = null;
        $this->note = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collOrderItems) {
                foreach ($this->collOrderItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOrderItems = null;
        $this->aCustomer = null;
        $this->aUser = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrderTableMap::DEFAULT_STRING_FORMAT);
    }

    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('customer_pk_', new NotNull());
        $metadata->addPropertyConstraint('user_pk_', new NotNull());
        $metadata->addPropertyConstraint('note', new Length(array ('max' => 500,)));
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param ValidatorInterface|null $validator A Validator class instance
     * @return bool Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (is_object($this->aCustomer) and method_exists($this->aCustomer, 'validate')) {
                if (!$this->aCustomer->validate($validator)) {
                    $failureMap->addAll($this->aCustomer->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (is_object($this->aUser) and method_exists($this->aUser, 'validate')) {
                if (!$this->aUser->validate($validator)) {
                    $failureMap->addAll($this->aUser->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collOrderItems) {
                foreach ($this->collOrderItems as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (bool) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
