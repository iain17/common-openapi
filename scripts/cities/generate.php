<?php
    ini_set('memory_limit', '-1');
    
    function hash_city($string) {
        $ascii = NULL;
        $length = strlen($string);
        if($length > 10) {
            $length = 10;
        }
        for ($i = 0; $i < $length; $i++) { //strlen($string)
            $ascii += ord($string[$i]); 
        }
        return($ascii);
    }

    $values = array();
    $definitions = array();
    $CountryToCityDefinitions = array();
    
    //Load countries
    $countries_def = json_decode(file_get_contents("../../country_def.json"), true);
    
    //https://www.maxmind.com/en/free-world-cities-database
    $data = file_get_contents("worldcitiespop.txt");
    $rawValues = explode("\n", $data);
    unset($data);

    /*
    [0] => Country
    [1] => City
    [2] => AccentCity
    [3] => Region
    [4] => Population
    [5] => Latitude
    [6] => Longitude
    */
    foreach($rawValues as $rawValue) {
        $data = explode(",", $rawValue);
        if(count($data) != 7) {
            continue;
        }
        $country = strtoupper($data[0]);
        $city = utf8_encode($data[1]);
        
        //If the country does not exist in iso 3166 then ignore this entry
        if(!isset($countries_def[$country])) {
            echo "Ignoring $city in $country\n";
            continue;
        }
        $code = crc32($country.$city);//crc32
        $value = $city;

        if(isset($definitions[$code])) {
            //echo $definitions[$code]."\n";
            //echo("Duplicate detected ($code): $city in $country\n");
            continue;
        }

        $values[] = $code;
        $definitions[$code] = $value;

        if(!isset($CountryToCityDefinitions[$country])) {
            $CountryToCityDefinitions[$country] = array();
        }
        $CountryToCityDefinitions[$country][] = $city;
    }

    //Remove duplicates
    $values = array_values(array_unique($values));
    
    //https://www.json2yaml.com/
    file_put_contents("values.json", json_encode($values));
    file_put_contents("../../cities_def.json", json_encode($definitions));
    file_put_contents("../../country_2_cities_def.json", json_encode($CountryToCityDefinitions));
    die('saved '.count($values));
?>