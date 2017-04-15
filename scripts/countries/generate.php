<?php
    $values = array();
    $definitions = array();

    //https://raw.githubusercontent.com/lukes/ISO-3166-Countries-with-Regional-Codes/master/all/all.json
    $json = file_get_contents("raw.json");
    $rawCountries = json_decode($json, true);

    foreach($rawCountries as $rawCountry) {
        $code = $rawCountry['alpha-3'];
        $value = $rawCountry['name'];

        $values[] = $code;
        $definitions[$code] = $value;
    }

    //Remove duplicates
    $values = array_values(array_unique($values, SORT_STRING));
    
    //https://www.json2yaml.com/
    file_put_contents("values.json", json_encode($values));
    file_put_contents("values_def.json", json_encode($definitions));

?>