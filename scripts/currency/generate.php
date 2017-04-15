<?php
    $values = array();
    $definitions = array();
    
    //http://data.okfn.org/data/core/currency-codes
    $json = file_get_contents("raw.json");
    $rawCurrencies = json_decode($json, true);

    foreach($rawCurrencies as $rawCurrency) {
        //Validation
        if($rawCurrency["WithdrawalDate"] != "") {
            continue;
        }
        if($rawCurrency['AlphabeticCode'] == "") {
            echo "Skipping {$rawCurrency['Entity']} = {$rawCurrency['Currency']}\n";
            continue;
        }

        $code = $rawCurrency['AlphabeticCode'];
        $value = $rawCurrency['Currency'];
    
        $values[] = $code;
        $definitions[$code] = $value;
    }
    //Remove duplicates
    $values = array_values(array_unique($values, SORT_STRING));
    
    //https://www.json2yaml.com/
    file_put_contents("values.json", json_encode($values));
    file_put_contents("values_def.json", json_encode($definitions));
?>