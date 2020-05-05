<?php 
            // 1) STORAGE WORKS
            // 2) AGGREGATION (AVG, COUNT, max, min) DONT WORK
            // 3) NEED TO CHAGE ALL $day_sort, $day_sort etc. to $day_sort();
    if($_POST){
        $name = strtolower($_POST["name"]);
        $data = $_POST["tables"];
        $aggregate_type = strtolower($_POST["aggregate_type"]);
        $frequency = strtolower($_POST["frequency"]);
        //Move pointer to target table
        $target_table = "../tables/".$data.".csv";
        //path and name of new.csv
        $file_csv = "../aggregate/".$name.".csv";
        //GET ID
        file_put_contents($file_csv, "");
        $id = 1;

        $func = "";
        if ($frequency == "day"){
            $func = "sort_day";
        }
        if ($frequency == "month"){
            $func = "sort_month";
        }
        if ($frequency == "week"){
            $func = "sort_week";
        }
        if ($frequency == "quarter"){
            $func = "sort_quarter";
        }
        if ($frequency == "year"){
            $func = "sort_year";
        }
        
        echo "<b>Details: </b><br>";
            echo "name: $name";
            echo "<br>";
            echo "data: $data";
            echo "<br>";
            echo "aggregation: $aggregate_type";
            echo "<br>";
            echo "frequency: $frequency";
            echo "<br>";
            echo "from: $target_table";
            echo "<br>";
            echo "to: $file_csv";
            echo "<br>";
            echo "func: $func";
//-------------------------------------------------------            
            // READ DATE
            // NOTES:
            // - Use both $day_sort array and sort_day()function to sort through day
            // - as read in loop store to array
            
            $day_sort = array();
                function sort_day($date, $value){
                    global $day_sort;
                    //Seperate parts of day to vars
                    $var = preg_split("#/#", $date); 
                    $day = $var[0];
                    $mth = $var[1];
                    $year = $var[2];

                    // reinterpret date for counting
                    $new_date = $year."/".$mth."/".$day;

                    // Sort by year and day
                    $yearname = "y".$year;
                    $difference = dateDifference($new_date,$year."/1/1");
                    $daynum = "d".$difference;
                    
                    if (isset($day_sort[$yearname][$daynum])){
                        //if there is a match
                        // echo "there is a match";
                        array_push($day_sort[$yearname][$daynum], $value);
                        return $day_sort;
                    }
                    else{
                        // if not real create through merge
                        // echo "there isn't a match";
                        
                        $yearname = "y".$year;
                        $difference = dateDifference($new_date,$year."/1/1");
                        $daynum = "d".$difference;
                        
                        $temp_array = array($yearname => [$daynum => [$value]]);
                        $day_sort = array_merge_recursive($day_sort, $temp_array);
                        return $day_sort;
                    }
                }

        
            //TEST CODE
                // print_r($day_sort);
                // echo "<br>-------------------------------<br>";
                // $date = "12/2/2020";
                // $day_sort = sort_day($date, "mozilla");
                // print_r($day_sort);
                // echo "<br>-------------------------------<br>";
                // $date = "12/3/2020";
                // $day_sort = sort_day($date, "chrome");
                // print_r($day_sort);
                // echo "<br>-------------------------------<br>";
            
                

        
            function sort_week($date, $value){
                global $day_sort;
                    //Seperate parts of day to vars
                    $var = preg_split("#/#", $date); 
                    $day = $var[0];
                    $mth = $var[1];
                    $year = $var[2];

                    // reinterpret date for counting
                    $new_date = $year."/".$mth."/".$day;

                    // Sort by year and day
                    $yearname = "y".$year;
                    $difference = dateDifference($new_date,$year."/1/1");
                    $week = 53;
                    $y = -7;
                    
                    for($i=1;$i<$week;$i++){
                        $week_num = "week".$i;
                        $x = $i*7;
                        if ($x == 364){
                            $x++;
                        }
                        $y += 7;
                        // $x $y work
                        if($difference <= $x){
                            // echo $date."<br>";
                            // echo "less than x<br>";
                            if($difference >= $y){
                                // echo "greater than y<br>";
                                if (isset($day_sort[$yearname][$week_num])){
                                    //if there is a match
                                    // echo "there is a match";
                                    array_push($day_sort[$yearname][$week_num], $value);
                                    return $day_sort;
                                }
                                else{
                                    // if not real create through merge
                                    // echo "there isn't a match";
                                    
                                    $yearname = "y".$year;
                                    // echo $yearname;
                                    // echo $week_num;
                                    $temp_array = array($yearname => [$week_num => [$value]]);
                                    $day_sort = array_merge_recursive($day_sort, $temp_array);
                                    // print_r($temp_array);
                                    return $day_sort;
                                }
                            }
                        }
                    }
                }
            
                    // SAMPLE SORT WEEK
                // $date = "31/12/2020";
                // echo "<br>----------------------<br>";
                // $day_sort = sort_week($date, "nonsense");
                // $date = "22/2/2020";
                // echo "<br>----------------------<br>";
                // $day_sort = sort_week($date, "12*10^8");
                // print_r($day_sort);
                // $date = "31/8/2020";
                // echo "<br>----------------------<br>";
                // $day_sort = sort_week($date, "12*10^8");
                // print_r($day_sort);

        
            function sort_month($date, $value){
                global $day_sort;
                    //Seperate parts of day to vars
                    $var = preg_split("#/#", $date); 
                    $day = $var[0];
                    $mth = $var[1];
                    $year = $var[2];

                    // Sort by year and day
                    $yearname = "y".$year;
                    $month = "m".$mth;

                //SORTING STARTS HERE
                if (isset($day_sort[$yearname][$month])){
                    //if there is a match
                    // echo "there is a match";
                    array_push($day_sort[$yearname][$month], $value);
                    return $day_sort;
                }
                else{
                    // if not real create through merge
                    // echo "there isn't a match";
                    
                    $yearname = "y".$year;
                    $month = "m".$mth;
                    
                    $temp_array = array($yearname => [$month => [$value]]);
                    $day_sort = array_merge_recursive($day_sort, $temp_array);
                    return $day_sort;
                }
            }

            // // TEST MONTH SORT
            // $date = "1/1/2020";
            // $day_sort = sort_month($date, "ubuntu");
            // echo "<br>-----------------------<br>";
            // print_r($day_sort);
            // $date = "31/1/2020";
            // $day_sort = sort_month($date, "macintosh");
            // echo "<br>-----------------------<br>";
            // print_r($day_sort);
            // $date = "22/2/2020";
            // $day_sort = sort_month($date, "ubuntu");
            // echo "<br>-----------------------<br>";
            // print_r($day_sort);
            // echo "<br>-----------------------<br>";
            // print_r($day_sort['y2020']['m1']);

            function sort_quarter($date, $value){
                global $day_sort;
                    //Seperate parts of day to vars
                    $var = preg_split("#/#", $date); 
                    $day = $var[0];
                    $mth = $var[1];
                    $year = $var[2];
                    $quarter = 0;
                    if($mth == 1 || $mth == 2 || $mth == 3){
                        $quarter = "q1";
                    }
                    elseif($mth == 4 || $mth == 5 || $mth == 6){
                        $quarter = "q2";
                    }
                    elseif($mth == 7 || $mth == 8 || $mth == 9){
                        $quarter = "q3";
                    }
                    elseif($mth == 10 || $mth == 11 || $mth == 12){
                        $quarter = "q4";
                    }
                    // Sort by year and day
                    $yearname = "y".$year;
                        // FOR TESTING PURPOSES
                    // echo "<br>--------<br>".$date;
                    // echo "<br>[".$quarter."][".$year."]";

                //SORTING STARTS HERE
                if (isset($day_sort[$yearname][$quarter])){
                    //if there is a match
                    // echo "there is a match";
                    array_push($day_sort[$yearname][$quarter], $value);
                    return $day_sort;
                }
                else{
                    // if not real create through merge
                    // echo "there isn't a match";
                    
                    $yearname = "y".$year;
                    
                    
                    $temp_array = array($yearname => [$quarter => [$value]]);
                    $day_sort = array_merge_recursive($day_sort, $temp_array);
                    return $day_sort;
                }
            }

            //  // TEST QUARTER SORT
            //  $date = "3/4/2020";
            //  $day_sort = sort_quarter($date, "ubuntu");
            //  echo "<br>-----------------------<br>";
            //      print_r($day_sort);
            //  $date = "31/1/2020";
            //  $day_sort = sort_quarter($date, "macintosh");
            //  echo "<br>-----------------------<br>";
            //      print_r($day_sort);
            //  $date = "22/12/2020";
            //  $day_sort = sort_quarter($date, "ubuntu");
            //  echo "<br>-----------------------<br>";
            //      print_r($day_sort);
            //  echo "<br>-----------------------<br>";
            //      print_r($day_sort['y2020']['q1']);


            $day_sort = array();
            function sort_year($date, $value){
                global $day_sort;
                    //Seperate parts of day to vars
                    $var = preg_split("#/#", $date); 
                    $year = $var[2];
                    $yearname = "y".$year;
                        // FOR TESTING PURPOSES
                    // echo "<br>--------<br>".$date;
                    // echo "<br>[".$year."]";

                //SORTING STARTS HERE
                if (isset($day_sort[$yearname])){
                    //if there is a match
                    // echo "there is a match";
                    array_push($day_sort[$yearname], $value);
                    return $day_sort;
                }
                else{
                    // if not real create through merge
                    // echo "there isn't a match";
                    
                    $yearname = "y".$year;
                    
                    $temp_array = array($yearname => [$value]);
                    $day_sort = array_merge_recursive($day_sort, $temp_array);
                    return $day_sort;
                }
            }

            // TEST QUARTER SORT
            // $date = "3/4/2020";
            // $day_sort = sort_year($date, "ubuntu 18.04");
            // echo "<br>-----------------------<br>";
            //     print_r($day_sort);
            // $date = "31/1/2020";
            // $day_sort = sort_year($date, "macintosh");
            // echo "<br>-----------------------<br>";
            //     print_r($day_sort);
            // $date = "22/12/2021";
            // $day_sort = sort_year($date, "ubuntu");
            // echo "<br>-----------------------<br>";
            //     print_r($day_sort);
            // echo "<br>-----------------------<br>";
            //     print_r($day_sort['y2020']);
//==========================================================================================
            

        // THINGS TO DO:
        //      - RENAME FILE FOR EASIER LOCATION ???
        //      - WRITE A DELETE for aggregates
        //      - ADD AGGREGATES TO load for tables
        //      - Write way to view AGGREGATES
        //      - REMOVE non-working aggregates
        //      - WRITE DELETE FOR AGGREGATES
        //      - WRITE WAY TO CHECK IF AGGREGATES EMPTY
        //      - START VISUALIZATION, AGGREGATES inconsistency can be trimmed after this (views)
        //      - IF NOTHING GOES WRONG write SEO TOOLS
        //      - ADD DATA TYPES
        //      - TEST DATA TYPES WITH AGGREGATION



//==========================================================================================
            function store($file_name, $entry){
                global $header;
                $c_entries = substr_count($entry[2], ",");
                //------------------
                echo"<br>";
                //SPLIT TO CREATE ARRAY
                $split = explode(", ", $entry[2]);
                $num = count($split);
                $i = 0;
                for($i=0; $i < $num; $i++){
                    if($i == 0){
                        //ALSO EVEN
                        $z = $i+3;
                        if(!in_array($split[$i], $header)){
                            $header[$z] = $split[$i];
                        }else{
                            
                        }
                        
                        //REMOVE FROM ENTRY
                        $find = $split[$i].", ";
                        $entry[2] = str_replace($find, "", $entry[2]);
                        
                    }  
                    elseif($i%2 == 0){
                        // even
                        $x = $i;
                        $z = $i;
                        if(!in_array($split[$i], $header)){
                            $header[$z] = $split[$x];
                        }else{
                            
                        }
                        $find = $split[$i].", ";
                        $entry[2] = str_replace($find, "", $entry[2]);
                    }
                }
                
                
            
                $entry[2] = explode(", ", $entry[2]);
                $c_entry = count($entry[2]);
                $temp = $entry[2];
                for($i=0; $i<$c_entry; $i++){
                    $z = $i+2;
                    $entry[$z] = $temp[$i];
                }
                print_r($entry);
                $file = fopen($file_name, "a");
            
                // if (flock($file, LOCK_EX)){
                    fputcsv($file, $entry);
                    $file = NULL;
                        //PUT PYTHON SCRIPT HERE
                    // flock($file, LOCK_UN);
                // }
                fclose($file);
                echo "<br>--------------------------<br>";
                echo"header";
                print_r($header);
            }
            //STORING HEADER
            $header = array("id", "frequency");
//----------------------------------------------------------------------------------------
            function header_func($csv, $header){
                echo "<h1>$csv</h1>";
                $text = implode(", ",$header);
                print_r($header);
                $top = "sed -i '1 i $text' $csv";
                echo "<h1>$top</h1>";
                exec($top);
            }
//------------------------------------------------------------------------------------------
//                      END OF HEADER() FUNCTION
//------------------------------------------------------------------------------------------
            $fp = fopen($target_table, 'r');
            $header_ = fgetcsv($fp);
             
            $data1 = array();
            while ($row = fgetcsv($fp)) {
                $arr = array();
                foreach ($header_ as $i => $col)
                    // Get date & value
                    $temp_date = $row[1]; // this is date
                    $temp_value = $row[2]; // value
                        // DIFFERENTIATE STORAGE METHOD (above)
                        // STORE DATE && VALUE
                        $func($temp_date, $temp_value);
                        // per read
                    $arr[$col] = $row[$i];
                    $data1[] = $arr;
    
            }
            echo "<br>---------------<br>";
            print_r($data1);
            echo "<br>---------------<br>";
            // LOOP ARRAY
            $first_keys = array();
            $first_keys = array_keys($day_sort);
            $second_keys = array();
            //CREATING RANGE FOR LOOP
            $count_first_keys = count($first_keys);
            for($i=0; $i<$count_first_keys; $i++){
                
                $key_name = $first_keys[$i];
                $unravelling = $day_sort[$key_name];
                echo "origin<br>";
                // print_r($day_sort[$key_name]); //to check if it works
                $second_keys = array_keys($unravelling);
                $count_second_keys = count($second_keys);
                
                


                $value = 0;
                // DISTINCT NEEDS TO BE LISTED A LEVEL ABOVE
                // if($aggregate_type == "count (distinct)" && $frequency != "year"){
                    // $value = count($unravelling);

                    // COUNT DISTINCT FOR YEAR
                            // $array = array_count_values($unravelling);
                            // $c_array = count($array);
                            // $keys = array_keys($array);
                            // echo "keys:".$keys;
                            // $temp_var = "";
                            // for($i=0; $i<$c_array; $i++){
                            //     $z =  $keys[$i].", ".$array[$keys[$i]];
                            //     $temp_var .= $z.", ";
                            //     echo $temp_var;
                            // }
                            // echo $temp_var;
                            // $temp_var = rtrim($temp_var, ", ");
                            // $value = $temp_var;
                            // echo $value;
                // }  
                if($frequency == "year"){
                    // THE CASE FOR YEAR IS DIFFERENT
                    $function = $aggregate_type;
                    
                    switch ($function) {
                        case sum:
                            $value = count($unravelling);
                            break;
                        case average:
                            $value = array_sum($unravelling)/count($unravelling);
                            // return $average;
                            break;
                        case minimum:
                            $value = min($unravelling);
                            // return $min;
                            break;
                        case maximum:
                            $value = max($unravelling);
                            // return $max;
                            break;
                        
                        case "count (distinct)":
                            // COUNT DISTINCT FOR YEAR
                            $array = array_count_values($unravelling);
                            $c_array = count($array);
                            $keys = array_keys($array);
                            echo "keys:".$keys;
                            $temp_var = "";
                            for($i=0; $i<$c_array; $i++){
                                $z =  $keys[$i].", ".$array[$keys[$i]];
                                $temp_var .= $z.", ";
                                echo $temp_var;
                            }
                            echo $temp_var;
                            $temp_var = rtrim($temp_var, ", ");
                            $value = $temp_var;
                            echo $value;
                            // return $count;
                            break;
                        default:
                            break;
                    }

                    $date = "$key2_name/$key_name";
                    $ahhh = array($id, $date, $value);

                    store($file_csv, $ahhh);
                    $id++;
                    echo "<h1> $value</h1>";
                    header_func($file_csv, $header);
                }
                else{
                    for($g=0; $g<$count_second_keys;$g++){
                        $key2_name = $second_keys[$g];
                        $unravelled = $day_sort[$key_name][$key2_name];
                        $function = $aggregate_type;
                        

                        switch ($function) {
                            case "count (distinct)":
                                // $value = count($unravelled);
                                // COUNT DISTINCT FOR YEAR
                                $array = array_count_values($unravelled);
                                $c_array = count($array);
                                $keys = array_keys($array);
                                echo "keys:".$keys;
                                $temp_var = "";
                                for($i=0; $i<$c_array; $i++){
                                    $z =  $keys[$i].", ".$array[$keys[$i]];
                                    $temp_var .= $z.", ";
                                    echo $temp_var;
                                }
                                echo $temp_var;
                                $temp_var = rtrim($temp_var, ", ");
                                $value = $temp_var;
                                echo $value;


                                break;
                            case sum:
                                $value = array_sum($unravelled);
                                // return $sum;
                                break;
                            case average:
                                $value = array_sum($unravelled)/count($unravelled);
                                // return $average;
                                break;
                            case minimum:
                                $value = min($unravelled);
                                // return $min;
                                break;
                            case maximum:
                                $value = max($unravelled);
                                // return $max;
                                break;
                            default:
                                break;
                        }

                        $date = "$key2_name/$key_name";
                        $ahhh = array($id, $date, $value);
//-------------------------------AGGREGATION DONE-----------------------------------------
//----------------------------------APPEND CSV--------------------------------------------

                        store($file_csv, $ahhh);
                        $id++;
                        echo $g;
                        }
                        header_func($file_csv, $header);
                    }
               }
//========================================================================================
//-------------------------------------RULES----------------------------------------------
//========================================================================================
               $out = [$name, $data, $aggregate_type, $frequency, $target_table];
               
               function store_rules($file_name, $entry){
                   $file = fopen($file_name, "a");
       
                   if (flock($file, LOCK_EX)){
                       fputcsv($file, $entry);
                       $file = NULL;
                           //PUT PYTHON SCRIPT HERE
                       flock($file, LOCK_UN);
                   }
                   fclose($file);
               }
               
               store_rules("../stored_rules/rules.csv", $out);
            }
        // }
        
            // loop through array and apply function
            function test($array, $frequency){
                $count = 5;
                if ($frequency == "day"){
                    $func = "sort_day";
                }
                if ($frequency == "month"){
                    $func = "sort_month";
                }
                if ($frequency == "week"){
                    $func = "sort_week";
                }
                if ($frequency == "quarter"){
                    $func = "sort_quarter";
                }
                if ($frequency == "year"){
                    $func = "sort_year";
                }

                for($i=0; $i<=$count; $i++){
                    $d = rand(1,28);
                    $m = rand(1,12);
                    $y = rand(1996,2000);

                    $countries = array("Switzerland", "England", "America", "Spain", "Indonesia", "Singapore", "China", "Russia", "Israel", "Japan", "Korea");
                    $end = count($countries);
                    $end = $end-1;


                    $end = 3;
                    $country = $countries[rand(0,$end)];
                    // $ip1 = rand(0,255);
                    // $ip2 = rand(0,255);
                    // $ip3 = rand(0,255);
                    // $ip4 = rand(0,255);

                    // $ip = "$ip1.$ip2.$ip3.$ip4";
                    $date = "$d/$m/$y";
                    $array = $func($date, $country); // did you know you can write arrays like this?

                }
                // echo "<br>";
                // print_r($array);
                return $array;
            }
            function cmp($a, $b){   
                $counta = strlen($a);
                $countb = strlen($b);
                
                if ($a == $b) {
                    return 0;
                }
                elseif($counta == $countb){
                    return ($a < $b) ? -1 : 1;
                }else{
                if($counta > $countb){
                    return 1;
                    }
                }
            }

    
//======================================FOR TESTING================================================
            // GENERATE
            // // $day_sort = test($day_sort, "day");
            // // READS WHAT WAS SORTED
            // $period = "month";
            // $aggregate = "count(distinct)";
            // $name = "abc";
            
//--------------------------------------------------------------------------------------
// HELPER TO GET DATE DIFFERENCE

            function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
                $datetime1 = date_create($date_1);
                $datetime2 = date_create($date_2);
            
                $interval = date_diff($datetime1, $datetime2);
            
                $x = $interval->format($differenceFormat);
                $x = $x +1;
                    if($x == 366){
                        $x--;
                    }
                return $x;
            }
            // $difference = dateDifference($new_date,$year."/1/1");
            

?>