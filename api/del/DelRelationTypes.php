<?php
/**
 *
 * @version 2.0
 * @author  ΤΕΙ Αθήνας
 * @package POST
 * 
 */

header("Content-Type: text/html; charset=utf-8");

/**
 * 
 * @global type $app
 * @global type $entityManager
 * @param type $relation_type_id
 * @return string
 * @throws Exception
 */

function DelRelationTypes($relation_type_id) {
  
    global $app,$entityManager;

    $result = array();

    $result["controller"] = __FUNCTION__;
    $result["function"] = substr($app->request()->getPathInfo(),1);
    $result["method"] = $app->request()->getMethod();
    $result["parameters"] = json_decode($app->request()->getBody());
    $params = loadParameters();
    
    try {
        
//$relation_type_id=============================================================
        $fRelationTypeID = CRUDUtils::checkIDParam('relation_type_id', $params, $relation_type_id, 'RelationTypeID');
        
//user permisions===============================================================
//TODO ΒΑΛΕ ΝΑ ΜΠΟΡΕΙ ΝΑ ΤΟ ΚΑΝΕΙ ΕΝΑΣ ΧΡΗΣΤΗΣ ΠΟΥ ΝΑ ΑΝΗΚΕΙ ΣΕ ΜΙΑ ΚΑΤΗΓΟΡΙΑ 
//

//controls======================================================================          
        
        //check duplicates and unique row=======================================        
        $check = $entityManager->getRepository('RelationTypes')->findBy(array( 'relationTypeId' => $fRelationTypeID ));
        $count= count($check);

        if ($count == 1)
            $RelationTypes = $entityManager->find('RelationTypes', $fRelationTypeID);
        else if ($count == 0)
            throw new Exception(ExceptionMessages::NotFoundDelRelationTypeValue." : ".$fRelationTypeID ,ExceptionCodes::NotFoundDelRelationTypeValue);
        else 
            throw new Exception(ExceptionMessages::DuplicateDelRelationTypeValue." : ".$fRelationTypeID ,ExceptionCodes::DuplicateDelRelationTypeValue);
        
        //check for references =================================================   
        $checkReference = $entityManager->getRepository('LabRelations')->findOneBy(array( 'relationType'  => $fRelationTypeID ));

        if (count($checkReference) != 0)
            throw new Exception(ExceptionMessages::ReferencesRelationTypeLabRelationTypes. $fRelationTypeID,ExceptionCodes::ReferencesRelationTypeLabRelationTypes);  
        
//delete from db================================================================
        $entityManager->remove($RelationTypes);
        $entityManager->flush($RelationTypes);
           
//result_messages===============================================================      
        $result["status"] = ExceptionCodes::NoErrors;
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".ExceptionMessages::NoErrors;
    } catch (Exception $e) {
        $result["status"] = $e->getCode();
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".$e->getMessage();
    }                
    
    return $result;
} 

?>