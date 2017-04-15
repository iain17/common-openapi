<?php
    //Written in PHP because its very easy to prototype in and make quick little scripts like this.
    $currencies = array();
    //http://data.okfn.org/data/core/currency-codes
    $json = file_get_contents("currency.json");
    $rawCurrencies = json_decode($json, true);
    foreach($rawCurrencies as $rawCurrency) {
        if($rawCurrency["WithdrawalDate"] != "") {
            continue;
        }
        if($rawCurrency['AlphabeticCode'] == "") {
            echo "Skipping {$rawCurrency['Entity']} = {$rawCurrency['Currency']}\n";
            continue;
        }
        $currencies[] = $rawCurrency['AlphabeticCode'];
    }
    //Remove duplicates
    $currencies = array_values(array_unique($currencies, SORT_STRING));
    
    //https://www.json2yaml.com/
    file_put_contents("result.json", json_encode($currencies));
?>