<?php
header('content-type:text/html;charset=utf-8');
//数组转XML
function arrayToXml($arr,$dom=0,$item=0){
    if (!$dom){
        $dom = new DOMDocument("1.0");
    }
    if(!$item){
        $item = $dom->createElement("root"); 
        $dom->appendChild($item);
    }
    foreach ($arr as $key=>$val){
        $itemx = $dom->createElement(is_string($key)?$key:"item");
        $item->appendChild($itemx);
        if (!is_array($val)){
            $text = $dom->createTextNode($val);
            $itemx->appendChild($text);
            
        }else {
            arrayToXml($val,$dom,$itemx);
        }
    }
    return $dom->saveXML();
}

function arrayToXml2($arr){
    $xml = "<xml>";
    foreach ($arr as $key=>$val){
        if(is_array($val)){
        	$xml.="<".$key.">".arrayToXml($val)."</".$key.">";
        }else{
        	$xml.="<".$key.">".$val."</".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}


//将XML转为array
function xmlToArray($xml){    
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $val = json_decode(json_encode($xmlstring),true);  
    return $val;
}



$arr = array();
$arr['user'] = '月光光abc';
$arr['pvs'] = 23002;
$arr['ips'] = array(
	'baidu_ip' => 11200,
	'google_ip' => 9829,
	'others' => array(
		'0' => 2229,
		'shanghai' => 3321
	)
);
$arr['date'] = '2016-06-01';



$result = arrayToXml($arr);
var_dump($result);



$xmlstring = '<root>
<user>月光光abcd</user>
<pvs>13002</pvs>
<ips><baidu_ip>1200</baidu_ip><google_ip>1829</google_ip></ips>
<date>2016-06-01</date>
</root>';

$arr = xmlToArray($xmlstring);
var_dump($arr);
?>