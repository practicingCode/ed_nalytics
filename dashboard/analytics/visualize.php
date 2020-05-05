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
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://d3js.org/d3.v4.js"></script>
        <script src="<?php echo $path_to;?>/visualize.js"></script>
        <title>Visualize</title>
        
    </head>
    <?php

echo $path_to;
include "testd3.php";

?>

</html>