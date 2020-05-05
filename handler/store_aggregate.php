<?php 
    //structure
    //dashboard/analytics/aggregate.php stores at
    //handler/store_aggregate.php which handles all file names and writing to file and backup file rules
    //which includes aggregate.php
    //which handles all frequency rules and aggregate rules
    include $path_to."/handler/aggregate.php";
    include "../handler/aggregate.php";
    if($_POST){
        $name = strtolower($_POST["name"]);
        $data = $_POST["tables"];
        $aggregate_type = strtolower($_POST["aggregate_type"]);
        $frequency = strtolower($_POST["frequency"]);
        
        
        //path and name of new.csv
        $file_csv = "../aggregate/".$name.".csv";

        //Move pointer to target table
        $target_table = "../tables/".$data.".csv";
        $func = "";
        $target_array = array();
        // TARGETING
            if ($frequency = "day"){
                $func = "sort_day";
            }
            elseif ($frequency == "month"){
                $func = "sort_month";
            }
            elseif ($frequency == "week"){
                $func = "sort_week";
            }
            elseif ($frequency == "quarter"){
                $func = "sort_quarter";
            }
            elseif ($frequency == "year"){
                $func = "sort_year";
            }
        
        //READ TABLE
        function aggregate($name, $table_name, $aggregate_type){
            //READ AND WRITE TO ARRAY
            $fp = fopen($table_name, 'r');
                // LOOP INTO AN ARRAY
                // get the first (header) line
                $header = fgetcsv($fp);
                
                // get the rest of the rows
                $data = array();
                while ($row = fgetcsv($fp)) {
                    $arr = array();
                    foreach ($header as $i => $col)
                        // Get date & value
                        $temp_date = $row[1]; // this is date
                        $temp_value = $row[2]; // value

                            // DIFFERENTIATE STORAGE METHOD (above)
                            // STORE DATE && VALUE
                            $func($temp_date, $temp_value);
                            // per read
                        $arr[$col] = $row[$i];
                        $data[] = $arr;
                        print_r($data);
                }
                // SET ARRAY
                if ($frequency == "day"){
                    global $day_sort;
                    $target_array = $day_sort;
                }
                elseif ($frequency == "month"){
                    global $month_sort;
                    $target_array = $month_sort;
                }
                elseif ($frequency == "week"){
                    global $week_sort;
                    $target_array = $week_sort;
                }
                elseif ($frequency == "quarter"){
                    global $quarter_sort;
                    $target_array = $quarter_sort;
                }
                elseif ($frequency == "year"){
                    global $year_sort;
                    $target_array = $year_sort;
                }
                //LOOP OUT OF ARRAY
                print_r($target_array);
                echo $frequency;
                echo "--------<br>";
                echo $aggregate_type;
                echo $file_csv;
                // read_sort($target_array, $frequency, $aggregate_type, $name);
                // STORE

            // print_r($data);
        }
        aggregate($target_table, $frequency, $aggregate_type, $file_csv);
        //RULES
        //READ TABLE sort by Date Aggregate RULES > Store, named as $name_____ > set in cron
        //Aggregation type:
            // 0) Sum
            // 1) Average
            // 2) Total
            // 3) Minimum
            // 4) Maximum
            // 5) Count (distinct) 
            // 6) Count
            // 7) Standard deviation
            // 8) Variance 

            // START WITH 
            // COUNT
            // TOTAL

        //just print for checks
        $out=[$name, $data, $aggregate_type, $frequency, $target_table];
        echo "<br>".json_encode($out);

        // Rules for the CSV
        // 1) Store name as $name.csv [DONE]
        // 2) find data type [DONE]
        // 3) handle aggregation differently depending on which data type
        // 4) aggregate dependent on frequency, past data, [DONE]
        // 5) schedule future data to be aggregated [half]
        // 6) auto write script to append_aggregate
                // - 0) Read append_list.csv
                //      > this is a list with all rules of aggregation
                //      > Generated with each aggregate
                // - 1) Read table name and path
                // - 2) Check last number
                // - 3) Update from number in origin file
                // - 4) sort by Date 
                // - 5) aggregate by rules
                // - 6) Store by name

        // Store Rules [END]
            function store_rules($file_name, $entry){
                $file = fopen($file_name, "a");
    
                echo "<br>File: <br>".$file."<br>";
                echo "file name: ".$file_name."<br>";
                echo "Output: ".$out."<br>";
    
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
        

?>