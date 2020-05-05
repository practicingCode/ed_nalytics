<?php 
    $counter = 0;
    $temporary = array();
    
    if(isset($_POST)){
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

        //HELPERS
        //-------------------------------------------------------            
                    // READ DATE
                    // NOTES:
                    // - Use both $day_sort array and sort_day()function to sort through day
                    // - as read in loop store to array
                    

                        function sort_total($data1, $file_csv){
                            // PREPARING VARS
                            file_put_contents($file_csv, "");
                            $count_total = count($data1);
                            $id = 1;
                            $date_temp = date("d/m/Y");
                            // PREPARING ARRAYS
                            $header = array("id", "Date", "Total");
                            $store_me = array($id, $date_temp, $count_total);
                            // STORING 1
                            $file = fopen($file_csv, "a");
                                fputcsv($file, $store_me);
                                $file = NULL;
                                fclose($file);
                    
                            // STORING 2
                            header_func($file_csv, $header);
                    
                        }
                        
                        
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
                        // print_r($day_sort);
                
                        
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
                    
        //==========================================================================================
        //
        //                          END OF PERIOD HANDLERS
        //==========================================================================================
                    function store($file_name, $entry){
                        global $header;
                        $c_entries = substr_count($entry[2], ",");
                        //------------------
                        // echo"<br>";
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
                        // print_r($entry);
                        $file = fopen($file_name, "a");
                    
                        // if (flock($file, LOCK_EX)){
                            fputcsv($file, $entry);
                            $file = NULL;
                                //PUT PYTHON SCRIPT HERE
                            // flock($file, LOCK_UN);
                        // }
                        fclose($file);

                    }
                //STORING HEADER
                    $header = array("id", "frequency");
                    function header_func($csv, $header){
                        // echo "<h1>$csv</h1>";
                        $text = implode(", ",$header);
                        $strip = str_replace(" ", "", $text);
                        // print_r($header);
                        $top = "sed -i '1 i $strip' $csv";
                        // echo "<h1>$top</h1>";
                        exec($top);
                    }
        //------------------------------------------------------------------------------------------
        //                      END OF HEADER() FUNCTION
        //------------------------------------------------------------------------------------------
        // other helpers
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


        if($path_to == ""){
            //PATH FINDER
                $curr_path = getcwd();
                //Count Slashes
                $slashes = substr_count(strval($curr_path), "/");
                
                $remain = 0;

                function check_string($string, $regex){
                    if (strpos($string, $regex) !== False){
                                return True;
                            }
                            else{
                                return False;
                            }
                        }
                        // Check how many / to salvage
                        if (check_string($curr_path, "/var/www/html")){
                            $remain = 3;
                        }
                        elseif(check_string($curr_path, "/var/www")){
                            $remain = 2;
                        }
                        else{
                            //Default is 3
                            $remain = 3;
                        }
                    //Path to
                    $return = $slashes - $remain;
                    $path_to ="ed_nalytics";
                    for ($i=0; $i<$return; $i++){
                        $path_to = "../".$path_to;
                    }
        }else{

        }
//===========================================================================================================
//   -----------------------------END OF HELPERS-------------------------------------
//===========================================================================================================
        // WRITING STARTS HERE
        $path = $path_to."/tables";
        // echo $path;
        $file = scandir($path);
        //REMOVE ALL NON NUMERICAL, NON RELEVANT FILES
        $files = array_diff($file, array('.', '..','full_join.csv','full_join.csv1', 'ip.csv', 'duration.csv', 'time.csv', 'test.csv'));
        $freq_types = array("day", "week", "month", "quarter", "year", "total");
        
        // print_r($files);
        
           //DEFINING FILE OF CHOICE
        foreach ($files as $data){
            
            foreach($freq_types as $frequency){
                // RESET ARRAY EACH TIME
                $day_sort = array();
                // VARS
                $data = str_replace( ".csv","",$data);
                $aggregate_type = "count (distinct)";
                $frequency = $frequency;
                $name = $data."_".$frequency;
                
                //Table to be read
                $target_table = $path_to."/tables/".$data.".csv";
                //file name to be written
                $file_csv = $path_to."/aggregate/".$name.".csv";
                //GET ID
                file_put_contents($file_csv, "");
                array_push($temporary, $file_csv);
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
                if ($frequency == "total"){
                    // TABLE PATH NOT WRONG
                    $target_table = "../ed_nalytics/tables/browser.csv";
                    $fp = fopen($target_table, 'r');
                    $header_ = fgetcsv($fp);
                    // READ WORKS, sorta
                    $data1 = array();
                        while ($row = fgetcsv($fp)) {
                            global $data1;
                            $arr = array();
                            foreach ($header_ as $i => $col)
                                
                                // Get date & value
                                $temp_date = $row[1]; // this is date
                                $temp_value = $row[2]; // value
                                // echo "date: $temp_date <br>";
                                // echo "value: $temp_value<br>";
                                    
                                // per read
                                $arr[$col] = $row[$i];
                                $data1[] = $arr;
                                
                            }
                        sort_total($data1, $file_csv);
                        break;
                    
                }
                //START OF 2nd FOR LOOP
                //WRITING TABLE TO ARRAY
                // $target_table = "../ed_nalytics/tables/browser.csv";
                // TABLE PATH NOT WRONG
                $fp = fopen($target_table, 'r');
                $header_ = fgetcsv($fp);
                // READ WORKS, sorta
                $data1 = array();
                            while ($row = fgetcsv($fp)) {
                                global $data1;
                                $arr = array();
                                foreach ($header_ as $i => $col)
                                    
                                    // Get date & value
                                    $temp_date = $row[1]; // this is date
                                    $temp_value = $row[2]; // value
                                    // echo "date: $temp_date <br>";
                                    // echo "value: $temp_value<br>";
                                        // DIFFERENTIATE STORAGE METHOD (above)
                                        // STORE DATE && VALUE
                                        $func($temp_date, $temp_value);
                                        // per read
                                    $arr[$col] = $row[$i];
                                    $data1[] = $arr;
                                    
                            }

    //-----------------------------------------------------------------------------
    // RELEASE FOR TESTING
    //----------------------------------------------------------------------------
                    // echo "<br>---------------------------------<br>";
                    // echo "<h1> target header: ";
                    // print_r($header_);
                    // echo "</h1>"; 
                    // echo "from table: $target_table<br>";
                    // echo "to table: $file_csv<br>";
                    // echo "function: $func<br>";
                    // echo "date: $temp_date<br>";
                    // echo "frequency: $frequency<br>";
                    // echo "aggregate type: $aggregate_type<br>";
                    // echo "<br>----------------------------------<br>";
                    // echo "<br>---------------<br>";
                    //     print_r($day_sort);
                    // echo "<br>---------------<br>";
               
                
                // LOOP ARRAY
                $first_keys = array();
                $first_keys = array_keys($day_sort);
                $second_keys = array();
                //CREATING RANGE FOR LOOP
                $count_first_keys = count($first_keys);
                for($i=0; $i<$count_first_keys; $i++){
                    
                    $key_name = $first_keys[$i];
                    $unravelling = $day_sort[$key_name];
                    
                    // print_r($day_sort[$key_name]); //to check if it works
                    $second_keys = array_keys($unravelling);
                    $count_second_keys = count($second_keys);
                    
                    


                    $value = 0;
                    // DISTINCT NEEDS TO BE LISTED A LEVEL ABOVE FOR YEAR
                    // CODE FOR YEAR IS REPEATED FOR OTHERS
                    if($frequency == "year"){
                        // THE CASE FOR YEAR IS DIFFERENT
                        $function = $aggregate_type;
                        
                        switch ($function) {
                            case "count (distinct)":
                                // COUNT DISTINCT FOR YEAR
                                $array = array_count_values($unravelling);
                                $c_array = count($array);
                                $keys = array_keys($array);
                                // echo "keys:".$keys;
                                $temp_var = "";
                                for($i=0; $i<$c_array; $i++){
                                    $z =  $keys[$i].", ".$array[$keys[$i]];
                                    $temp_var .= $z.", ";
                                    // echo $temp_var;
                                }
                                // echo $temp_var;
                                $temp_var = rtrim($temp_var, ", ");
                                $value = $temp_var;
                                // echo $value;
                                // return $count;
                                break;
                            default:
                                break;
                        }

                        $date = "$key2_name/$key_name";
                        $ahhh = array($id, $date, $value);

                        store($file_csv, $ahhh);
                        $id++;
                        // echo "<h1> $value</h1>";
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
                                    // echo "keys:".$keys;
                                    $temp_var = "";
                                    for($i=0; $i<$c_array; $i++){
                                        $z =  $keys[$i].", ".$array[$keys[$i]];
                                        $temp_var .= $z.", ";
                                        // echo $temp_var;
                                    }
                                    // echo $temp_var;
                                    $temp_var = rtrim($temp_var, ", ");
                                    $value = $temp_var;
                                    // echo $value;
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
                            // echo $g;
                            }
                            header_func($file_csv, $header);
                        }
                    }
                    
            }    
            // END OF FINAL FOR LOOP
        }
        // print_r($temporary);
    }
    
?>