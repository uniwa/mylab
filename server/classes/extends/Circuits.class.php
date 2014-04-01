<?php

/**
*
* @version 1.4
* @author  ΤΕΙ Αθήνας
* @package api\classes\extends
*/

require_once('classes/models/Circuits.class.php');

class CircuitsExt extends Circuits{
    
    private $rowsArray;
    private $objsArray;
    
    /**
     * costructor
     *
     * @param PDO $db
     */     
    public function __construct(PDO $db) 
    {
        if ( ( ! is_array( $this->rowsArray ) ) && $db ) 
        {
           //self::getAll($db, null);
        }
    }

    /**
     * get rowsArray array with results 
     *
     * example results :
     * [rowsArray:AquisitionSourcesExt:private] => Array
     *     (
     *          [2] => ΔΩΡΕΑ 
     *          [1] => ΠΡΟΣΚΛΗΣΗ 80
     *     )
     * 
     * @param int $rowId Id of aquisition_source
     * @return array Array if $rowId=0 or String if $rowId>0 and $rowId=found   
     */
    public function getRowsArray($rowId=0)
    {
        if ($rowId)
            return $this->rowsArray[$rowId];
        else
            return $this->rowsArray;
    }
    
    /**
    * get objsArray array with results  
    *
    * example results :
    * [objsArray:AquisitionSourcesExt:private] => Array
    *   (
    *       [2] => AquisitionSources Object 
    *          ( 
    *               [aquisitionSourceId:AquisitionSources:private] => 2 
    *               [name:AquisitionSources:private] => ΔΩΡΕΑ 
    *               [oldInstance:Db2PhpEntityBase:private] => 
    *          ) 
    *          
    *      [1] => AquisitionSources Object 
    *          ( 
    *               [aquisitionSourceId:AquisitionSources:private] => 1 
    *               [name:AquisitionSources:private] => ΠΡΟΣΚΛΗΣΗ 80 
    *               [oldInstance:Db2PhpEntityBase:private] => 
    *          )
    *
    *   )
    * 
    * @param int $rowId Id of aquisition_source
    * @return array  Array of objects if $rowId=0 or Object if $rowId>0 and $rowId=found   
    */   
    public function getObjsArray($rowId=0) 
    {
        if ($rowId)
            return $this->objsArray[$rowId];
        else
            return $this->objsArray;
    }
  
    /**
     * Get all results from findByFilter(query by filter) and create arrays.
     *
     * Create rowsArray array with the aquisition_source_id as index and the aquisition_source name as value.
     * Create objsArray array with the aquisition_source_id as index and the value as value.  
     * 
     * @param PDO $db
     * @param array $filter array of DFC instances defining the conditions
     * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
     * @param array $sort array of DSC instances
     */  
    public function getAll(PDO $db, $filter, $and=true, $sort=null) 
    {
        $this->rowsArray = array();
        $this->objsArray = array();
        
        $objs = self::findByFilter($db, $filter, $and, $sort);

        foreach($objs as $obj)
        {
            $this->rowsArray[$obj->getCircuitId()] = $obj->getCircuitId(); 
            $this->objsArray[$obj->getCircuitId()] = $obj; 
        }
    }
 
    /**
     * Get all results from findByFilterWithLimit(query by filter) and create arrays.
     *
     * Create rowsArray array with the aquisition_source_id as index and the aquisition_source name as value.
     * Create objsArray array with the aquisition_source_id as index and the value as value.  
     * 
     * @param PDO $db
     * @param array $filter array of DFC instances defining the conditions
     * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
     * @param array $sort array of DSC instances
     * @param int $startAt is the starting point 
     * @param int $pagesize is the duration
     */      
    public function getAllWithLimit(PDO $db, $filter, $and=true, $sort=null, $startAt=null, $pagesize=null) 
    {
        $this->rowsArray = array();
        $this->objsArray = array();
        
        $objs = self::findByFilterWithLimit($db, $filter, $and, $sort, $startAt, $pagesize);

        foreach($objs as $obj)
        {
            $this->rowsArray[$obj->getCircuitId()] = $obj->getCircuitId(); 
            $this->objsArray[$obj->getCircuitId()] = $obj; 
        }
    }
  
    /**
     * search with id to return array with values of the id
     *
     * @param int $id id of aquisition_source
     * @return array
     */    
    public function searchArrayForID($id, $rowId=0)
    {
        if ($rowId)
            $obj = $this->objsArray[$rowId][$id];
        else
            $obj = $this->objsArray[$id];
        
        if ($obj)
            $this->assignByArray($obj->toArray());
        else
            $this->assignDefaultValues ();
        
        return $this;
    }
    
    /**
     * search with name to return array with values of the name's id
     *
     * @param string $name name of aquisition_source
     * @return array
     */ 
    public function searchArrayForValue($name, $rowId=0)
    {
        if ($rowId)
            $id = array_search($name, $this->getRowsArray($rowId));
        else
            $id = array_search($name, $this->getRowsArray());
                
        $obj = $this->objsArray[$id];
        
        if ($obj)
        {
            $this->assignByArray($obj->toArray());
        }
        
        return $this;
    }
 
    /**
     * Query by filter with limit.
     *
     * The filter can be either an hash with the field id as index and the value as filter value,
     * or a array of DFC instances.
     *
     * Limit is used to limit your MySQL query results to those that fall within a specified range.
     * 
     * Will return matched rows as an array of AquisitionSources instances with limit.
     *
     * @param PDO $db a PDO Database instance
     * @param array $filter array of DFC instances defining the conditions
     * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
     * @param array $sort array of DSC instances
     * @param int $startAt is the starting point 
     * @param int $pagesize is the duration
     * @return AquisitionSources[]
     */
    public static function findByFilterWithLimit(PDO $db, $filter, $and=true, $sort=null, $startAt=null, $pagesize=null) 
    {
		if (!($filter instanceof DFCInterface)) 
        {
			$filter=new DFCAggregate($filter, $and);
		}
		$sql='SELECT * FROM `'.self::SQL_TABLE_NAME.'`'
		. self::buildSqlWhere($filter, $and, false, true)
		. self::buildSqlOrderBy($sort);

        if (isset($startAt) && ($pagesize <> Parameters::AllPageSize))
            $sql .=' LIMIT '.$startAt.', '.$pagesize;
        
		$stmt=self::prepareStatement($db, $sql);
		self::bindValuesForFilter($stmt, $filter);
		return self::fromStatement($stmt);
	}

    /**
     * Query by filter for computation the count of results with filter.
     *
     * The filter can be either an hash with the field id as index and the value as filter value,
     * or a array of DFC instances.
     * 
     * Will return an array of AquisitionSources which contain count value at AquisitionSourceId field.
     *
     * @param PDO $db a PDO Database instance
     * @param array $filter array of DFC instances defining the conditions
     * @param boolean $and true if conditions should be and'ed, false if they should be or'ed
     * @return AquisitionSources[]
     */
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
    
    /**
     * check if this instance exists in the database with DFC::EXACT 
     *
     * @param PDO $db
     * @return bool
     */              
    public function existsInDatabase(PDO $db) {
            $filter=array();
            foreach ($this->getPrimaryKeyValues() as $fieldId=>$value) {
                    $filter[]=new DFC($fieldId, $value, DFC::EXACT);
            }
            return 0!=count(self::findByFilter($db, $filter, true));
    }
    
}
?>