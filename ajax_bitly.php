<?php
function make_bitly_url($url,$login,$appkey,$format = 'xml',$history=1, $version = '2.0.1')
{
	// Modified function originally from http://davidwalsh.name/bitly-php
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format.'&history='.$history;
	
	//get the url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $bitly . "?" . $param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	curl_close($ch);
	
	//parse depending on desired format
	if(strtolower($format) == 'json') {
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	} else {
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
} // end function make_bitly_url		
header('Content-Type: application/json; charset=utf8');
print json_encode(make_bitly_url($_POST['url'],'YOUR_BITLY_USERNAME','YOUR_BITLY_API_KEY','json'));
?>