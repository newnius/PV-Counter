<?php
/*
$w = stream_get_wrappers();
echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
echo 'wrappers: ', var_export($w);
*/

/*
$ctx = stream_context_create(['ssl' => [
    'capture_session_meta' => TRUE
		]]);
		 
		 $html = file_get_contents('https://quickauth.newnius.com/', FALSE, $ctx);
		 var_dump($html);
		 $meta = stream_context_get_options($ctx)['ssl']['session_meta'];
		 var_dump($meta);
*/

/*
$arrContextOptions=array(
	"ssl"=>array(
		"cafile" => "static/cacert.pem",
		"verify_peer"=> true,
		"verify_peer_name"=> true,
	),
);  
$response = file_get_contents("https://quickauth.newnius.com", false, stream_context_create($arrContextOptions));
echo $response;
*/
/*
function getSSLPage($url) {
    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_HEADER, false);
				    curl_setopt($ch, CURLOPT_URL, $url);
						    curl_setopt($ch, CURLOPT_SSLVERSION,3); 
								    $result = curl_exec($ch);
										    curl_close($ch);
												    return $result;
														}

														var_dump(getSSLPage("https://quickauth.newnius.com"));
*/


var_dump(parse_url('http://jlucqe.jlu.edu.cn:8080/view.php?d=s&sa=dsa#anchor'));
