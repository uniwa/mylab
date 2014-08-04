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
 * @global type $db
 * @global type $Options
 * @global type $app
 * @param type $special_name
 * @param type $positioning
 * @param type $comments
 * @param type $operational_rating
 * @param type $technological_rating
 * @param type $lab_type
 * @param type $school_unit_id
 * @param type $state
 * @param type $lab_source
 * @param type $transition_date
 * @param type $transition_justification
 * @param type $transition_source
 * @return string
 * @throws Exception
 */

function PostLabs(  $special_name, $positioning, $comments, $operational_rating, $technological_rating, 
                    $lab_type, $school_unit_id, $state, $lab_source, 
                    $transition_date, $transition_justification, $transition_source ){
    
    global $app,$entityManager;

    $Labs = new Labs();
    $LabTransition = new LabTransitions();
    $result = array();

    $result["controller"] = __FUNCTION__;
    $result["function"] = substr($app->request()->getPathInfo(),1);
    $result["method"] = $app->request()->getMethod();
    $result["parameters"] = $app->request()->getBody();
    $params = loadParameters();
      
    try {
    
//$creation infos================================================================        
        $Labs->setCreationDate(new \DateTime (date('Y-m-d H:i:s')));  
        $Labs->setCreatedBy('myLab BetaUser');  
        
//$special_name==================================================================
        CRUDUtils::entitySetParam($Labs, $special_name, ExceptionMessages::InvalidLabSpecialNameType, 'specialName');
        
//$positioning==================================================================
        CRUDUtils::entitySetParam($Labs, $positioning, ExceptionMessages::InvalidLabSpecialNameType, 'positioning');
        
//$comments=====================================================================
        CRUDUtils::entitySetParam($Labs, $comments, ExceptionMessages::InvalidLabCommentsType, 'comments');
         
//$operational_rating===========================================================    
        if (Validator::Exists('operational_rating', $params)) { 
            if (Validator::Missing('operational_rating', $params))
                throw new Exception(ExceptionMessages::MissingLabOperationalRatingParam." : ".$operational_rating, ExceptionCodes::MissingLabOperationalRatingParam);
            else if (Validator::isNull($operational_rating))
                throw new Exception(ExceptionMessages::MissingLabOperationalRatingValue." : ".$operational_rating, ExceptionCodes::MissingLabOperationalRatingValue);
            else if (Validator::IsArray($operational_rating))
                throw new Exception(ExceptionMessages::InvalidLabOperationalRatingArray." : ".$operational_rating, ExceptionCodes::InvalidLabOperationalRatingArray);    
            else if (Validator::IsFiveStarSystem($operational_rating)) 
                 $Labs->setOperationalRating(Validator::ToFiveStarSystem($operational_rating)); 
            else
                throw new Exception(ExceptionMessages::InvalidLabOperationalRatingType." : ".$operational_rating, ExceptionCodes::InvalidLabOperationalRatingType);   
        }
        
//$technological_rating=========================================================
        if (Validator::Exists('operational_rating', $params)) { 
            if (Validator::Missing('technological_rating', $params))
                throw new Exception(ExceptionMessages::MissingLabTechnologicalRatingParam." : ".$technological_rating, ExceptionCodes::MissingLabTechnologicalRatingParam);
            else if (Validator::isNull($technological_rating))
                throw new Exception(ExceptionMessages::MissingLabTechnologicalRatingValue." : ".$technological_rating, ExceptionCodes::MissingLabTechnologicalRatingValue); 
            else if (Validator::IsArray($technological_rating))
                throw new Exception(ExceptionMessages::InvalidLabTechnologicalRatingArray." : ".$technological_rating, ExceptionCodes::InvalidLabTechnologicalRatingArray);    
            else if (Validator::IsFiveStarSystem($technological_rating)) 
                 $Labs->setTechnologicalRating(Validator::ToFiveStarSystem($technological_rating));               
            else
                throw new Exception(ExceptionMessages::InvalidLabTechnologicalRatingType." : ".$technological_rating, ExceptionCodes::InvalidLabTechnologicalRatingType);   
        }    
       
//$lab_type=====================================================================       
        CRUDUtils::entitySetAssociation($Labs, $lab_type, 'LabTypes', 'labType', 'LabType');
        
        if (Validator::IsID($lab_type)) {
            $findLabType= $entityManager->getRepository('LabTypes')->findOneBy(array ('labTypeId'=>$lab_type));
            $fLabTypeId = $findLabType->getLabTypeId();
            $fLabTypeName = $findLabType->getName();
        } else{
            $findLabType= $entityManager->getRepository('LabTypes')->findOneBy(array ('name'=>$lab_type));
            $fLabTypeId = $findLabType->getLabTypeId();
            $fLabTypeName = $findLabType->getName(); 
        }
        
//$school_unit_id=====================================================================       
        CRUDUtils::entitySetAssociation($Labs, $school_unit_id, 'SchoolUnits', 'schoolUnit', 'SchoolUnit');
        $findSchoolUnit = $entityManager->getRepository('SchoolUnits')->findOneBy(array ('schoolUnitId'=>$school_unit_id));
        $fSchoolUnitId = $findSchoolUnit->getSchoolUnitId();
        $fSchoolUnitName = $findSchoolUnit->getName();
        $fSchoolUnitStateId = $findSchoolUnit->getState()->getStateId();
  
//$state========================================================================       
        CRUDUtils::entitySetAssociation($Labs, $state, 'States', 'state', 'State');

//$lab_source===================================================================      
        CRUDUtils::entitySetAssociation($Labs, $lab_source, 'LabSources', 'labSource', 'LabSource');
    
//$transition_date==============================================================      
        if (Validator::Missing('transition_date', $params))
           throw new Exception(ExceptionMessages::MissingLabTransitionDateParam." : ".$transition_date, ExceptionCodes::MissingLabTransitionDateParam);
       else if (Validator::IsNull($transition_date))
            throw new Exception(ExceptionMessages::MissingLabTransitionDateValue." : ".$transition_date, ExceptionCodes::MissingLabTransitionDateValue);
       else if (Validator::IsArray($transition_date))
            throw new Exception(ExceptionMessages::InvalidLabTransitionDateArray." : ".$transition_date, ExceptionCodes::InvalidLabTransitionDateArray);    
       else if (! Validator::IsValidDate($transition_date) )
            throw new Exception(ExceptionMessages::InvalidLabTransitionValidType." : ".$transition_date, ExceptionCodes::InvalidLabTransitionValidType); 
       else if (Validator::IsDate($transition_date,'Y-m-d'))
            $LabTransition->setTransitionDate (new \DateTime($transition_date));
       else
            throw new Exception(ExceptionMessages::InvalidLabTransitionDateType." : ".$transition_date, ExceptionCodes::InvalidLabTransitionDateType);    
 
//$transition_justification===================================================== 
        if (Validator::Missing('transition_justification', $params))
            throw new Exception(ExceptionMessages::MissingLabTransitionJustificationParam." : ".$transition_justification, ExceptionCodes::MissingLabTransitionJustificationParam);          
        else if (Validator::IsNull($transition_justification))
            throw new Exception(ExceptionMessages::MissingLabTransitionDateValue." : ".$transition_justification, ExceptionCodes::MissingLabTransitionDateValue);                        
        else if (Validator::IsValue($transition_justification))
            $LabTransition->setTransitionJustification(Validator::ToValue($transition_justification));
        else
            throw new Exception(ExceptionMessages::InvalidLabTransitionJustificationType." : ".$transition_justification, ExceptionCodes::InvalidLabTransitionJustificationType);

//$transition_source============================================================ 
        if (Validator::Missing('transition_source', $params))
            throw new Exception(ExceptionMessages::MissingLabTransitionSourceParam." : ".$transition_source, ExceptionCodes::MissingLabTransitionSourceParam);          
        else if (Validator::IsNull($transition_source))
            throw new Exception(ExceptionMessages::MissingLabTransitionSourceValue." : ".$transition_source, ExceptionCodes::MissingLabTransitionSourceValue);                        
        else if (Validator::IsArray($transition_source))
            throw new Exception(ExceptionMessages::InvalidLabTransitionSourceArray." : ".$transition_source, ExceptionCodes::InvalidLabTransitionSourceArray);                        
        else if (Validator::IsTransitionSource($transition_source))
            $LabTransition->setTransitionSource(Validator::ToTransitionSource($transition_source));
        else
            throw new Exception(ExceptionMessages::InvalidLabTransitionSourceType." : ".$transition_source, ExceptionCodes::InvalidLabTransitionSourceType);

//user permisions===============================================================
//         $permissions = UserRoles::getUserPermissions($app->request->user);
//         if (!in_array(validator::ToID($lab_id),$permissions['permit_labs'])) {
//             throw new Exception(ExceptionMessages::NoPermissionToPostLab, ExceptionCodes::NoPermissionToPostLab); 
//         }; 
         
//controls======================================================================
        //$lab_name created auto with format : "lab_type_name.number_lab - school_unit_name"===
        if ($fSchoolUnitStateId == 1){ 
            if (Validator::IsNull($fSchoolUnitId) ) 
                throw new Exception(ExceptionMessages::MissingSchoolUnitIDValue." : ".$fSchoolUnitId, ExceptionCodes::MissingSchoolUnitIDValue);
            else if (Validator::IsNull($fLabTypeId))
                throw new Exception(ExceptionMessages::MissingLabTypeIDValue." : ".$fLabTypeId, ExceptionCodes::MissingLabTypeIDValue);
            else {
                //find count lab types of school unit===========================
                $checkCountLabs = $entityManager->getRepository('Labs')->findBy(array( 'schoolUnit'    => Validator::toID($fSchoolUnitId),
                                                                                       'labType'       => Validator::toID($fLabTypeId)
                                                                                     ));

                //create lab name 
                $num_of_lab = count($checkCountLabs) > 0 ? count($checkCountLabs) : 1;
                $lab_name = $fLabTypeName. '.' . ++$num_of_lab . ' - ' . $fSchoolUnitName;
                
                if (Validator::isNull($lab_name))
                    throw new Exception(ExceptionMessages::MissingLabNameValue." : ".$lab_name, ExceptionCodes::MissingLabNameValue); 
                else if (Validator::IsArray($lab_name))
                    throw new Exception(ExceptionMessages::InvalidLabNameArray." : ".$lab_name, ExceptionCodes::InvalidLabNameArray);    
                else if (Validator::IsValue($lab_name)) 
                     $Labs->setName(Validator::ToValue($lab_name));              
                else
                    throw new Exception(ExceptionMessages::InvalidLabNameType." : ".$lab_name, ExceptionCodes::InvalidLabNameType);  
                
            }
                
            //check if auto-created lab_name is duplicated to db================
                $checkCountLabsName = $entityManager->getRepository('Labs')->findOneBy(array( 'name'        => Validator::toValue($lab_name),
                                                                                              'schoolUnit'  => Validator::ToID($school_unit_id)
                                                                                          ));
                           
                if (count($checkCountLabsName) !== 0)
                    throw new Exception(ExceptionMessages::DuplicatedLabNameValue." : ".$lab_name, ExceptionCodes::DuplicatedLabNameValue);
                
        } else {
            throw new Exception(ExceptionMessages::NotAllowedLabNameValue." : ".$fSchoolUnitStateId, ExceptionCodes::NotAllowedLabNameValue); 
        }
                            
 //insert to db=================================================================
         
         $entityManager->persist($Labs);
         $entityManager->flush($Labs);
        $result["lab_id"] = $fLabId = $Labs->getLabId();
            
            //create lab_transition=============================================
            //TODO check if table transition has the initial transition
            //$LabTransition = $entityManager->find('Labs',$fLabId);
            CRUDUtils::entitySetAssociation($LabTransition, $fLabId, 'Labs', 'lab', 'Lab');      
            CRUDUtils::entitySetAssociation($LabTransition, 1, 'States', 'toState', 'State');
                $entityManager->persist($LabTransition);
                $entityManager->flush($LabTransition);
                $result["lab_transition_id"] = $LabTransition->getLabTransitionId();
            
         
         
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