
    <label for="sel1">Data list:</label>
        <select class="form-control" id="tables" name="tables">
            <?php
            //GENERATES <option>
                $path = $path_to."/tables";
                $file = scandir($path);
                $files = array_diff($file, array('.', '..','full_join.csv','full_join.csv1'));
                foreach ($files as $x){
                    if (strpos($x, 'csv') != false){
                        
                            $y = str_replace(".csv","",$x);
                            echo "<option>$y</option>";
                    }
                }
            ?>
        </select>


