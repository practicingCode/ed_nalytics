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
    }else{}

    function write_rules($file_name, $entry){
        // WRITE
        $file = fopen($file_name, "w");
    
        if (flock($file, LOCK_EX)){
            fputcsv($file, $entry);
            $file = NULL;
            flock($file, LOCK_UN);
        }
        fclose($file);
    
    }
    
    function append_rules($file_name, $entry){
         // APPEND
        $file = fopen($file_name, "a");
    
        if (flock($file, LOCK_EX)){
            fputcsv($file, $entry);
            $file = NULL;
            flock($file, LOCK_UN);
        }
        fclose($file);
    }
//==============================================================================================
//              POST REQUEST
//==============================================================================================
    if($_POST){
        // TO DESTROY
        $path = $_POST["path"];
        // RULES PATH
        $file_name = $path_to."/stored_rules/rules.csv";
        //search
            $destroy = 0;
            $count = 1;
            if (($handle = fopen($file_name, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $am_i = $data[1];
                    if ($am_i == $path){
                        echo $am_i."\n";
                        $destroy = $count -1;
                        // echo $destroy;
                    }else{
                    }
                    $count++;
                }
                fclose($handle);
            }
            // echo $destroy;
    //RE WRITING ID
            $csv = array_map('str_getcsv', file($file_name));
            $count--;
            $id = 0;
            $bigger_array =[];
            $array = [];
        //GET HEADERS
            $build_count = count($csv[0])-1;
                for($x=0; $x<$build_count;$x++){
                    $entry = $csv[0][$x];
                    array_push($array, $entry);
                }
            array_push($bigger_array, $array);
            // GET OTHER ROWS
            $destroyed = 0;
            for($i=1; $i<$count; $i++){
                    // By ROW NUM
                    if($destroyed == 1){
                      $id--;
                      $destroyed = 0;
                    }
                        $build_count = count($csv[$i]);
                        // echo $build_count."\n";
                        $id++;
                        $array = [$id];
                        for($rebuild=0; $rebuild<$build_count; $rebuild++){
                            // BY entry NUM
                            if($rebuild == 0){
                              // ID ALREADY LOGGED ABOVE
                            }else{
                              if($i == $destroy){
                                  $destroyed = 1;
                                //if you are ignore
                              }else{
                              // if you aren't add to 
                                
                                $entry = $csv[$i][$rebuild];
                                array_push($array, $entry);
                              }
                            }
                        }
                        
                        // write_rules($file_name, $array);
                        if($i == $destroy){}
                        else{array_push($bigger_array, $array);}
                        
                    }
                
            
            $arr_count = count($bigger_array);
            for($arr=0; $arr<$arr_count; $arr++){
                if($arr == 0){
                    //Add header
                    write_rules($file_name, $bigger_array[$arr]);
                }else{
                    //Add rest
                    append_rules($file_name, $bigger_array[$arr]);
                }
            }
        }
    
?>