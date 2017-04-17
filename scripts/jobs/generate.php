<?php
    $values = array();
    $definitions = array();
    
    //https://developer.linkedin.com/docs/reference/job-function-codes
    //+
    //http://convertjson.com/html-table-to-json.htm
    $json = file_get_contents("raw.json");
    $rawValues = json_decode($json, true);

    foreach($rawValues as $rawValue) {
        $code = intval($rawValue['FIELD1']);
        $value = $rawValue['FIELD3'];
    
        $values[] = $code;
        $definitions[$code] = $value;
    }
    //Remove duplicates
    $values = array_values(array_unique($values, SORT_STRING));
    
    //https://www.json2yaml.com/
    file_put_contents("values.json", json_encode($values));
    file_put_contents("../../job_def.json", json_encode($definitions));
?>