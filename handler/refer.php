<?php 
function get_client_ip() {
    $ref = $_SERVER['HTTP_REFERER'];         // Get referrer
    if (!$ref.strpos($_SERVER['HTTP_HOST'])) // It's not from the same domain?
        $_SESSION['originalreferrer'] = $ref;  // Nope, store in session
}

   if ($_POST == NULL){
       $ip = get_client_ip();
       echo json_encode($ip);
   }


?>