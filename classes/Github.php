<?php
/*created by Sergey Rusanov*/
class Github {
private $curl;
private $basePath; 
	
public function __construct(){
	$this->curl = curl_init();
	$this->basePath = "https://api.github.com";
	curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36');
	curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($this->curl, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($this->curl, CURLOPT_REFERER, $this->basePath);
	curl_setopt($this->curl, CURLOPT_VERBOSE, 0);
}
	
public function __destructor() {
	if(isset($this->curl))
		curl_close($this->curl);
}

public function changePath($addPath) {
	return curl_setopt($this->curl, CURLOPT_URL, $this->basePath.$addPath);
}

public function search($params, $pagination = null) {
$this->changePath("/search/repositories?q={$params}");
return json_decode(curl_exec($this->curl), true);
}

public function get($params, $pagination = null) {
$this->changePath("/repos/{$params['owner']}/{$params['repo']}");
return json_decode(curl_exec($this->curl), true);
}

public function listContributors($params, $pagination = null) {
$this->changePath("/repos/{$params['owner']}/{$params['repo']}/contributors");
return json_decode(curl_exec($this->curl), true);
}

public function getSingleuser($params, $pagination = null) {
$this->changePath("/users/{$params['username']}");
return json_decode(curl_exec($this->curl), true);
}

}
/*
$my = new Github();
var_dump($my->getSingleuser(['username' => 'octocat']));
*/

?>
