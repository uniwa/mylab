<?php

/**
*
* @version 1.0
* @author  ΤΕΙ Αθήνας
* @package api\classes\extends
*/

require_once('classes/models/WorkerPositions.class.php');

class WorkerPositionsExt extends WorkerPositions {
    private static $rowsArray ;
    private static $objsArray ;
        
    public function __construct(PDO $db) 
    {
        if ( ( ! is_array( self::$rowsArray ) ) && $db ) 
        {
           //self::getAll($db, null);
        }
    }

    public function getRowsArray() 
    {
        return self::$rowsArray;
    }
        
    public function getObjsArray() 
    {
        return self::$objsArray;
    }
        
    public static function getAll(PDO $db, $filter, $and=true, $sort=null) 
    {
        self::$rowsArray = array();
        self::$objsArray = array();
        
        $objs = self::findByFilter($db, $filter, $and, $sort);

        foreach($objs as $obj)
        {
            self::$rowsArray[$obj->getWorkerPositionId()] = $obj->getName(); 
            self::$objsArray[$obj->getWorkerPositionId()] = $obj; 
        }
    }
    
    public static function getAllWithLimit(PDO $db, $filter, $and=true, $sort=null, $start=null, $count=null) 
    {
        self::$rowsArray = array();
        self::$objsArray = array();
        
        $objs = self::findByFilterWithLimit($db, $filter, $and, $sort, $start, $count);

        foreach($objs as $obj)
        {
            self::$rowsArray[$obj->getWorkerPositionId()] = $obj->getName(); 
            self::$objsArray[$obj->getWorkerPositionId()] = $obj; 
        }
    }
    
    public function searchArrayForID($id)
    {
        $obj = self::$objsArray[$id];
        
        if ($obj)
            $this->assignByArray($obj->toArray());
        else
            $this->assignDefaultValues ();
        
        return $this;
    }
    
    public function searchArrayForValue($name)
    {
        $id = array_search($name, $this->getRowsArray());
        
        $obj = self::$objsArray[$id];
        
        if ($obj)
        {
            $this->assignByArray($obj->toArray());
        }
        
        return $this;
    }
    
    public static function findByFilterWithLimit(PDO $db, $filter, $and=true, $sort=null, $start=null, $count=null) 
    {
		if (!($filter instanceof DFCInterface)) 
        {
			$filter=new DFCAggregate($filter, $and);
		}
		$sql='SELECT * FROM `'.self::SQL_TABLE_NAME.'`'
		. self::buildSqlWhere($filter, $and, false, true)
		. self::buildSqlOrderBy($sort);

        if (isset($start) && isset($count))
            $sql .=' LIMIT '.$start.', '.$count;
        
		$stmt=self::prepareStatement($db, $sql);
		self::bindValuesForFilter($stmt, $filter);
		return self::fromStatement($stmt);
	}

    public static function findByFilterAsCount(PDO $db, $filter, $and=true) 
    {
        $fieldNames = array_values(self::getFieldNames());

        if (!($filter instanceof DFCInterface)) 
        {
            $filter=new DFCAggregate($filter, $and);
        }
        $sql='SELECT count(*) as '.$fieldNames[0].' FROM `'.self::SQL_TABLE_NAME.'`'
        . self::buildSqlWhere($filter, $and, false, true);

        $stmt=self::prepareStatement($db, $sql);
        self::bindValuesForFilter($stmt, $filter);
 
        return self::fromStatement($stmt);
    }

    public function insertIntoArray()
    {
        self::$rowsArray[$this->getWorkerPositionId()] = $this->getName(); 
        self::$objsArray[$this->getWorkerPositionId()] = $this; 
    }
    
    public function existsInDatabase(PDO $db) {
            $filter=array();
            foreach ($this->getPrimaryKeyValues() as $fieldId=>$value) {
                    $filter[]=new DFC($fieldId, $value, DFC::EXACT);
            }
            return 0!=count(self::findByFilter($db, $filter, true));
    }
}

?>