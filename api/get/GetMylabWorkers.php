<?php
/**
 *
 * @version 2.0
 * @author  ΤΕΙ Αθήνας
 * @package GET
 */
 
header("Content-Type: text/html; charset=utf-8");

/**
 * 
 * @global type $entityManager
 * @global type $app
 * @param type $worker_id
 * @param type $registry_no
 * @param type $uid
 * @param type $firstname
 * @param type $lastname
 * @param type $fathername
 * @param type $email
 * @param type $worker_specialization
 * @param type $lab_source
 * @param Doctrine\ORM\Tools\Pagination\Paginator $worker
 * @param type $pagesize
 * @param type $page
 * @param type $searchtype
 * @param type $ordertype
 * @param type $orderby
 * @return type
 * @throws Exception
 */

function GetMylabWorkers( $worker_id, $registry_no, $uid, $firstname, $lastname, $fathername, $email,
                          $worker_specialization, $lab_source,
                          $worker,
                          $pagesize, $page, $searchtype, $ordertype, $orderby ) {
  
    global $entityManager, $app;

    $qb = $entityManager->createQueryBuilder();
    $result = array();  

    $result["data"] = array();
    $result["controller"] = __FUNCTION__;
    $result["function"] = substr($app->request()->getPathInfo(),1);
    $result["method"] = $app->request()->getMethod();
    $params = loadParameters();
    
    try {  
    
//$page - $pagesize - $searchtype - $ordertype =================================
       $page = Pagination::getPage($page, $params);
       $pagesize = Pagination::getPagesize($pagesize, $params);     
       $searchtype = Filters::getSearchType($searchtype, $params);
       $ordertype =  Filters::getOrderType($ordertype, $params);
               
//$orderby======================================================================
       $columns = array(
                            "mlw.workerId" => "worker_id",
                            "mlw.registryNo" => "registry_no",
                            "mlw.uid" => "uid" ,
                            "mlw.firstname" => "firstname",
                            "mlw.lastname" => "lastname",
                            "mlw.fathername" => "fathername",
                            "mlw.fathername" => "email",
                            "ws.workerSpecializationId" => "worker_specialization_id",
                            "ws.name" => "worker_specialization_name",
                            "ls.labSourceId" => "lab_source_id",
                            "ls.name" => "lab_source_name"
                        );
       
       if ( Validator::Missing('orderby', $params) )
            $orderby = "worker_id";
        else
        {   
            $orderby = Validator::ToLower($orderby);
            if (!in_array($orderby, $columns))
                throw new Exception(ExceptionMessages::InvalidOrderBy." : ".$orderby, ExceptionCodes::InvalidOrderBy);
        }
                      
//$worker_id====================================================================
        if (Validator::Exists('worker_id', $params)){
            CRUDUtils::setFilter($qb, $worker_id, "mlw", "workerId", "workerId", "id", ExceptionMessages::InvalidMylabWorkerIDType, ExceptionCodes::InvalidMylabWorkerIDType);
        } 

//$registry_number==============================================================
        if (Validator::Exists('registry_no', $params)){
            CRUDUtils::setFilter($qb, $registry_no, "mlw", "registryNo", "registryNo", "numeric", ExceptionMessages::InvalidMylabWorkerRegistryNoType, ExceptionCodes::InvalidMylabWorkerRegistryNoType);    
        }
        
//$uid===================================================================
        if (Validator::Exists('uid', $params)){
            CRUDUtils::setSearchFilter($qb, $uid, "mlw", "uid", $searchtype, ExceptionMessages::InvalidMylabWorkerUidType, ExceptionCodes::InvalidMylabWorkerUidType);    
        } 

//$firstname====================================================================
        if (Validator::Exists('firstname', $params)){
            CRUDUtils::setSearchFilter($qb, $firstname, "mlw", "firstname", $searchtype, ExceptionMessages::InvalidMylabWorkerFirstnameType, ExceptionCodes::InvalidMylabWorkerFirstnameType);    
        } 

//$lastname=====================================================================
        if (Validator::Exists('lastname', $params)){
            CRUDUtils::setSearchFilter ($qb, $lastname, "mlw", "lastname", $searchtype, ExceptionMessages::InvalidMylabWorkerLastnameType, ExceptionCodes::InvalidMylabWorkerLastnameType);
        }  

//$fathername===================================================================
        if (Validator::Exists('fathername', $params)){
            CRUDUtils::setSearchFilter($qb, $fathername, "mlw", "fathername", $searchtype, ExceptionMessages::InvalidMylabWorkerFatherNameType, ExceptionCodes::InvalidMylabWorkerFatherNameType);    
        } 

//$email========================================================================
        if (Validator::Exists('email', $params)){
            CRUDUtils::setSearchFilter($qb, $email, "mlw", "email", $searchtype, ExceptionMessages::InvalidMylabWorkerEmailType, ExceptionCodes::InvalidMylabWorkerEmailType);    
        } 
        
//$worker_specialization========================================================
        if (Validator::Exists('worker_specialization', $params)){
            CRUDUtils::setFilter($qb, $worker_specialization, "ws", "workerSpecializationId", "name", "null,id,value", ExceptionMessages::InvalidWorkerSpecializationType, ExceptionCodes::InvalidWorkerSpecializationType);    
        }  
        
//$lab_source=======================================================================
        if (Validator::Exists('source', $params)){
            CRUDUtils::setFilter($qb, $lab_source, "ls", "labSourceId", "name", "null,id,value", ExceptionMessages::InvalidLabSourceType, ExceptionCodes::InvalidLabSourceType);    
        } 
        
//balander parameter============================================================        
        if (Validator::Exists('worker', $params)){

            if (Validator::IsID($worker))
                CRUDUtils::setFilter($qb, $worker, "mlw", "registryNo", "registryNo", "startWith", ExceptionMessages::InvalidMylabWorkerRegistryNoType, ExceptionCodes::InvalidMylabWorkerRegistryNoType);    
            else
                CRUDUtils::setSearchFilter ($qb, $worker, "mlw", "lastname", $searchtype, ExceptionMessages::InvalidMylabWorkerLastnameType, ExceptionCodes::InvalidMylabWorkerLastnameType);
        } 

//execution=====================================================================
        $qb->select('mlw');
        $qb->from('MylabWorkers', 'mlw');
        $qb->leftjoin('mlw.workerSpecialization', 'ws');
        $qb->leftjoin('mlw.labSource', 'ls');
        $qb->orderBy(array_search($orderby, $columns), $ordertype);

//pagination and results========================================================     
        $results = new Doctrine\ORM\Tools\Pagination\Paginator($qb->getQuery());
        $result["total"] = count($results);
        $results->getQuery()->setFirstResult($pagesize * ($page-1));
        $pagesize!==Parameters::AllPageSize ? $results->getQuery()->setMaxResults($pagesize) : null;

//data results==================================================================       
        $count = 0;
        foreach ($results as $worker)
        {

            $result["data"][] = array(
                                        "worker_id"        => $worker->getWorkerId(),
                                        "registry_no"      => $worker->getRegistryNo(),
                                        "uid"              => $worker->getUid(),
                                        "firstname"        => $worker->getFirstname(),
                                        "lastname"         => $worker->getLastname(),
                                        "fathername"       => $worker->getFathername(),
                                        "email"            => $worker->getEmail(),
                                        "worker_specialization"      => Validator::IsNull($worker->getWorkerSpecialization()) ? Validator::ToNull() : $worker->getWorkerSpecialization()->getWorkerSpecializationId(),
                                        "worker_specialization_name" => Validator::IsNull($worker->getWorkerSpecialization()) ? Validator::ToNull() : $worker->getWorkerSpecialization()->getName(),
                                        "lab_source"      => Validator::IsNull($worker->getLabSource()) ? Validator::ToNull() : $worker->getLabSource()->getLabSourceId(),
                                        "lab_source_name" => Validator::IsNull($worker->getLabSource()) ? Validator::ToNull() : $worker->getLabSource()->getName()
                                     );
            $count++;
        }
        $result["count"] = $count;
   
//pagination results============================================================     
        $maxPage = Pagination::getMaxPage($result["total"],$page,$pagesize);
        $pagination = array( "page" => $page,   
                             "maxPage" => $maxPage, 
                             "pagesize" => $pagesize 
                            );    
        $result["pagination"]=$pagination;
           
//result_messages===============================================================    
        $result["status"] = ExceptionCodes::NoErrors;
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".ExceptionMessages::NoErrors;
    } catch (Exception $e) {
        $result["status"] = $e->getCode();
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".$e->getMessage();
    } 
    
//debug=========================================================================       
        if ( Validator::IsTrue( $params["debug"]  ) )
        {
             $result["DQL"] =  trim(preg_replace('/\s\s+/', ' ', $qb->getDQL()));
             $result["SQL"] =  trim(preg_replace('/\s\s+/', ' ', $qb->getQuery()->getSQL()));
        }
    
    return $result;       
           
}

?>