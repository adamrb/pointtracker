<?php
require_once('includes/config.inc.php');

function restCall($request, $method, $pbody="") {

       //Initialize a curl session
       $session = curl_init($request);

       /* You then set any curl options that you might need. curl
       options are listed at
       http://us2.php.net/manual/en/function.curl-setopt.php. In this
       case, we tell curl that we don't want the HTTP headers returned,
       but we do want the request data returned: */

       // Tell curl not to return headers, but do return the response
       curl_setopt($session, CURLOPT_HEADER, false);

       curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

	//Set User	
      curl_setopt($session, CURLOPT_USERPWD, CALORIEUSER);

	if($method == 'POST') {//For post method notify curl
              // Tell curl to use HTTP POST
              curl_setopt ($session, CURLOPT_POST, true);

              // Tell curl that this is the body of the POST
              curl_setopt ($session, CURLOPT_POSTFIELDS, $pbody);
       }
       
       //send request
       $response = curl_exec($session);

       //close session
       curl_close($session);
       
       //this is the response(xml)
       return $response;
}
?>
