<?php
header("Content-Type: text/html; charset=utf-8");
header('Content-Type: application/json');

chdir("../server");
require_once('system/includes.php');
require_once('libs/Slim/Slim.php');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->config('debug', true);


//school units
$app->map('/edu_admins', Authentication, EduAdminsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/education_levels', Authentication, EducationLevelsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/municipalities', Authentication, MunicipalitiesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/prefectures', Authentication, PrefecturesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/region_edu_admins', Authentication, RegionEduAdminsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/school_units', Authentication, SchoolUnitsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/school_unit_types', Authentication, SchoolUnitTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/transfer_areas', Authentication, TranferAreasController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/states', Authentication, StatesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/school_unit_workers', Authentication, SchoolUnitWorkersController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/circuits', Authentication, CircuitsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/circuit_types', Authentication, CircuitTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);

//labs
$app->map('/aquisition_sources', Authentication, AquisitionSourcesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/worker_positions', Authentication, WorkerPositionsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/equipment_categories', Authentication, EquipmentCategoriesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/equipment_types', Authentication, EquipmentTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/labs', Authentication, LabsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_aquisition_sources', Authentication, LabAquisitionSourcesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_equipment_types', Authentication, LabEquipmentTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/workers', Authentication, WorkersController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_types', Authentication, LabTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/worker_specializations', Authentication, WorkerSpecializationsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_relations', Authentication, LabRelationsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/relation_types', Authentication, RelationTypesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_sources', Authentication, LabSourcesController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_transitions', Authentication, LabTransitionsController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);
$app->map('/lab_workers', Authentication, LabWorkersController)
    ->via(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE);

$app->map('/search_school_units', SearchSchoolUnitsController)->via(MethodTypes::GET);
$app->map('/search_labs', SearchLabsController)->via(MethodTypes::GET);
$app->map('/search_lab_workers', SearchLabWorkersController)->via(MethodTypes::GET);

$app->map('/statistic_school_units', StatisticSchoolUnitsController)->via(MethodTypes::GET);
$app->map('/statistic_labs', StatisticLabsController)->via(MethodTypes::GET);
$app->map('/statistic_lab_workers', StatisticLabWorkersController)->via(MethodTypes::GET);

$app->get('/docs/*', function () use ($app) {
    $app->redirect("http://mmsch.teiath.gr/mylab/docs/");
});

//function not found
$app->notFound(function () use ($app) 
{
    $controller = $app->environment();
    $controller = substr($controller["PATH_INFO"], 1);

    try
    {
       if ( !in_array( strtoupper($app->request()->getMethod()), array(MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE)))
            throw new Exception(ExceptionMessages::MethodNotFound, ExceptionCodes::MethodNotFound);
        else
            throw new Exception(ExceptionMessages::MethodNotFound, ExceptionCodes::MethodNotFound);
    } 
    catch (Exception $e) 
    {
        $result["status"] = $e->getCode();
        $result["message"] = "[".$app->request()->getMethod()."][".$controller."]:".$e->getMessage();
    }

    echo toGreek( json_encode( $result ) ); 

});

$app->run();

#===== authentication controller ====================================================================

function Authentication()
{
    global $app;
    global $casOptions;

    if(isset($casOptions["NoAuth"]) && $casOptions["NoAuth"] == true) { return true; }
    try
    {
        if ( in_array( strtoupper($app->request()->getMethod()), array( MethodTypes::GET, MethodTypes::POST, MethodTypes::PUT, MethodTypes::DELETE )) )
        {
            // initialize phpCAS using SAML
            phpCAS::client(SAML_VERSION_1_1,$casOptions["Url"],$casOptions["Port"],'');
            // no SSL validation for the CAS server, only for testing environments
            phpCAS::setNoCasServerValidation();
            // handle backend logout requests from CAS server
            phpCAS::handleLogoutRequests(array($casOptions["Url"]));
            // force CAS authentication
            if (!phpCAS::checkAuthentication())
                phpCAS::forceAuthentication();
        }
        else 
        {
                throw new Exception(ExceptionMessages::Unauthorized, ExceptionCodes::Unauthorized);
        }
    }
    catch (Exception $e)
    {
        $result["status"] = $e->getCode();
        $result["message"] = "[".$app->request()->getMethod()."][".__FUNCTION__."]:".$e->getMessage();

        echo json_encode($result ? $result : array());
        
        $app->stop();
    }
}


function PrepareResponse()
{
    global $app;

    $app->contentType('application/json');
    $app->response()->headers()->set('Content-Type', 'application/json; charset=utf-8');
    $app->response()->headers()->set('X-Powered-By', 'ΤΕΙ Αθήνας');
    $app->response()->setStatus(200);
}


function UrlParamstoArray($params)
{
    $items = array();
    foreach (explode('&', $params) as $chunk) {
        $param = explode("=", $chunk);
        $items = array_merge($items, array($param[0] => urldecode($param[1])));
    }
    return $items;

}

function loadParameters()
{
    global $app;
     
    if ($app->request->getBody())
    {
        if ( is_array( $app->request->getBody() ) )
            $params = $app->request->getBody();
        else if ( json_decode( $app->request->getBody() ) )
            $params = get_object_vars( json_decode($app->request->getBody(), false) );
        else
            $params = UrlParamstoArray($app->request->getBody());
    }
    else
    {
        if ( json_decode( key($_REQUEST) ) )
            $params = get_object_vars( json_decode(key($_REQUEST), false) );
        else
            $params = $_REQUEST;
    }
    
    // array to object
    $params = json_decode (json_encode ($params), FALSE);

    return $params;
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

function toGreek($value)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $value ? $value : array());
}


#======= school units controllers ==========================================================
#===========================================================================================
function EduAdminsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetEduAdmins(
                $params->region_edu_admin,
                $params->pagesize, 
                $params->page,
                $params->sort_field,
                $params->sort_mode
                
            );      
            break;
        case MethodTypes::POST :
            $result = PostEduAdmins(
                $params->edu_admin_id, 
                $params->name, 
                $params->region_edu_admin,
                $params->sync_array
            );      
            break;
      case MethodTypes::PUT :
            $result = PutEduAdmins(
                $params->edu_admin_id,
                $params->name,
                $params->region_edu_admin
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelEduAdmins(
                $params->name 
            );      
            break;  
    }
    
    //echo toGreek( json_encode( $result ) );
    // echo json_encode($result ? $result : array());
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function EducationLevelsController()
{
    global $app;
    $params = loadParameters();    
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetEducationLevels(
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostEducationLevels(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutEducationLevels(
                 $params->education_level_id,
                 $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelEducationLevels(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function MunicipalitiesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetMunicipalities(
                $params->prefecture, 
                $params->transfer_area,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostMunicipalities(
                $params->name, 
                $params->transfer_area,
                $params->prefecture
            );      
            break;
      case MethodTypes::PUT :
            $result = PutMunicipalities(
                $params->municipality_id,
                $params->name, 
                $params->transfer_area,
                $params->prefecture
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelMunicipalities(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function PrefecturesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetPrefectures(
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostPrefectures(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutPrefectures(
                $params->prefecture_id,
                $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelPrefectures(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function RegionEduAdminsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetRegionEduAdmins(
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostRegionEduAdmins(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutRegionEduAdmins(
                $params->region_edu_admin_id,
                $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelRegionEduAdmins(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function SchoolUnitsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetSchoolUnits(
                $params->school_unit_id,
                $params->name,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture, 
                $params->education_level, 
                $params->school_unit_type,
                $params->state,
                $params->lab_type,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_state,
                $params->aquisition_source,
                $params->equipment_type,
                $params->lab_id,
                $params->lab_worker,
                $params->pagesize, 
                $params->page,
                $params->sort_field,
                $params->sort_mode
            );      
            break;
        case MethodTypes::POST :
            $result = PostSchoolUnits(
                $params->name,
                $params->fax_number,
                $params->phone_number,
                $params->email,
                $params->street_address,
                $params->postal_code,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture, 
                $params->education_level, 
                $params->school_unit_type  
            );      
            break;
      case MethodTypes::PUT :
            $result = PutSchoolUnits(
                $params->school_unit_id,
                $params->name,
                $params->fax_number,
                $params->phone_number,
                $params->email,
                $params->street_address,
                $params->postal_code,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture, 
                $params->education_level, 
                $params->school_unit_type  
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelSchoolUnits(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function SchoolUnitTypesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetSchoolUnitTypes(
                $params->education_level, 
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostSchoolUnitTypes(
                $params->name,
                $params->education_level
            );      
            break;
      case MethodTypes::PUT :
            $result = PutSchoolUnitTypes(
                $params->school_unit_type_id,
                $params->name,
                $params->education_level
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelSchoolUnitTypes(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function TranferAreasController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetTransferAreas(
                $params->edu_admin, 
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostTransferAreas(
                $params->name, 
                $params->edu_admin
            );      
            break;
      case MethodTypes::PUT :
            $result = PutTransferAreas(
                $params->transfer_area_id,
                $params->name, 
                $params->edu_admin
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelTransferAreas(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function StatesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetStates(    
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostStates(
//                $params->name
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutStates(
//                $params->state_id,
//                $params->name
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelStates(
//                $params->name
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function SchoolUnitWorkersController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetSchoolUnitWorkers(
                $params->school_unit, 
                $params->worker, 
                $params->worker_position, 
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostSchoolUnitWorkers(
//         
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutSchoolUnitWorkers(
//       
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelSchoolUnitWorkers(
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function CircuitsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetCircuits(
                $params->school_unit, 
                $params->circuit_type,
                $params->phone_number,
                $params->circuit,
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostCircuits(
//         
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutCircuits(
//       
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelCircuits(
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function CircuitTypesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetCircuitTypes(
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostCircuitTypes(
//         
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutCircuitTypes(
//       
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelCircuitTypes(
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}
#======= labs controllers ===================================================================
#============================================================================================

function AquisitionSourcesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetAquisitionSources(    
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostAquisitionSources(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutAquisitionSources(
                $params->aquisition_source_id,
                $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelAquisitionSources(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}


function WorkerPositionsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetWorkerPositions(    
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostWorkerPositions(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutWorkerPositions(
                $params->employment_relationship_id,
                $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelWorkerPositions(
                $params->name
            );      
            break;  
    }   
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function EquipmentCategoriesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetEquipmentCategories(    
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostEquipmentCategories(
                $params->name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutEquipmentCategories(
                $params->equipment_category_id,
                $params->name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelEquipmentCategories(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function EquipmentTypesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetEquipmentTypes(
                $params->equipment_category,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostEquipmentTypes(
                $params->name,
                $params->number,
                $params->equipment_category
            );      
            break;
      case MethodTypes::PUT :
            $result = PutEquipmentTypes(
                $params->equipment_type_id,
                $params->name,
                $params->number,
                $params->equipment_category
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelEquipmentTypes(
                $params->name
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}


function LabsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabs(
                $params->lab_id,
                $params->name,
                $params->special_name,
                $params->creation_date,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_worker,
                $params->lab_type,
                $params->school_unit,
                $params->state,
                $params->source,
                $params->aquisition_source,
                $params->equipment_type,
                $params->pagesize, 
                $params->page,
                $params->sort_field,
                $params->sort_mode
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabs(
                $params->special_name,
                $params->positioning,
                $params->comments,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_type,
                $params->school_unit,
                $params->state,
                $params->lab_source,
                $params->lab_worker,
                $params->worker_start_service,
                $params->transition_date, 
                $params->transition_justification, 
                $params->transition_source,
                $params->relation_served_service,
                $params->relation_served_online,
                $params->aquisition_sources,
                $params->equipment_types
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabs(
                $params->lab_id,
                $params->special_name,
                $params->positioning,
                $params->comments,
                $params->operational_rating,
                $params->technological_rating,
                $params->state,
                $params->lab_source,
                $params->transition_date, 
                $params->transition_justification, 
                $params->transition_source
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabs(
                $params->lab_id
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabAquisitionSourcesController()
{
    global $app;
    $params = loadParameters();
   
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabAquisitionSources(
                $params->lab,
                $params->aquisition_source,
                $params->aquisition_year,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabAquisitionSources(
                $params->lab_id,
                $params->aquisition_source,
                $params->aquisition_year,
                $params->aquisition_comments,
                $params->multiple_aquisition_sources
            );
      
            break;
      case MethodTypes::PUT :
            $result = PutLabAquisitionSources(
                $params->lab_aquisition_source_id,
                $params->lab_id,
                $params->aquisition_source,
                $params->aquisition_year,
                $params->aquisition_comments
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabAquisitionSources(
                $params->lab_aquisition_source_id
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabEquipmentTypesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabEquipmentTypes(
                $params->lab,
                $params->equipment_type,
                $params->equipment_category,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabEquipmentTypes(
                $params->lab_id,
                $params->equipment_type,
                $params->items,
                $params->multiple_equipment_types
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabEquipmentTypes(
                $params->lab_id,
                $params->equipment_type,
                $params->items 
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabEquipmentTypes(
                $params->lab_id,
                $params->equipment_type
            );     
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}


function WorkersController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetWorkers(
                $params->registry_no,
                $params->worker_specialization,
                $params->lastname,
                $params->worker,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostWorkers(
                $params->registry_number,
                $params->firstname,
                $params->lastname, 
                $params->fathername,
                $params->sex,
                $params->specialization_code,
                $params->employment_relationship
            );      
            break;
      case MethodTypes::PUT :
            $result = PutWorkers(
                $params->lab_responsible_id,
                $params->registry_number,
                $params->firstname,
                $params->lastname, 
                $params->fathername,
                $params->sex,
                $params->specialization_code,
                $params->employment_relationship      
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelWorkers(
                $params->registry_number
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabTypesController()
{
    global $app;  
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabTypes(    
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabTypes(
                $params->name,
                $params->info_name
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabTypes(
                $params->lab_type_id,
                $params->name,
                $params->info_name
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabTypes(
                $params->name
            );      
            break;  
    }   
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}


function WorkerSpecializationsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetWorkerSpecializations(    
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostWorkerSpecializations(
                $params->code
            );      
            break;
      case MethodTypes::PUT :
            $result = PutWorkerSpecializations(
                $params->specialization_code_id,
                $params->code
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelWorkerSpecializations(
                $params->code
            );      
            break;  
    }   
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabRelationsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabRelations(
                $params->lab,
                $params->school_unit,
                $params->relation_type,
                $params->circuit,
                $params->phone_number,
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabRelations(
                $params->lab_id, 
                $params->school_unit,
                $params->relation_type, 
                $params->circuit_id
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabRelations(
                $params->lab_relation_id,
                $params->lab_id, 
                $params->school_unit,
                $params->relation_type, 
                $params->circuit_id
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabRelations(
                $params->lab_relation_id
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function RelationTypesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetRelationTypes(
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostRelationTypes(
// 
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutRelationTypes(
//       
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelRelationTypes(
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabSourcesController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabSources(
                $params->pagesize, 
                $params->page
            );      
            break;
//        case MethodTypes::POST :
//            $result = PostLabSources(
//         
//            );      
//            break;
//      case MethodTypes::PUT :
//            $result = PutLabSources(
//       
//            );      
//            break;
//       case MethodTypes::DELETE :
//            $result = DelLabSources(
//            );      
//            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabTransitionsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabTransitions(
                $params->lab, 
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabTransitions(
                $params->lab_id, 
                $params->state,
                $params->transition_date, 
                $params->transition_justification, 
                $params->transition_source
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabTransitions(
                $params->lab_transition_id,
                $params->transition_justification, 
                $params->transition_source
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabTransitions(
                $params->lab_transition_id
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );
}

function LabWorkersController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = GetLabWorkers(
                $params->lab, 
                $params->worker, 
                $params->worker_position,
                $params->worker_status, 
                $params->pagesize, 
                $params->page
            );      
            break;
        case MethodTypes::POST :
            $result = PostLabWorkers(
                    $params->lab_id,
                    $params->worker_id,
                    $params->worker_position,
                    $params->worker_email,
                    $params->worker_status,
                    $params->worker_start_service
            );      
            break;
      case MethodTypes::PUT :
            $result = PutLabWorkers(
                    $params->lab_worker_id,
                    $params->worker_status
            );      
            break;
       case MethodTypes::DELETE :
            $result = DelLabWorkers(
                    $params->lab_worker_id
            );      
            break;  
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}


function SearchSchoolUnitsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = SearchSchoolUnits(
                $params->school_unit_id,
                $params->name,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture, 
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->lab_id,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_type,
                $params->lab_state,
                $params->aquisition_source,
                $params->equipment_type,
                $params->lab_worker,
                $params->pagesize, 
                $params->page,
                $params->orderby,
                $params->ordertype,
                $params->searchtype,
                $params->exportdatatype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

function SearchLabsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = SearchLabs(
                $params->lab_id,
                $params->name,
                $params->special_name,
                $params->creation_date,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_type,
                $params->school_unit,
                $params->lab_state,
                $params->lab_source,
                $params->aquisition_source,
                $params->equipment_type,                    
                $params->lab_worker,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture,
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->pagesize, 
                $params->page,
                $params->orderby,
                $params->ordertype,
                $params->searchtype,
                $params->exportdatatype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

function SearchLabWorkersController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = SearchLabWorkers(
                $params->lab_worker_id,
                $params->worker_status,
                $params->worker_start_service,
                $params->lab_id,
                $params->lab_name,
                $params->worker_position,
                $params->worker,
                $params->worker_registry_no,
                $params->lab_type,
                $params->school_unit_id,
                $params->school_unit_name,
                $params->lab_state,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture,
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->pagesize, 
                $params->page,
                $params->orderby,
                $params->ordertype,
                $params->searchtype,
                $params->exportdatatype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

function StatisticSchoolUnitsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = StatisticSchoolUnits(
                $params->school_unit_id,
                $params->name,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture, 
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->lab_id,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_type,
                $params->lab_state,
                $params->aquisition_source,
                $params->equipment_type,
                $params->lab_worker,
                $params->searchtype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

function StatisticLabsController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = StatisticLabs(
                $params->lab_id,
                $params->name,
                $params->special_name,
                $params->creation_date,
                $params->operational_rating,
                $params->technological_rating,
                $params->lab_type,
                $params->school_unit,
                $params->lab_state,
                $params->lab_source,
                $params->aquisition_source,
                $params->equipment_type,                    
                $params->lab_worker,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture,
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->searchtype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

function StatisticLabWorkersController()
{
    global $app;
    $params = loadParameters();
    
    switch ( strtoupper( $app->request()->getMethod() ) )
    {
        case MethodTypes::GET : 
            $result = StatisticLabWorkers(
                $params->lab_worker_id,
                $params->worker_status,
                $params->worker_start_service,
                $params->lab_id,
                $params->lab_name,
                $params->worker_position,
                $params->worker,
                $params->worker_registry_no,
                $params->lab_type,
                $params->school_unit_id,
                $params->school_unit_name,
                $params->lab_state,
                $params->region_edu_admin,
                $params->edu_admin,
                $params->transfer_area,
                $params->municipality,
                $params->prefecture,
                $params->education_level, 
                $params->school_unit_type,
                $params->school_unit_state,
                $params->searchtype,
                $params->debug
            );      
            break;
    }
    
    PrepareResponse();
    $app->response()->setBody( toGreek( json_encode( $result ) ) );

}

?>