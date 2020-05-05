<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
        
            window.addEventListener('load', (event) => {
                loadDoc();
                });

            function loadDoc() {
                var y = new XMLHttpRequest();
                y.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    }
                };
                y.open("POST", " <?php echo $path_to;?>/cron/jobs/index_csv.php");
                // z.open("POST", " <?php #echo $path_to;?>/awhile.php");
                y.send("true");
                console.log("indexed");
            //====================================================================
            //====================================================================
                var z = new XMLHttpRequest();
                z.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    }
                };
                z.open("POST", " <?php echo $path_to;?>/handler/quantify.php");
                // z.open("POST", " <?php #echo $path_to;?>/awhile.php");
                z.send("true");
                console.log("quantified");
            }
        </script>
        
    </head>
<h1>Aggregate</h1>
    <p> Here we will aggregate all the data of your site</p>
    <p>Which data set would you like to aggregate?</p>
<h1 id="x" onmouseover="getData(<?php echo $path_to;?>+'/handler/tables_list', 'Aggregate')">AXE</h1>
<!-- 
    Data | Aggregation | Frequency
               +          default 1 week


-->
<form action="<?php echo $path_to; ?>/handler/aggregate.php" method="POST">
    <div class="container">
        <div Class = "table-responsive">
            <table class= "table">
                <tr>
                    <th>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name</label>
                        <input name="name" type="text" class="form-control" id="exampleInputPassword1" placeholder="Name aggregate">
                    </div>
                    </th>
               
                    <th><?php include $path_to."/handler/drop_down.php"; ?></th>
                    <th>
                    <label for="sel1">Aggregate:</label>
                        <select class="form-control" id="aggregate" name="aggregate_type">
                            <option>Sum</option>
                            <option>Average</option>
                            <option>Total</option>
                            <option>Minimum</option>
                            <option>Maximum</option>
                            <option>Count (distinct)</option> 
                            <option>Count</option>
                            <option>Standard deviation</option>
                            <option>Variance</option>
                        </select>
                    </th>
                    <th>
                    <label for="sel1">Frequency:</label>
                        <select class="form-control" id="frequency" name="frequency">
                            <option>Day</option>
                            <option>Week</option>
                            <option>Month</option>
                            <option>Quarter</option>
                            <option>Year</option> 
                        </select>
                    </th>
                    <th>
                        
                        <td>
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                        </td>
                    </th>
                </tr>
                
            </table>
        </div>    
    </div>
</form>
<!-- 
                            1) name
                            2) tables
                            3) aggregate_type
                            4) frequency
                        -->
<?php 
echo $path_to."/handler/tables_list.php";

?>




</html>


