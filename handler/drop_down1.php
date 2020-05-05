
    <label for="sel1">Table list:</label>
        <select class="form-control" id="data1" name="tables" onchange="double_up(getData('data1')); ">
            <?php
            //GENERATES <option>
                // SET 1 for tables
                $path = $path_to."/tables";
                $file = scandir($path);
                // SET 2 for counts
                $path2 = $path_to."/aggregate";
                $file2 = scandir($path2);
                //REMOVE AND JOIN
                        // $files = array_diff($file, array('.', '..','full_join.csv','full_join.csv1'));
                        // $files = array_merge($files, $file2);
                foreach ($file2 as $x){
                    if (strpos($x, 'csv') != false){

                            $y = str_replace(".csv","",$x);
                            echo "<option>$y</option>";
                    }
                }
            ?>
        </select>


