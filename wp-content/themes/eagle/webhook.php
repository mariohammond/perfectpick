<?php
echo 'hello1';
$data = file_get_contents('php://input');
//$json_data = json_decode($data);

//var_dump($json_data);

// Send email
$message = wordwrap($data, 70, "\r\n");
//mail('mario2630@yahoo.com', 'Webhook Test', $message);

/*$obj = $json_data->payload;
$fname=$obj->signup->first_name;
$lname=$obj->signup->last_name;
$nid=$obj->signup->nationbuilder_id;*/

// Assemble the body of the email...
/*$message_body = <<<EOM
first name: $fname \n
last name: $lname \n
nationbuilder_id: $nid \n
EOM;
mail('someone@example.com','NB Webhook Data',$message_body);*/
?>