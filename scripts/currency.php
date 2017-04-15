<?php
    //Written in PHP because its very easy to prototype in and make quick little scripts like this.
    $currencies = array();
    //http://beautifytools.com/html-to-json-converter.php put the table in there.
    $json = file_get_contents("currency.json");
    $rawCurrencies = json_decode($json, true);
    foreach($rawCurrencies as $rawCurrency) {
        $currencies[] = $rawCurrency['Code'];
    }
    //https://www.json2yaml.com/
    file_put_contents("result.json", json_encode($currencies));
?>