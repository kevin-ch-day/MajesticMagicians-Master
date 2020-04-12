<?php
if (isset($_GET["zoomDirection"]) && isset($_GET["zoomDirection"]))
{
    $data = array("zoomDirection" => boolval($_GET["zoomDirection"]), "zoomHowMuch" => intval($_GET["zoomHowMuch"]));         
    $data_string = json_encode($data); 
                                                                                                                         
    $ch = curl_init('http://putiphere:5000/api/motor/ '); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                                                                                                                      
    echo curl_exec($ch);
    curl_close($ch);
}
else #if (isset($_GET["setLightValue"]))
{
    $data = array("setLightValue" => boolval($_GET["setLightValue"]));         
    $data_string = json_encode($data); 
                                                                                                                         
    $ch = curl_init('http://75.168.242.3:5000/api/light/ '); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                                                                                                                      
    echo curl_exec($ch);
    curl_close($ch);
}
/*$data = array("setLightState" => true);                                                                    
$data_string = json_encode($data); 
                                                                                                                     
$ch1 = curl_init('http://75.168.242.3:5000/api/light/ '); 
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
                                                                                                                     
curl_exec($ch1);
curl_close($ch1);
return true;*/

?>
