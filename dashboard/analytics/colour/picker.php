<?php
 if($path_to == ""){
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
<link rel="stylesheet" href="<?php echo $path_to;?>/dashboard/analytics/colour/style.css">
<script  src="<?php echo $path_to;?>/dashboard/analytics/colour/script.js"></script>

<!-- partial:index.partial.html -->
<div id="colorpicker-content">
		<div id="display-container">
			<div id="color-display"></div>
		</div>
		<div id="result">hsl(0, 100%, 50%)</div>
		<label for="hue">hue</label>
		<input oninput=colorPicker();setColour(); class="slider" id="hue" type="range" value="0" max="360" min="0">
		<label for="saturation">saturation</label>
		<input oninput=colorPicker();setColour(); class="slider" id="saturation" type="range" value="100" max="100" min="0">
		<label for="luminosity">Luminosity</label>
		<input oninput=colorPicker();setColour(); class="slider" id="luminosity" type="range" value="50" max="100" min="0">
		<label for="alpha">alpha</label>
		<input oninput=colorPicker();setColour(); class="slider" id="alpha" type="range" value="1" step="0.01" max="1" min="0">
	</div>
  
