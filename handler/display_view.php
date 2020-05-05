<?php 
// PATH TO
$file_name = $path_to."/stored_rules/rules.csv";
//DISPLAY ALL
    if (($handle = fopen($file_name, "r")) !== FALSE) {
        $count = 1;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $name = $data[2];
            $table_type = $data[3];
            $desc = $data[6];
            //DISPLAY <td></td>
            if ($name == "name"){
                // if header skip
            }else {
                //getting total
                $f_name = $path_to.'/'.'view/'.$table_type."_".$name.".csv";
                $fp = file($f_name);
                $total_entries = count($fp);
                    // echo $f_name."<br>";

                // CREATE DELETE BUTTON
                //DISPLAY
                echo "<tr id='row$count' data-toggle='tooltip' title='$desc'><td>$name</td><td>$table_type</td><td>$total_entries</td><td><button type='button' class='btn btn-primary' data-toggle='modal' title='$desc' data-target='#myMod'>edit</button><button onclick='removeRow(this)' type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></td></tr>";
                $count++;
            }
        }
        fclose($handle);
        
    }


?>