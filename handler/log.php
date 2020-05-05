<?php 

if ($_POST == NULL){
    
    $str = json_decode($_POST, true); 
    echo "didn't trigger";
    $array=json_decode($_POST);
        $file = fopen("test.txt","w");
        echo fwrite($file, $array);
        fclose($file);
}elseif($_POST){
    
    try{
        function store($file_name){
            echo "triggered";
            // SET ID
            
            $id = 1;
            $rows = file($file_name);
            $last_row = array_pop($rows);
            $data = str_getcsv($last_row);
            if ($data != null){
                
                //if less than equal to add
                if ($id <= $data){
                    $id = $data[0] + 1;
                }
                // DELETE ME LATER
                echo json_encode($id)."<br>";
            }
            
            
           

            // PREPARING TO WRITE
            // Day
            $day = date("l");
            // Date
            $date = date("d/m/Y");
            // Time
            $time = date("G:i:s");
            $out = [$id, $date, $time, $day];
            echo $out;
            foreach ($_POST as $key => $value) {
                array_push($out, $value);
            }

// DELETE ME LATER
            echo "CONTENT: <BR>".json_encode($out);


            // WRITE TO FILE
            // $file = fopen($file_name,"a");
            $file = fopen($file_name, "a");

            echo "<br>File: <br>".$file."<br>";
            echo "file name: ".$file_name."<br>";

            if (flock($file, LOCK_EX)){
                fputcsv($file, $out);
                $file = NULL;
                    //PUT PYTHON SCRIPT HERE
                flock($file, LOCK_UN);
            }
            fclose($file);
        }
        // STORE TO CSV
        store("../tables/full_join.csv");
        
    }catch(Exception $e){
        echo json_last_error_msg();
    }
    
}
?>