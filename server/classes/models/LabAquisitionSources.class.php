<?php

/**
 * 
 *
 * @version 1.107
 * @package entity
 */
class LabAquisitionSources extends Db2PhpEntityBase implements Db2PhpEntityModificationTracking {
	private static $CLASS_NAME='LabAquisitionSources';
	const SQL_IDENTIFIER_QUOTE='`';
	const SQL_TABLE_NAME='lab_aquisition_sources';
	const SQL_INSERT='INSERT INTO `lab_aquisition_sources` (`lab_aquisition_source_id`,`lab_id`,`aquisition_source_id`,`aquisition_year`,`aquisition_comments`) VALUES (?,?,?,?,?)';
	const SQL_INSERT_AUTOINCREMENT='INSERT INTO `lab_aquisition_sources` (`lab_id`,`aquisition_source_id`,`aquisition_year`,`aquisition_comments`) VALUES (?,?,?,?)';
	const SQL_UPDATE='UPDATE `lab_aquisition_sources` SET `lab_aquisition_source_id`=?,`lab_id`=?,`aquisition_source_id`=?,`aquisition_year`=?,`aquisition_comments`=? WHERE `lab_aquisition_source_id`=?';
	const SQL_SELECT_PK='SELECT * FROM `lab_aquisition_sources` WHERE `lab_aquisition_source_id`=?';
	const SQL_DELETE_PK='DELETE FROM `lab_aquisition_sources` WHERE `lab_aquisition_source_id`=?';
	const FIELD_LAB_AQUISITION_SOURCE_ID=547144725;
	const FIELD_LAB_ID=70304258;
	const FIELD_AQUISITION_SOURCE_ID=-568458461;
	const FIELD_AQUISITION_YEAR=-1779612071;
	const FIELD_AQUISITION_COMMENTS=-288870896;
	private static $PRIMARY_KEYS=array(self::FIELD_LAB_AQUISITION_SOURCE_ID);
	private static $AUTOINCREMENT_FIELDS=array(self::FIELD_LAB_AQUISITION_SOURCE_ID);
	private static $FIELD_NAMES=array(
		self::FIELD_LAB_AQUISITION_SOURCE_ID=>'lab_aquisition_source_id',
		self::FIELD_LAB_ID=>'lab_id',
		self::FIELD_AQUISITION_SOURCE_ID=>'aquisition_source_id',
		self::FIELD_AQUISITION_YEAR=>'aquisition_year',
		self::FIELD_AQUISITION_COMMENTS=>'aquisition_comments');
	private static $PROPERTY_NAMES=array(
		self::FIELD_LAB_AQUISITION_SOURCE_ID=>'labAquisitionSourceId',
		self::FIELD_LAB_ID=>'labId',
		self::FIELD_AQUISITION_SOURCE_ID=>'aquisitionSourceId',
		self::FIELD_AQUISITION_YEAR=>'aquisitionYear',
		self::FIELD_AQUISITION_COMMENTS=>'aquisitionComments');
	private static $PROPERTY_TYPES=array(
		self::FIELD_LAB_AQUISITION_SOURCE_ID=>Db2PhpEntity::PHP_TYPE_INT,
		self::FIELD_LAB_ID=>Db2PhpEntity::PHP_TYPE_INT,
		self::FIELD_AQUISITION_SOURCE_ID=>Db2PhpEntity::PHP_TYPE_INT,
		self::FIELD_AQUISITION_YEAR=>Db2PhpEntity::PHP_TYPE_STRING,
		self::FIELD_AQUISITION_COMMENTS=>Db2PhpEntity::PHP_TYPE_STRING);
	private static $FIELD_TYPES=array(
		self::FIELD_LAB_AQUISITION_SOURCE_ID=>array(Db2PhpEntity::JDBC_TYPE_INTEGER,10,0,false),
		self::FIELD_LAB_ID=>array(Db2PhpEntity::JDBC_TYPE_INTEGER,10,0,false),
		self::FIELD_AQUISITION_SOURCE_ID=>array(Db2PhpEntity::JDBC_TYPE_INTEGER,10,0,false),
		self::FIELD_AQUISITION_YEAR=>array(Db2PhpEntity::JDBC_TYPE_DATE,0,0,true),
		self::FIELD_AQUISITION_COMMENTS=>array(Db2PhpEntity::JDBC_TYPE_VARCHAR,255,0,true));
	private static $DEFAULT_VALUES=array(
		self::FIELD_LAB_AQUISITION_SOURCE_ID=>null,
		self::FIELD_LAB_ID=>0,
		self::FIELD_AQUISITION_SOURCE_ID=>0,
		self::FIELD_AQUISITION_YEAR=>null,
		self::FIELD_AQUISITION_COMMENTS=>null);
	private $labAquisitionSourceId;
	private $labId;
	private $aquisitionSourceId;
	private $aquisitionYear;
	private $aquisitionComments;

	/**
	 * set value for lab_aquisition_source_id Ο κωδικός της πηγής χρηματοδότησης ενός σχολικού εργαστηρίου.
	 *
	 * type:INT,size:10,default:null,primary,unique,autoincrement
	 *
	 * @param mixed $labAquisitionSourceId
	 * @return LabAquisitionSources
	 */
	public function &setLabAquisitionSourceId($labAquisitionSourceId) {
		$this->notifyChanged(self::FIELD_LAB_AQUISITION_SOURCE_ID,$this->labAquisitionSourceId,$labAquisitionSourceId);
		$this->labAquisitionSourceId=$labAquisitionSourceId;
		return $this;
	}

	/**
	 * get value for lab_aquisition_source_id Ο κωδικός της πηγής χρηματοδότησης ενός σχολικού εργαστηρίου.
	 *
	 * type:INT,size:10,default:null,primary,unique,autoincrement
	 *
	 * @return mixed
	 */
	public function getLabAquisitionSourceId() {
		return $this->labAquisitionSourceId;
	}

	/**
	 * set value for lab_id Ο κωδικός  σχολικού εργαστηρίου. 
	 *
	 * type:INT,size:10,default:null,index
	 *
	 * @param mixed $labId
	 * @return LabAquisitionSources
	 */
	public function &setLabId($labId) {
		$this->notifyChanged(self::FIELD_LAB_ID,$this->labId,$labId);
		$this->labId=$labId;
		return $this;
	}

	/**
	 * get value for lab_id Ο κωδικός  σχολικού εργαστηρίου. 
	 *
	 * type:INT,size:10,default:null,index
	 *
	 * @return mixed
	 */
	public function getLabId() {
		return $this->labId;
	}

	/**
	 * set value for aquisition_source_id Ο κωδικός της πηγής χρηματοδότησης.
	 *
	 * type:INT,size:10,default:null,index
	 *
	 * @param mixed $aquisitionSourceId
	 * @return LabAquisitionSources
	 */
	public function &setAquisitionSourceId($aquisitionSourceId) {
		$this->notifyChanged(self::FIELD_AQUISITION_SOURCE_ID,$this->aquisitionSourceId,$aquisitionSourceId);
		$this->aquisitionSourceId=$aquisitionSourceId;
		return $this;
	}

	/**
	 * get value for aquisition_source_id Ο κωδικός της πηγής χρηματοδότησης.
	 *
	 * type:INT,size:10,default:null,index
	 *
	 * @return mixed
	 */
	public function getAquisitionSourceId() {
		return $this->aquisitionSourceId;
	}

	/**
	 * set value for aquisition_year Η χρονολογια απόκτησης της πηγής χρηματοδότησης.
	 *
	 * type:YEAR,size:0,default:null,nullable
	 *
	 * @param mixed $aquisitionYear
	 * @return LabAquisitionSources
	 */
	public function &setAquisitionYear($aquisitionYear) {
		$this->notifyChanged(self::FIELD_AQUISITION_YEAR,$this->aquisitionYear,$aquisitionYear);
		$this->aquisitionYear=$aquisitionYear;
		return $this;
	}

	/**
	 * get value for aquisition_year Η χρονολογια απόκτησης της πηγής χρηματοδότησης.
	 *
	 * type:YEAR,size:0,default:null,nullable
	 *
	 * @return mixed
	 */
	public function getAquisitionYear() {
		return $this->aquisitionYear;
	}

	/**
	 * set value for aquisition_comments Σχόλια για την πηγή χρηματοδότησης.
	 *
	 * type:VARCHAR,size:255,default:null,nullable
	 *
	 * @param mixed $aquisitionComments
	 * @return LabAquisitionSources
	 */
	public function &setAquisitionComments($aquisitionComments) {
		$this->notifyChanged(self::FIELD_AQUISITION_COMMENTS,$this->aquisitionComments,$aquisitionComments);
		$this->aquisitionComments=$aquisitionComments;
		return $this;
	}

	/**
	 * get value for aquisition_comments Σχόλια για την πηγή χρηματοδότησης.
	 *
	 * type:VARCHAR,size:255,default:null,nullable
	 *
	 * @return mixed
	 */
	public function getAquisitionComments() {
		return $this->aquisitionComments;
	}

	/**
	 * Get table name
	 *
	 * @return string
	 */
	public static function getTableName() {
		return self::SQL_TABLE_NAME;
	}

	/**
	 * Get array with field id as index and field name as value
	 *
	 * @return array
	 */
	public static function getFieldNames() {
		return self::$FIELD_NAMES;
	}

	/**
	 * Get array with field id as index and property name as value
	 *
	 * @return array
	 */
	public static function getPropertyNames() {
		return self::$PROPERTY_NAMES;
	}

	/**
	 * get the field name for the passed field id.
	 *
	 * @param int $fieldId
	 * @param bool $fullyQualifiedName true if field name should be qualified by table name
	 * @return string field name for the passed field id, null if the field doesn't exist
	 */
	public static function getFieldNameByFieldId($fieldId, $fullyQualifiedName=true) {
		if (!array_key_exists($fieldId, self::$FIELD_NAMES)) {
			return null;
		}
		$fieldName=self::SQL_IDENTIFIER_QUOTE . self::$FIELD_NAMES[$fieldId] . self::SQL_IDENTIFIER_QUOTE;
		if ($fullyQualifiedName) {
			return self::SQL_IDENTIFIER_QUOTE . self::SQL_TABLE_NAME . self::SQL_IDENTIFIER_QUOTE . '.' . $fieldName;
		}
		return $fieldName;
	}

	/**
	 * Get array with field ids of identifiers
	 *
	 * @return array
	 */
	public static function getIdentifierFields() {
		return self::$PRIMARY_KEYS;
	}

	/**
	 * Get array with field ids of autoincrement fields
	 *
	 * @return array
	 */
	public static function getAutoincrementFields() {
		return self::$AUTOINCREMENT_FIELDS;
	}

	/**
	 * Get array with field id as index and property type as value
	 *
	 * @return array
	 */
	public static function getPropertyTypes() {
		return self::$PROPERTY_TYPES;
	}

	/**
	 * Get array with field id as index and field type as value
	 *
	 * @return array
	 */
	public static function getFieldTypes() {
		return self::$FIELD_TYPES;
	}

	/**
	 * Assign default values according to table
	 * 
	 */
	public function assignDefaultValues() {
		$this->assignByArray(self::$DEFAULT_VALUES);
	}


	/**
	 * return hash with the field name as index and the field value as value.
	 *
	 * @return array
	 */
	public function toHash() {
		$array=$this->toArray();
		$hash=array();
		foreach ($array as $fieldId=>$value) {
			$hash[self::$FIELD_NAMES[$fieldId]]=$value;
		}
		return $hash;
	}

	/**
	 * return array with the field id as index and the field value as value.
	 *
	 * @return array
	 */
	public function toArray() {
		return array(
			self::FIELD_LAB_AQUISITION_SOURCE_ID=>$this->getLabAquisitionSourceId(),
			self::FIELD_LAB_ID=>$this->getLabId(),
			self::FIELD_AQUISITION_SOURCE_ID=>$this->getAquisitionSourceId(),
			self::FIELD_AQUISITION_YEAR=>$this->getAquisitionYear(),
			self::FIELD_AQUISITION_COMMENTS=>$this->getAquisitionComments());
	}


	/**
	 * return array with the field id as index and the field value as value for the identifier fields.
	 *
	 * @return array
	 */
	public function getPrimaryKeyValues() {
		return array(
			self::FIELD_LAB_AQUISITION_SOURCE_ID=>$this->getLabAquisitionSourceId());
	}

	/**
	 * cached statements
	 *
	 * @var array<string,array<string,PDOStatement>>
	 */
	private static $stmts=array();
	private static $cacheStatements=true;
	
	/**
	 * prepare passed string as statement or return cached if enabled and available
	 *
	 * @param PDO $db
	 * @param string $statement
	 * @return PDOStatement
	 */
	protected static function prepareStatement(PDO $db, $statement) {
		if(self::isCacheStatements()) {
			if (in_array($statement, array(self::SQL_INSERT, self::SQL_INSERT_AUTOINCREMENT, self::SQL_UPDATE, self::SQL_SELECT_PK, self::SQL_DELETE_PK))) {
				$dbInstanceId=spl_object_hash($db);
				if (empty(self::$stmts[$statement][$dbInstanceId])) {
					self::$stmts[$statement][$dbInstanceId]=$db->prepare($statement);
				}
				return self::$stmts[$statement][$dbInstanceId];
			}
		}
		return $db->prepare($statement);
	}

	/**
	 * Enable statement cache
	 *
	 * @param bool $cache
	 */
	public static function setCacheStatements($cache) {
		self::$cacheStatements=true==$cache;
	}

	/**
	 * Check if statement cache is enabled
	 *
	 * @return bool
	 */
	public static function isCacheStatements() {
		return self::$cacheStatements;
	}
	
	/**
	 * check if this instance exists in the database
	 *
	 * @param PDO $db
	 * @return bool
	 */
	public function existsInDatabase(PDO $db) {
		$filter=array();
		foreach ($this->getPrimaryKeyValues() as $fieldId=>$value) {
			$filter[]=new DFC($fieldId, $value, DFC::EXACT_NULLSAFE);
		}
		return 0!=count(self::findByFilter($db, $filter, true));
	}
	
	/**
	 * Update to database if exists, otherwise insert
	 *
	 * @param PDO $db
	 * @return mixed
	 */
	public function updateInsertToDatabase(PDO $db) {
		if ($this->existsInDatabase($db)) {
			return $this->updateToDatabase($db);
		} else {
			return $this->insertIntoDatabase($db);
		}
	}

	/**
	 * Query by Example.
	 *
	 * Match by attributes of passed example instance and return matched rows as an array of LabAquisitionSources instances
	 *
	 * @param PDO $db a PDO Database instance
	 * @param LabAquisitionSources $example an example instance defining the conditions. All non-null properties will be considered a constraint, null values will be ignored.
	 * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
	 * @param array $sort array of DSC instances
	 * @return LabAquisitionSources[]
	 */
	public static function findByExample(PDO $db,LabAquisitionSources $example, $and=true, $sort=null) {
		$exampleValues=$example->toArray();
		$filter=array();
		foreach ($exampleValues as $fieldId=>$value) {
			if (null!==$value) {
				$filter[$fieldId]=$value;
			}
		}
		return self::findByFilter($db, $filter, $and, $sort);
	}

	/**
	 * Query by filter.
	 *
	 * The filter can be either an hash with the field id as index and the value as filter value,
	 * or a array of DFC instances.
	 *
	 * Will return matched rows as an array of LabAquisitionSources instances.
	 *
	 * @param PDO $db a PDO Database instance
	 * @param array $filter array of DFC instances defining the conditions
	 * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
	 * @param array $sort array of DSC instances
	 * @return LabAquisitionSources[]
	 */
	public static function findByFilter(PDO $db, $filter, $and=true, $sort=null) {
		if (!($filter instanceof DFCInterface)) {
			$filter=new DFCAggregate($filter, $and);
		}
		$sql='SELECT * FROM `lab_aquisition_sources`'
		. self::buildSqlWhere($filter, $and, false, true)
		. self::buildSqlOrderBy($sort);

		$stmt=self::prepareStatement($db, $sql);
		self::bindValuesForFilter($stmt, $filter);
		return self::fromStatement($stmt);
	}

	/**
	 * Will execute the passed statement and return the result as an array of LabAquisitionSources instances
	 *
	 * @param PDOStatement $stmt
	 * @return LabAquisitionSources[]
	 */
	public static function fromStatement(PDOStatement $stmt) {
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		return self::fromExecutedStatement($stmt);
	}

	/**
	 * returns the result as an array of LabAquisitionSources instances without executing the passed statement
	 *
	 * @param PDOStatement $stmt
	 * @return LabAquisitionSources[]
	 */
	public static function fromExecutedStatement(PDOStatement $stmt) {
		$resultInstances=array();
		while($result=$stmt->fetch(PDO::FETCH_ASSOC)) {
			$o=new LabAquisitionSources();
			$o->assignByHash($result);
			$o->notifyPristine();
			$resultInstances[]=$o;
		}
		$stmt->closeCursor();
		return $resultInstances;
	}

	/**
	 * Get sql WHERE part from filter.
	 *
	 * @param array $filter
	 * @param bool $and
	 * @param bool $fullyQualifiedNames true if field names should be qualified by table name
	 * @param bool $prependWhere true if WHERE should be prepended to conditions
	 * @return string
	 */
	public static function buildSqlWhere($filter, $and, $fullyQualifiedNames=true, $prependWhere=false) {
		if (!($filter instanceof DFCInterface)) {
			$filter=new DFCAggregate($filter, $and);
		}
		return $filter->buildSqlWhere(new self::$CLASS_NAME, $fullyQualifiedNames, $prependWhere);
	}

	/**
	 * get sql ORDER BY part from DSCs
	 *
	 * @param array $sort array of DSC instances
	 * @return string
	 */
	protected static function buildSqlOrderBy($sort) {
		return DSC::buildSqlOrderBy(new self::$CLASS_NAME, $sort);
	}

	/**
	 * bind values from filter to statement
	 *
	 * @param PDOStatement $stmt
	 * @param DFCInterface $filter
	 */
	public static function bindValuesForFilter(PDOStatement &$stmt, DFCInterface $filter) {
		$filter->bindValuesForFilter(new self::$CLASS_NAME, $stmt);
	}

	/**
	 * Execute select query and return matched rows as an array of LabAquisitionSources instances.
	 *
	 * The query should of course be on the table for this entity class and return all fields.
	 *
	 * @param PDO $db a PDO Database instance
	 * @param string $sql
	 * @return LabAquisitionSources[]
	 */
	public static function findBySql(PDO $db, $sql) {
		$stmt=$db->query($sql);
		return self::fromExecutedStatement($stmt);
	}

	/**
	 * Delete rows matching the filter
	 *
	 * The filter can be either an hash with the field id as index and the value as filter value,
	 * or a array of DFC instances.
	 *
	 * @param PDO $db
	 * @param array $filter
	 * @param bool $and
	 * @return mixed
	 */
	public static function deleteByFilter(PDO $db, $filter, $and=true) {
		if (!($filter instanceof DFCInterface)) {
			$filter=new DFCAggregate($filter, $and);
		}
		if (0==count($filter)) {
			throw new InvalidArgumentException('refusing to delete without filter'); // just comment out this line if you are brave
		}
		$sql='DELETE FROM `lab_aquisition_sources`'
		. self::buildSqlWhere($filter, $and, false, true);
		$stmt=self::prepareStatement($db, $sql);
		self::bindValuesForFilter($stmt, $filter);
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		$stmt->closeCursor();
		return $affected;
	}

	/**
	 * Assign values from array with the field id as index and the value as value
	 *
	 * @param array $array
	 */
	public function assignByArray($array) {
		$result=array();
		foreach ($array as $fieldId=>$value) {
			$result[self::$FIELD_NAMES[$fieldId]]=$value;
		}
		$this->assignByHash($result);
	}

	/**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	public function assignByHash($result) {
		$this->setLabAquisitionSourceId($result['lab_aquisition_source_id']);
		$this->setLabId($result['lab_id']);
		$this->setAquisitionSourceId($result['aquisition_source_id']);
		$this->setAquisitionYear($result['aquisition_year']);
		$this->setAquisitionComments($result['aquisition_comments']);
	}

	/**
	 * Get element instance by it's primary key(s).
	 * Will return null if no row was matched.
	 *
	 * @param PDO $db
	 * @return LabAquisitionSources
	 */
	public static function findById(PDO $db,$labAquisitionSourceId) {
		$stmt=self::prepareStatement($db,self::SQL_SELECT_PK);
		$stmt->bindValue(1,$labAquisitionSourceId);
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		if(!$result) {
			return null;
		}
		$o=new LabAquisitionSources();
		$o->assignByHash($result);
		$o->notifyPristine();
		return $o;
	}

	/**
	 * Bind all values to statement
	 *
	 * @param PDOStatement $stmt
	 */
	protected function bindValues(PDOStatement &$stmt) {
		$stmt->bindValue(1,$this->getLabAquisitionSourceId());
		$stmt->bindValue(2,$this->getLabId());
		$stmt->bindValue(3,$this->getAquisitionSourceId());
		$stmt->bindValue(4,$this->getAquisitionYear());
		$stmt->bindValue(5,$this->getAquisitionComments());
	}


	/**
	 * Insert this instance into the database
	 *
	 * @param PDO $db
	 * @return mixed
	 */
	public function insertIntoDatabase(PDO $db) {
		if (null===$this->getLabAquisitionSourceId()) {
			$stmt=self::prepareStatement($db,self::SQL_INSERT_AUTOINCREMENT);
			$stmt->bindValue(1,$this->getLabId());
			$stmt->bindValue(2,$this->getAquisitionSourceId());
			$stmt->bindValue(3,$this->getAquisitionYear());
			$stmt->bindValue(4,$this->getAquisitionComments());
		} else {
			$stmt=self::prepareStatement($db,self::SQL_INSERT);
			$this->bindValues($stmt);
		}
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		$lastInsertId=$db->lastInsertId();
		if (false!==$lastInsertId) {
			$this->setLabAquisitionSourceId($lastInsertId);
		}
		$stmt->closeCursor();
		$this->notifyPristine();
		return $affected;
	}


	/**
	 * Update this instance into the database
	 *
	 * @param PDO $db
	 * @return mixed
	 */
	public function updateToDatabase(PDO $db) {
		$stmt=self::prepareStatement($db,self::SQL_UPDATE);
		$this->bindValues($stmt);
		$stmt->bindValue(6,$this->getLabAquisitionSourceId());
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		$stmt->closeCursor();
		$this->notifyPristine();
		return $affected;
	}


	/**
	 * Delete this instance from the database
	 *
	 * @param PDO $db
	 * @return mixed
	 */
	public function deleteFromDatabase(PDO $db) {
		$stmt=self::prepareStatement($db,self::SQL_DELETE_PK);
		$stmt->bindValue(1,$this->getLabAquisitionSourceId());
		$affected=$stmt->execute();
		if (false===$affected) {
			$stmt->closeCursor();
			throw new Exception($stmt->errorCode() . ':' . var_export($stmt->errorInfo(), true), 0);
		}
		$stmt->closeCursor();
		return $affected;
	}

	/**
	 * Fetch AquisitionSources which references this LabAquisitionSources. Will return null in case reference is invalid.
	 * `lab_aquisition_sources`.`aquisition_source_id` -> `aquisition_sources`.`aquisition_source_id`
	 *
	 * @param PDO $db a PDO Database instance
	 * @param array $sort array of DSC instances
	 * @return AquisitionSources
	 */
	public function fetchAquisitionSources(PDO $db, $sort=null) {
		$filter=array(AquisitionSources::FIELD_AQUISITION_SOURCE_ID=>$this->getAquisitionSourceId());
		$result=AquisitionSources::findByFilter($db, $filter, true, $sort);
		return empty($result) ? null : $result[0];
	}

	/**
	 * Fetch Labs which references this LabAquisitionSources. Will return null in case reference is invalid.
	 * `lab_aquisition_sources`.`lab_id` -> `labs`.`lab_id`
	 *
	 * @param PDO $db a PDO Database instance
	 * @param array $sort array of DSC instances
	 * @return Labs
	 */
	public function fetchLabs(PDO $db, $sort=null) {
		$filter=array(Labs::FIELD_LAB_ID=>$this->getLabId());
		$result=Labs::findByFilter($db, $filter, true, $sort);
		return empty($result) ? null : $result[0];
	}


	/**
	 * get element as DOM Document
	 *
	 * @return DOMDocument
	 */
	public function toDOM() {
		return self::hashToDomDocument($this->toHash(), 'LabAquisitionSources');
	}

	/**
	 * get single LabAquisitionSources instance from a DOMElement
	 *
	 * @param DOMElement $node
	 * @return LabAquisitionSources
	 */
	public static function fromDOMElement(DOMElement $node) {
		$o=new LabAquisitionSources();
		$o->assignByHash(self::domNodeToHash($node, self::$FIELD_NAMES, self::$DEFAULT_VALUES, self::$FIELD_TYPES));
			$o->notifyPristine();
		return $o;
	}

	/**
	 * get all instances of LabAquisitionSources from the passed DOMDocument
	 *
	 * @param DOMDocument $doc
	 * @return LabAquisitionSources[]
	 */
	public static function fromDOMDocument(DOMDocument $doc) {
		$instances=array();
		foreach ($doc->getElementsByTagName('LabAquisitionSources') as $node) {
			$instances[]=self::fromDOMElement($node);
		}
		return $instances;
	}

}
?>