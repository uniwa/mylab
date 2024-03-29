<?php

header("Content-Type: text/html; charset=utf-8");

function isJson($string) {
  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
}

function EmptyStringOnNull($arg)
{
    if (is_null($arg)) {
        $arg = "";
    }
    
    return $arg;
}

function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

function getIDFromValuesArray($value, $array)
{
    foreach ($array as $id => $arr)
    {
        if ($arr["Name"] == $value)
        {
            return $id;
        }
    }
    
    return false;
}

function humanTiming($time)
{
    $value = "";
    
    $diff = time()-$time;
    $daysDiff = floor($diff/60/60/24);
    if ($daysDiff) $value .= $daysDiff.' day'.($daysDiff > 1 ? 's' :'');
    
    $diff -= $daysDiff*60*60*24;
    $hrsDiff = floor($diff/60/60);
    if ($hrsDiff) $value .= ($value ? ', ': '').$hrsDiff.' hour'.($hrsDiff > 1 ? 's' :'');

    $diff -= $hrsDiff*60*60;
    $minsDiff = floor($diff/60);
    if ($minsDiff) $value .= ($value ? ', ': '').$minsDiff.' minute'.($minsDiff > 1 ? 's' :'');

    $diff -= $minsDiff*60;
    $secsDiff = $diff;
    if ($secsDiff) $value .= ($value ? ' and ': '').$secsDiff.' second'.($secsDiff > 1 ? 's' :'');
    
    if (!$value) $value = '0 seconds';
    
    return $value;
}

//work recursive in php multidimensions array from php.net comment
function array_key_exists_r($needle, $haystack)
{
    $result = array_key_exists($needle, $haystack);
    if ($result) return $result;
    foreach ($haystack as $v) {
        if (is_array($v)) {
            $result = array_key_exists_r($needle, $v);
        }
        if ($result) return $result;
    }
    return $result;
}

function convert_greek_accents($str) {
        $unwanted_array = array('Ά' => 'Α', 'ά' => 'α', 'Έ' => 'Ε', 'έ' => 'ε', 'Ή' => 'Η', 'ή' => 'η', 'Ί' => 'Ι', 'ί' => 'ι', 'Ό' => 'Ο', 'ό' => 'ο', 'Ύ' => 'Υ', 'ύ' => 'υ', 'Ώ' => 'Ω', 'ώ' => 'ω', 'ϊ' => 'ι','ϋ' => 'υ', 'Ϊ' => 'Ι', 'Ϋ' => 'Υ');
        $str = mb_strtoupper(str_replace(array_keys($unwanted_array), array_values($unwanted_array), $str), 'UTF-8');
        return $str;
    }

?>