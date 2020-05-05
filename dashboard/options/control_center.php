<h1>Control Center</h1>
<p>Welcome to the control center</p>
<!-- 
    Notes:
    - because of PHP reads paths based on cwd where it is imported path finders can be used to re-orient
-->
<?php
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
    echo $path_to;
    include $path_to."/testd3.php";
    
?>