<?php if($path_to == ""){
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
?>
<!-- -------------------------------------------------------------------------------  -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <meta charset="utf-8">
        
    </head>
    <body >
    <h1 id="z">TEMP</h1>
    <script>
    var files = <?php 
    $out = array();
    
        foreach (glob($path_to.'/aggregate/*.csv') as $filename) {
            $p = pathinfo($filename);
            
            $out[] = $p['filename'];
        }
        echo json_encode($out); ?>;
</script>
<style> #colourpicker{ background-color:  hsla(0, 0%, 30%, 1); }</style>
    <tr>
        <th>
            <label>Chart Name: </label>
            <input id ="name"type="text" class="form-control" placeholder="name your chart" aria-describedby="basic-addon2">
        </th>
    </tr>
    <tr>
        <th>
            <label for="sel1">Visualization type:</label>
                <select class="form-control" id="visualization" name="visualization" onchange="getData('data1');">
                            <option>Bar Chart</option>
                            <option>Line Chart</option>
                            <!-- <option disabled>Pie Chart</option>
                            <option disabled>Map</option>
                            <option disabled>Word Cloud</option>
                            <option disabled>Radar</option> 
                            <option disabled>Count</option>
                            <option disabled>Standard deviation</option>
                            <option disabled>Variance</option> -->
                        </select>
                    </th>
                    <th>
                </tr>
                <tr>
                    <td>
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="colour-button">Pick a colour</button>

                    <!-- Modal Colour Picker-->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">

                                <!-- Modal content-->
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Pick a colour</h4>
                                    </div>
                                    <div class="modal-body" id= "colourpicker">
                                        <!-- Colour picker stored here -->
                                        <?php include $path_to."/dashboard/analytics/colour/picker.php";?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <!--COLOUR NAME -->
                    <td> 
                        <div id="colour-name"> colour name</div>
                    </td>
                </tr>
                <tr><td>
                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" id="desc" placeholder="describe your chart"></textarea>
                        <i>Max 150 Characters</i>
                    </div>
                </td></tr>
                
                <!--table list onwards -->
                <tr><td><?php include $path_to."/handler/drop_down1.php"; ?></td></tr>
                <button id="submit" type="submit" class="btn btn-primary submit" onclick="button();" >Submit</button>
    
    <h1 id="demo">Mouse over me</h1>
    
    <div id="viz_bar"></div>
            <?php include $path_to."bar.php" ?>
        <script type="text/javascript"charset="utf-8" src= "<?php echo $path_to; ?>/dashboard/analytics/visualize.js">
            
        </script>
    </body>
</html>