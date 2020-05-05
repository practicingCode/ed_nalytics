<?php
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
        //   $new_date = "2020/1/30";
        //   $year = date("Y");
        //   $difference = dateDifference($new_date,$year."/1/1");
        //   echo $difference;
               
function store_rules($file_name, $entry){
    echo json_encode($entry);
    // OVERVIEW:
    //  $entry = [id.add, path+name.add, table_name, table_type, table_colour, descriptor , path1, val1..... path11, val11]
    //  path/file_name.csv 
    global $path_to;
    $path_to_file = "/view/".$entry[1]."_".$entry[0].".csv";
    $path_to_rules = $path_to."/stored_rules/rules.csv";
    $check_for = $path_to_file;
    // CHECK IF FILE NAME EXIST
    $dun_log = 0;
        if (($check_me = fopen($path_to_rules, "r")) !== FALSE) {
            while (($data = fgetcsv($check_me, 1000, ",")) !== FALSE) {
            if ($data[1] == $check_for){
                 $dun_log = 1;
            break;
                }else{

                }
            }
            fclose($check_me);
        }else{echo "failed to send";}
    if($dun_log != 1){
        //if not present log
        array_unshift($entry, $path_to_file);
         // READ &
        $start_from = 1;
        $rows = file($file_name);
        $last_row = array_pop($rows);
        $data = str_getcsv($last_row);
        if ($data != null){
            if ($start_from <= $data){
                //  Get last num
                $start_from = $data[0] + 1;
            }
        }
        
        //  include ID    
        array_unshift($entry, $start_from);

        // Append from last num
        $file = fopen($file_name, "a");

        if (flock($file, LOCK_EX)){
            fputcsv($file, $entry);
            $file = NULL;
            flock($file, LOCK_UN);
        }
        fclose($file);
    }else{
        echo "file already present";
    }
}
            
function submit_entry($file_name, $entry){
    $file = fopen($file_name, "a");

    if (flock($file, LOCK_EX)){
        fputcsv($file, $entry);
        $file = NULL;
        flock($file, LOCK_UN);
    }
    fclose($file);
}

function search_value($file_name, $pointer, $date){
    // Read
    $csv = array_map('str_getcsv', file($file_name));
    // GETTING KEYS
    $keys = $csv[0];
    // GETTING COUNT
    $count = count($csv[0]);
    if(in_array($pointer,$keys)){
        //finding pointer in keys
        for ($i=0; $i<$count; $i++){
            if($keys[$i] == $pointer){
                // echo "match found";
                $pointer_num = $i;
            }
        }
    }
    //-----------------------------------------------------
    // GET RELEVANT ENTRIES
        $csv_count = count($csv);
        // echo $csv_count;
        $header = $csv[0][$pointer_num];
        // echo $header."   Date\n";
        for($i=1; $i<$csv_count; $i++){
            $curr_entry = $csv[$i];
            if($curr_entry[1] == $date){
                $value = $curr_entry[$pointer_num];
                return $value;
            }
        }
}
  //TEST search_value
    // $fn = "../aggregate/browser_day.csv";
    // $p = "Chrome";
    // $date = "d79/y2020";
    // echo search_value($fn, $p, $date);

if($_POST){
    $array = [];
    $chart_type = $_POST["chart_type"];
    $chart_name =  $_POST["chart_name"];
    $chart_colour = $_POST["chart_colour"];
    $chart_desc = $_POST["chart_desc"];
    $chart_where = 1;
    // echo $chart_desc;
    // THIS THE ARRAY FOR RULES
    //  - CURRENT SPLICE REMOVED 2
    //  - CURRENTLY ADDED 1
    array_push($array, $chart_name, $chart_type, $chart_colour, $chart_where, $chart_desc);
    $count = count($_POST);
    
    for($i=0; $i<$count; $i+=2){
        $counter = $i+1;
        
        //target_names
        if($i == 0){
            $data_name = "data1";
            $pointer_name = "drop2";

            $path_name = $path_to."/aggregate/".$_POST[$data_name];
            $pointer = $_POST[$pointer_name];
            array_push($array, $path_name, $pointer);
            // echo $path_name. "  ".$pointer."<br>";
        }else{
            $a = $i/2+1;
            $b = $a+1;
            $data_name = "data".$a;
            $pointer_name = "drop".$b;
            if($_POST[$data_name] != ""){
                $path_name = $path_to."/aggregate/".$_POST[$data_name];
                $pointer = $_POST[$pointer_name];
                array_push($array, $path_name, $pointer);
                // echo $path_name. "  ".$pointer."<br>";
            }
        }
        
    }
    // store in array
        // echo json_encode($array);
    
    // store in rules
    store_rules($path_to."/stored_rules/rules.csv", $array);
    // create view
    // PATH
    $file_name = $chart_type."_".$chart_name.".csv";
    $full_file_name = $path_to."/view/".$file_name;
    //Wiping file
    file_put_contents($full_file_name, "");
//==============================================================================================================
//                          BAR CHART
//==============================================================================================================
if($chart_type == "Bar_Chart"){
    // Adding headers
    $headers = ["Country", "Value","Frequency"];
    submit_entry($full_file_name, $headers);
    // PREPARE ARRAY
    \array_splice($array, 0, 5);
    $count_array = count($array);
    // echo ($count_array);
    // echo json_encode($full_file_name);
    // Write to View
        // Read origin files
        for($x=0; $x<$count_array; $x+=2){
            // echo "<br>".$x."<br>";
            if($x == 0){
                //if zero
                $file_name = $array[0];
                $pointer = $array[1];
                $pointer_num = 0;
                    //READ
                    $csv = array_map('str_getcsv', file($file_name));
                    // GETTING KEYS
                    $keys = $csv[0];
                    // GETTING COUNT
                    $count = count($csv[0]);
                    if(in_array($pointer,$keys)){
                        //finding pointer in keys
                        for ($i=0; $i<$count; $i++){
                            if($keys[$i] == $pointer){
                                // echo "match found";
                                $pointer_num = $i;
                            }
                        }
                    }
                //-----------------------------------------------------
                // GET RELEVANT ENTRIES
                    $csv_count = count($csv);
                    // echo $csv_count;
                    $header = $csv[0][$pointer_num];
                    // echo $header."   Date\n";
                    for($i=1; $i<$csv_count; $i++){
                        $curr_entry = $csv[$i];
                        if($curr_entry[$pointer_num] != FALSE){
                            $value = $curr_entry[$pointer_num];
                            $date = $curr_entry[1];

                            $store_me = [$header, $value, $date];
                            // WRITE TO TARGET FILE
                            submit_entry($full_file_name, $store_me);
                        }
                    }
                //----------------------------------------------
                
            }else{
                // FIRST WORKS SECOND DOESNT
                
                $j = $x +1;
                $file_name = $array[$x];
                $pointer = $array[$j];
                    // echo "file name: $file_name pointer: $pointer";
                //READ
                $csv = array_map('str_getcsv', file($file_name));
                // GETTING KEYS
                $keys = $csv[0];
                // GETTING COUNT
                $count = count($csv[0]);
                    // echo $count;
                if(in_array($pointer,$keys)){
                    //finding pointer in keys
                    for ($i=0; $i<$count; $i++){
                        if($keys[$i] == $pointer){
                            // echo "match found";
                            $pointer_num = $i;
                        }
                    }
                }
                 //-----------------------------------------------------
            // GET RELEVANT ENTRIES
                $csv_count = count($csv);
                // echo $csv_count;
                $header = $csv[0][$pointer_num];
                // echo $header."   Date\n";
                for($i=1; $i<$csv_count; $i++){
                    $curr_entry = $csv[$i];
                    if($curr_entry[$pointer_num] != FALSE){
                        $value = $curr_entry[$pointer_num];
                        $date = $curr_entry[1];
                        
                        $store_me = [$header, $value, $date];
                        // WRITE TO TARGET FILE
                        submit_entry($full_file_name, $store_me);
                    }
                }   
            }
        }
    }
//=================================================================================================================
//                          LINE CHART
//=================================================================================================================
else if($chart_type == "Line_Chart"){
    // Adding headers
        $headers = ["time","Date"];
        $count_line = 1;
        // $headers = ["Date"]; //ORIGINAL
        // PREPARE ARRAY
        \array_splice($array, 0, 5);
        $count_array = count($array);
        // Getting headers
        for($x=0; $x<$count_array; $x++){
            //all odd go in
            if($x%2 != 0){
                //odd
                if ($array[$x] == NULL){
                    
                }else{
                    array_push($headers, $array[$x]);
                }
            }
        }
        // echo json_encode($header);
        submit_entry($full_file_name, $headers);
    
    // Write to View
        // Read origin files
        for($x=0; $x<$count_array; $x+=2){
            // echo "<br>".$x."<br>";
            if($x == 0){
                //if zero
                $file_name = $array[0];
                $pointer = $array[1];
                $pointer_num = 0; 
                // START AND END DATES 
                
                $curr_year = date("Y");
                $curr_d = date("d");
                $curr_m = date("m"); 
                $curr_q = intval(intval($curr_m)/3);
                $curr_date = strval("$curr_year/$curr_m/$curr_d");
                //FIND BY
                $freq = ["day", "week", "month", "quarter", "year"];
                $find_by = "found";
                    for ($f=0; $f<4; $f++){
                        
                        $find_by = $freq[$f];
                        $string = $array[0];
                        global $find_by;
                        $pos = strpos($string, $find_by);
                        if ( $pos === true){
                            $find_by = $find_by;
                        
                        } else{
                            break;
                        }
                    }
                // STORE BY
                if($find_by == "day"){
                    $d = 1;
                    $end_d = dateDifference($curr_date, "2020/1/1");
                    $end_y = $curr_year;
                    if ($end_y > 2020){
                        for($y=2020; $y<$end_y; $y++){
                            for($d=1; $d<=$end_d; $d++){
                                $date = "d$d/y$y";
                                //Get file_name & pointer
                                $file_name = "";  
                                $pointer = "";
                                $csv_entry = [$count_line, $date];

                                //FILENAME
                                for($x=0; $x<$count_array-1; $x++){
                                    //all EVEN go in
                                    if($x%2 == 0){
                                        $point_num =  $x +1;
                                        //even
                                        if ($array[$x] == NULL){}else{
                                            //File name
                                            $file_name = $array[$x];
                                            $pointer = $array[$point_num];
                                            
                                            $value =  search_value($file_name, $pointer, $date);
                                            if($x != 0){
                                                // AFTER FIRST 
                                                if($value != null){
                                                    
                                                    // NOT NULL
                                                    if($csv_entry[2] == null){
                                                        //others null
                                                        for($temp=$x; $temp>0; $temp-=2){
                                                            //Reverse loop
                                                            //insert blanks
                                                            array_push($csv_entry, "0");
                                                            
                                                        }
                                                    }
                                                    // Push in entry at end
                                                    array_push($csv_entry, $value);
                                                    
                                                } elseif($csv_entry[2] != null){
                                                    //FOR entries after 
                                                    array_push($csv_entry, "0");
                                                    
                                                }
                                            }
                                            elseif($x == 0){
                                                // FOR FIRST ENTRY IF TRUE
                                                if($value != null){
                                                    array_push($csv_entry, $value);
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                    //END OF PATH LOOP
                                }
                                //LAST OF DAY LOOP
                                if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                    // echo json_encode($csv_entry);
                                    // WRITE VIEW
                                    submit_entry($full_file_name, $csv_entry); 
                                    $count_line ++;
                                }
                            }
                        }
                    }else{
                        //just this year
                        for($d=1; $d<=$end_d; $d++){
                            // SEARCH ALL DATES BY DAY AND RETURN VALUES FOR THIS YEAR
                            // echo "same year";
                            $date = "d$d/y2020";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                }
                                //END OF PATH LOOP
                            }
                            //LAST OF DAY LOOP
                            if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                // echo json_encode($csv_entry);
                                // WRITE VIEW
                                submit_entry($full_file_name, $csv_entry); 
                                $count_line ++;
                            }
                        }
                        
                        
                        echo "\n===========ENTRY ENTERED=============\n";
                    }
                    

                }
                else if($find_by == "week"){
                    $d = 1;
                    $end_d = dateDifference($curr_date, "2020/1/1");
                    $end_y = $curr_year;
                    if ($end_y > 2020){
                        for($y=2020; $y<$end_y; $y++){
                            for($d=1; $d<=$end_d; $d++){
                                $date = "w$d/y$y";
                                //Get file_name & pointer
                                $file_name = "";  
                                $pointer = "";
                                $csv_entry = [$count_line, $date];

                                //FILENAME
                                for($x=0; $x<$count_array-1; $x++){
                                    //all EVEN go in
                                    if($x%2 == 0){
                                        $point_num =  $x +1;
                                        //even
                                        if ($array[$x] == NULL){}else{
                                            //File name
                                            $file_name = $array[$x];
                                            $pointer = $array[$point_num];
                                            
                                            $value =  search_value($file_name, $pointer, $date);
                                            if($x != 0){
                                                // AFTER FIRST 
                                                if($value != null){
                                                    
                                                    // NOT NULL
                                                    if($csv_entry[2] == null){
                                                        //others null
                                                        for($temp=$x; $temp>0; $temp-=2){
                                                            //Reverse loop
                                                            //insert blanks
                                                            array_push($csv_entry, "0");
                                                            
                                                        }
                                                    }
                                                    // Push in entry at end
                                                    array_push($csv_entry, $value);
                                                    
                                                } elseif($csv_entry[2] != null){
                                                    //FOR entries after 
                                                    array_push($csv_entry, "0");
                                                    
                                                }
                                            }
                                            elseif($x == 0){
                                                // FOR FIRST ENTRY IF TRUE
                                                if($value != null){
                                                    array_push($csv_entry, $value);
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                    //END OF PATH LOOP
                                }
                                //LAST OF DAY LOOP
                                if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                    // echo json_encode($csv_entry);
                                    // WRITE VIEW
                                    submit_entry($full_file_name, $csv_entry); 
                                    $count_line ++;
                                }
                            }
                        }
                    }else{
                        //just this year
                        for($d=1; $d<=$end_d; $d++){
                            // SEARCH ALL DATES BY DAY AND RETURN VALUES FOR THIS YEAR
                            // echo "same year";
                            $date = "w$d/y2020";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                }
                                //END OF PATH LOOP
                            }
                            //LAST OF DAY LOOP
                            if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                // echo json_encode($csv_entry);
                                // WRITE VIEW
                                submit_entry($full_file_name, $csv_entry); 
                                $count_line ++;
                            }
                        }
                        
                        
                        echo "\n===========ENTRY ENTERED=============\n";
                    }
                    
                }
                else if($find_by == "month"){
                    $d = 1;
                    $end_d = dateDifference($curr_date, "2020/1/1");
                    $end_y = $curr_year;
                    if ($end_y > 2020){
                        for($y=2020; $y<$end_y; $y++){
                            for($d=1; $d<=$end_d; $d++){
                                $date = "m$d/y$y";
                                //Get file_name & pointer
                                $file_name = "";  
                                $pointer = "";
                                $csv_entry = [$count_line, $date];

                                //FILENAME
                                for($x=0; $x<$count_array-1; $x++){
                                    //all EVEN go in
                                    if($x%2 == 0){
                                        $point_num =  $x +1;
                                        //even
                                        if ($array[$x] == NULL){}else{
                                            //File name
                                            $file_name = $array[$x];
                                            $pointer = $array[$point_num];
                                            
                                            $value =  search_value($file_name, $pointer, $date);
                                            if($x != 0){
                                                // AFTER FIRST 
                                                if($value != null){
                                                    
                                                    // NOT NULL
                                                    if($csv_entry[2] == null){
                                                        //others null
                                                        for($temp=$x; $temp>0; $temp-=2){
                                                            //Reverse loop
                                                            //insert blanks
                                                            array_push($csv_entry, "0");
                                                            
                                                        }
                                                    }
                                                    // Push in entry at end
                                                    array_push($csv_entry, $value);
                                                    
                                                } elseif($csv_entry[2] != null){
                                                    //FOR entries after 
                                                    array_push($csv_entry, "0");
                                                    
                                                }
                                            }
                                            elseif($x == 0){
                                                // FOR FIRST ENTRY IF TRUE
                                                if($value != null){
                                                    array_push($csv_entry, $value);
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                    //END OF PATH LOOP
                                }
                                //LAST OF DAY LOOP
                                if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                    // echo json_encode($csv_entry);
                                    // WRITE VIEW
                                    submit_entry($full_file_name, $csv_entry); 
                                    $count_line ++;
                                }
                            }
                        }
                    }else{
                        //just this year
                        for($d=1; $d<=$end_d; $d++){
                            // SEARCH ALL DATES BY DAY AND RETURN VALUES FOR THIS YEAR
                            // echo "same year";
                            $date = "m$d/y2020";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                }
                                //END OF PATH LOOP
                            }
                            //LAST OF DAY LOOP
                            if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                // echo json_encode($csv_entry);
                                // WRITE VIEW
                                submit_entry($full_file_name, $csv_entry); 
                                $count_line ++;
                            }
                        }
                        
                        
                        echo "\n===========ENTRY ENTERED=============\n";
                    }
                    
                }
                else if($find_by == "quarter"){
                    $d = 1;
                    $end_d = dateDifference($curr_date, "2020/1/1");
                    $end_y = $curr_year;
                    if ($end_y > 2020){
                        for($y=2020; $y<$end_y; $y++){
                            for($d=1; $d<=$end_d; $d++){
                                $date = "q$d/y$y";
                                //Get file_name & pointer
                                $file_name = "";  
                                $pointer = "";
                                $csv_entry = [$count_line, $date];

                                //FILENAME
                                for($x=0; $x<$count_array-1; $x++){
                                    //all EVEN go in
                                    if($x%2 == 0){
                                        $point_num =  $x +1;
                                        //even
                                        if ($array[$x] == NULL){}else{
                                            //File name
                                            $file_name = $array[$x];
                                            $pointer = $array[$point_num];
                                            
                                            $value =  search_value($file_name, $pointer, $date);
                                            if($x != 0){
                                                // AFTER FIRST 
                                                if($value != null){
                                                    
                                                    // NOT NULL
                                                    if($csv_entry[2] == null){
                                                        //others null
                                                        for($temp=$x; $temp>0; $temp-=2){
                                                            //Reverse loop
                                                            //insert blanks
                                                            array_push($csv_entry, "0");
                                                            
                                                        }
                                                    }
                                                    // Push in entry at end
                                                    array_push($csv_entry, $value);
                                                    
                                                } elseif($csv_entry[2] != null){
                                                    //FOR entries after 
                                                    array_push($csv_entry, "0");
                                                    
                                                }
                                            }
                                            elseif($x == 0){
                                                // FOR FIRST ENTRY IF TRUE
                                                if($value != null){
                                                    array_push($csv_entry, $value);
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                    //END OF PATH LOOP
                                }
                                //LAST OF DAY LOOP
                                if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                    // echo json_encode($csv_entry);
                                    // WRITE VIEW
                                    submit_entry($full_file_name, $csv_entry); 
                                    $count_line ++;
                                }
                            }
                        }
                    }else{
                        //just this year
                        for($d=1; $d<=$end_d; $d++){
                            // SEARCH ALL DATES BY DAY AND RETURN VALUES FOR THIS YEAR
                            // echo "same year";
                            $date = "q$d/y2020";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                }
                                //END OF PATH LOOP
                            }
                            //LAST OF DAY LOOP
                            if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                // echo json_encode($csv_entry);
                                // WRITE VIEW
                                submit_entry($full_file_name, $csv_entry); 
                                $count_line ++;
                            }
                        }
                        
                        
                        echo "\n===========ENTRY ENTERED=============\n";
                    }
                    
                }
                else if($find_by == "year"){

                    $end_d = dateDifference($curr_date, "2020/1/1");
                    $end_y = $curr_year;
                    if ($end_y > 2020){
                        for($y=2020; $y<$end_y; $y++){
                            $date = "y$y";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                
                                    //END OF PATH LOOP
                                }
                                //LAST OF DAY LOOP
                                if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                    // echo json_encode($csv_entry);
                                    // WRITE VIEW
                                    submit_entry($full_file_name, $csv_entry); 
                                    $count_line ++;
                                }
                            }
                        }
                    }else{
                        //just this year
                        for($d=1; $d<=$end_d; $d++){
                            // SEARCH ALL DATES BY DAY AND RETURN VALUES FOR THIS YEAR
                            // echo "same year";
                            $date = "y2020";
                            //Get file_name & pointer
                            $file_name = "";  
                            $pointer = "";
                            $csv_entry = [$count_line, $date];

                            //FILENAME
                            for($x=0; $x<$count_array-1; $x++){
                                //all EVEN go in
                                if($x%2 == 0){
                                    $point_num =  $x +1;
                                    //even
                                    if ($array[$x] == NULL){}else{
                                        //File name
                                        $file_name = $array[$x];
                                        $pointer = $array[$point_num];
                                        
                                        $value =  search_value($file_name, $pointer, $date);
                                        if($x != 0){
                                            // AFTER FIRST 
                                            if($value != null){
                                                
                                                // NOT NULL
                                                if($csv_entry[2] == null){
                                                    //others null
                                                    for($temp=$x; $temp>0; $temp-=2){
                                                        //Reverse loop
                                                        //insert blanks
                                                        array_push($csv_entry, "0");
                                                        
                                                    }
                                                }
                                                // Push in entry at end
                                                array_push($csv_entry, $value);
                                                
                                            } elseif($csv_entry[2] != null){
                                                //FOR entries after 
                                                array_push($csv_entry, "0");
                                                
                                            }
                                        }
                                        elseif($x == 0){
                                            // FOR FIRST ENTRY IF TRUE
                                            if($value != null){
                                                array_push($csv_entry, $value);
                                                
                                                
                                            }
                                        }
                                    }
                                }
                                //END OF PATH LOOP
                            }
                            //LAST OF DAY LOOP
                            if ($csv_entry[2] != null || $csv_entry[3] !=null || $csv_entry[4] != null || $csv_entry[5] !=null || $csv_entry[6] != null || $csv_entry[7] != null || $csv_entry[8] !=null || $csv_entry[9] != null || $csv_entry[10] != null || $csv_entry[11] !=null ){
                                // echo json_encode($csv_entry);
                                // WRITE VIEW
                                submit_entry($full_file_name, $csv_entry); 
                                $count_line ++;
                            }
                        }
                        
                        
                        echo "\n===========ENTRY ENTERED=============\n";
                    }
                    
                }
                else{
                    echo "none found";
                }
            }else{
                echo "This many unnecessary<br>";
                $j = $x +1;
                $file_name = $array[$x];
                $pointer = $array[$j];
                    // echo "file name: $file_name pointer: $pointer";
                //READ
                $csv = array_map('str_getcsv', file($file_name));
                // GETTING KEYS
                $keys = $csv[0];
                // GETTING COUNT
                $count = count($csv[0]);
                    // echo $count;
                if(in_array($pointer,$keys)){
                    //finding pointer in keys
                    for ($i=0; $i<$count; $i++){
                        if($keys[$i] == $pointer){
                            // echo "match found";
                            $pointer_num = $i;
                        }
                    }
                }
                 //-----------------------------------------------------
            // GET RELEVANT ENTRIES
                $csv_count = count($csv);
                // echo $csv_count;
                $header = $csv[0][$pointer_num];
                // echo $header."   Date\n";
                for($i=1; $i<$csv_count; $i++){
                    $curr_entry = $csv[$i];
                    if($curr_entry[$pointer_num] != FALSE){
                        $value = $curr_entry[$pointer_num];
                        $date = $curr_entry[1];
                        
                        $store_me = [$header, $value, $date];
                        // WRITE TO TARGET FILE
                        submit_entry($full_file_name, $store_me);
                        $again = ["hi", "it's me", "again"];
                        submit_entry($full_file_name, $again);
                    }
                }   
            }
        }
        //LAST OF LINE CHART
    }
    // END OF LINE 
}
// WRITE UPATER TO UPDATE BY RULES

?>