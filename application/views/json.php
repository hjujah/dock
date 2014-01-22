<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Content-type: text/javascript');
if(isset($json_data) && !empty($json_data)){
    echo json_encode($json_data);
}
else{
    echo json_encode(0);
}