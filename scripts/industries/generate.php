<?php
    $values = array();
    $definitions = array();
    
    //https://developer.linkedin.com/docs/reference/industry-codes
    //+
    //http://convertjson.com/html-table-to-json.htm
    $json = file_get_contents("raw.json");
    $rawCurrencies = json_decode($json, true);

    foreach($rawCurrencies as $rawCurrency) {
        $code = intval($rawCurrency['FIELD1']);
        $value = $rawCurrency['FIELD3'];
    
        $values[] = $code;
        $definitions[$code] = $value;
    }
    //Remove duplicates
    $values = array_values(array_unique($values, SORT_STRING));
    
    //https://www.json2yaml.com/
    file_put_contents("values.json", json_encode($values));
    file_put_contents("../../industy_def.json", json_encode($definitions));
?>