<?php 
try{
    function index($file_name){
        // START FROM
        $start_from = 1;
        $rows = file("../tables/time.csv");
        $last_row = array_pop($rows);
        $data = str_getcsv($last_row);
        if ($data != null){
        
        //if less than equal to add
        if ($start_from <= $data){
            $start_from = $data[0] + 1;
        }
    }
        //CREATING COPY
        exec('cp '.$file_name.' '.$file_name.'1');
        echo('temp file auto generated');
        // PREPARING TO WRITE
        $count = 0;
        function readCSV($csvFile){
            $file_handle = fopen($csvFile, 'r');
            while (!feof($file_handle) ) {
                $line_of_text[] = fgetcsv($file_handle, 0);
            }
            
            fclose($file_handle);
            return $line_of_text;
        }
        //PREPARING TO STORE
        $path_to_tables = "../tables/";
        $file_list = array('id','date', 'time.csv', 'day.csv', 'ip.csv', 'duration.csv', 'page.csv', 'os.csv','os_version', 'browser.csv','browser_version', 'naviator_version', 'navigator_app_version','navigator_platform','navigator_version');

        $csv = readCSV($file_name.'1'); // Make sure this exsists or you will have a forever error log.
        
        foreach ( $csv as $c ) {
            $count = 0;
            echo $c[0];
            //if next required id > offered ID skipp
            if ($start_from > $c[0]){
                echo "your greater";
            }
            else{
                foreach ($c as $d){
                    $check_me = $file_list[$count];
                    $path = "";
                    $id = $c[0];
                    $date = $c[1];
                    $store_more = array();
                    if (strpos($check_me, '.csv') == true){
                        $store_more = array($id, $date);
                        array_push($store_more, $c[$count]);
                        $next = $count;
                        //STORE ALL WITHOUT FILE in an array 
                        while (strpos($file_list[$next], 'csv') != true){
                            array_push($store_more, $c[$next]);
                            $next = $next++;
                        }
                        $path = $path_to_tables.$check_me; 
                    } 
                    // WRITE TO FILE
                    if ($path == NULL){
                        
                    }else{
                        $file = fopen($path,"a");
                            if (flock($file, LOCK_EX)){
                                fputcsv($file, $store_more);
                                $file = NULL;
                                flock($file, LOCK_UN);
                            }
                        fclose($file);
                        }
                    $count++;
                
                $i = 0;
                if ($i < $count){
                    $value = $c[$i];
                    echo $value;
                    $i++;

                }
            }
            
            
            //     // exec('rm '.$file_name.'1');
            //     // echo('temp file deleted');
        }
        }
    }
    
    index("../tables/full_join.csv");
}catch(Exception $e){
    echo json_last_error_msg();
}


?>