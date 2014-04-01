<?php

header("Content-Type: text/html; charset=utf-8");

/**
 * 
 * @global type $db
 * @global type $Options
 * @param type $pagesize
 * @param int $page
 * @return string
 * @throws Exception
 */

function GetPrefectures($pagesize, $page) {
    global $db;
    global $Options;
    global $app;
    
    $filter = array();
    $result = array();  

    $result["data"] = array();
    $controller = $app->environment();
    $controller = substr($controller["PATH_INFO"], 1);
    
    $result["function"] = $controller;
    $result["method"] = $app->request()->getMethod();

    try {
        
        //= Pages ==============================================================
        if (! $page)
            $page = 1;
        else if (intval($page) < 0)
	        throw new Exception(ExceptionMessages::InvalidPageNumber." : ".$page, ExceptionCodes::InvalidPageNumber);
        else if (!is_numeric($page))
	        throw new Exception(ExceptionMessages::InvalidPageType." : ".$page, ExceptionCodes::InvalidPageType);
        
        if (! $pagesize)
            $pagesize = $Options["PageSize"];
        else if (intval($pagesize) < 0)
	        throw new Exception(ExceptionMessages::InvalidPageSizeNumber." : ".$pagesize, ExceptionCodes::InvalidPageSizeNumber);
        else if (!is_numeric($pagesize))
	        throw new Exception(ExceptionMessages::InvalidPageSizeType." : ".$pagesize, ExceptionCodes::InvalidPageSizeType);
        else if ($pagesize > $Options["MaxPageSize"])
                throw new Exception(ExceptionMessages::InvalidPageSizeNumber." : ".$pagesize, ExceptionCodes::InvalidPageSizeNumber);

        $startat = ($page -1) * $pagesize;
        $pagesize = 0;
        
        //==============================================================================
     
        $sort = array( new DSC(PrefecturesExt::FIELD_NAME, DSC::ASC) );

        $oPrefectures = new PrefecturesExt($db);
        $totalRows = $oPrefectures->findByFilterAsCount($db, $filter, true);
        $result["total"] = $totalRows[0]->getPrefectureId();
        
        if ($pagesize)        
            $countRows = $oPrefectures->findByFilterWithLimit($db, $filter, true, $sort, $startat, $pagesize);
        else
            $countRows = $oPrefectures->findByFilter($db, $filter, true, $sort);
        
        $result["count"] = count( $countRows );

        foreach ($countRows as $row) {
            $result["data"][] = array("prefecture_id" => $row->getPrefectureId(), 
                                      "name" => $row->getName()
                                );
        }

        $result["status"] = ExceptionCodes::NoErrors;
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".ExceptionMessages::NoErrors;
    } catch (Exception $e) {
        $result["status"] = $e->getCode();
        $result["message"] = "[".$result["method"]."][".$result["function"]."]:".$e->getMessage();
    } 
    return $result;
}

?>