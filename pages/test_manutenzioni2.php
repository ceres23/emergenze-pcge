<?php 
class exampleChannelAdvisorAuth 
{
    public $Authorization; 
    //public $Password; 

    public function __construct($key) 
    { 
        $this->Authorization = $key; 
        //$this->Password = $pass; 
    } 
}



$Authorization        = "Bearer 10ac7b40-c252-3544-9b5e-301836e485a5"; 
//$password    = ""; 
//$accountId    = ""; 

// Create the SoapClient instance 
$url         = ""; 
$client     = new SoapClient($url, array("trace" => 1, "exception" => 0)); 

// Create the header 
$auth         = new ChannelAdvisorAuth($Authorization); 
$header     = new SoapHeader("https://apitest.comune.genova.it:28280/MANU_WSManutenzioni_MOGE/", "APICredentials", $auth, false); 

// Call wsdl function 
$result = $client->__soapCall("InserimentoSegnalazione", array( 
    "InserimentoSegnalazione" => array( 
        "IdTipologiaSegnalazione"        => "7", 
        "IdModalitaSegnalazione"    => "6",
        "IdSegnalante"        => "21575", 
        "Descrizione"    => "test",
        "IdTipologiaIntervento"        => "21", 
        "Matricola"    => "emergenze"
    ) 
), NULL, $header); 

// Echo the result 
echo "<pre>".print_r($result, true)."</pre>"; 
if($result->DeleteMarketplaceAdResult->Status == "Success") 
{ 
    echo "Item deleted!"; 
} 
?>
