<?php
/*created by Sergey Rusanov*/
require_once dirname(__DIR__)."/testMobidev/classes/Github.php";
require_once dirname(__DIR__)."/testMobidev/classes/MysqlClass.php";
  
/*view*/

function formHead($headerStr = "Main page") {
return <<<EOT
	<form id="search" action="index.php" method="get">
<div class="header-wrapper">
		<span><a href="index.php">{$headerStr}</a></span>
	<div class="search-input-wrapper"> 
		<input id="search-input" class="search" type="text" placeholder="Введите фразу для поиска" autofocus="true" name="q"></input>
		<button type="submit">
	</div>
</div>
</form>
EOT;
	}
	
function formDetails($companyDetails = ['owner' => 'yiisoft', 'repo' => 'yii']) {
	$curl = new Github();
	$result = $curl->get($companyDetails);
	
$html = <<<EOT
		<div class="mainPlate-wrapper">
		<div class="displayMain">
		<div style="background-image:url('{$result['owner']['avatar_url']}');">{$result['full_name']}</div>
		<ul>
			<li>Full name: {$result['full_name']}</li>
			<li>Description: {$result['description']}</li>
			<li>Language: {$result['language']}</li>
			<li>Homepage: <a href="{$result['homepage']}" target="_blank">{$result['homepage']}</a></li>
			<li>Forks count: {$result['forks_count']}</li>
			<li>Watchers: {$result['watchers']}</li>
			<li>Git Hub Repo: <a href="{$result['html_url']}" target="_blank">{$result['html_url']}</a></li>
		</ul>
		</div>
EOT;
return $html;
}

function formContributors($contributors = ['owner' => 'yiisoft', 'repo' => 'yii']) {
$curl = new Github();
$mysql = new MysqlClass();
$result = $curl->listContributors($contributors);
$html = <<<EOT
	<div class="contributors">
            <span>Contributors:</span>
          <div class="contributors-item-wrapper">
EOT;
foreach($result as $key => $contributor) {
$like = $mysql->getLike($contributor['id']) ? "unlike" : "like";
$html .= <<<EOT
	<div class="contributor-item">
            <a href="index.php?operation=4&username={$contributor['login']}" target="_blank">{$contributor['login']}</a>
            <div class="{$like}" id="item-{$contributor['id']}"></div>
	</div>
EOT;
	}
$html .= "</div></div></div>";
return $html;
}


function formSearch($value) {
	$mysql = new MysqlClass();
	$results = getSearch($value);
	$html = <<<EOT
	<div class="mainPlate-wrapper">
	<div class="search-result-wrapper">
        <span>For search term "{$value}" found</span>
	<div class="search-result-plates-wrapper">
EOT;
	if(!isset($results['items']) || count($results['items']) == 0) $html .= <<<EOT
		<div class="search-result-plate">
          <div class="title-plate">
			<span> Nothing found </span>
		  </div>
		</div>
EOT;
	else
	foreach($results['items'] as $id => $result) {
		$description = mb_strimwidth($result['description'], 0, 80, "...");
		$like = $mysql->getLike($result['id'], "tbProject") ? "unlike" : "like";
		$html .= <<<EOT
		<div class="search-result-plate">
          <div class="title-plate">
            <span><a href="index.php?operation=3&owner={$result['owner']['login']}&repo={$result['name']}">{$result['name']}</a></span>
            <span><a class="release" href="{$result['html_url']}" target="_blank">{$result['html_url']}</a></span>
            <span><a href="index.php?operation=4&username={$result['owner']['login']}">{$result['owner']['login']}</a></span>
          </div>
            <span>{$description}</span>
          <div class="counter-plate">
            <span>Watchers: {$result['watchers_count']}</span>
            <span>Forks: {$result['forks']}</span>
            <div class="{$like}" id="project-{$result['id']}"></div>
          </div>
		</div>
EOT;
	}
	$html .= "</div></div>";
	return $html;
}

function formUser($data) {
	$mysql = new MysqlClass();
	$user = getSingleUser($data);
	$like = $mysql->getLike($user['id']) ? "unlike" : "like";
	$userName = isset($user['name']) ? $user['name'] : "No name set.";
	$userComp = !empty($user['company']) ? $user['company'] : "No company set.";
	$userBlog = isset($user['blog']) ? "<a href=\"{$user['blog']}\" target=\"_blank\">{$user['blog']}</a>" : "No about blog info.";
	$userLoc = isset($user['location']) ? $user['location'] : "No location set.";
	
	$html = <<<EOT
			<div class="mainPlate-wrapper">
				<div class="user-info">
					<div class="user-logo-like">
						<div class="user-logo" style="background-image:url('{$user['avatar_url']}');">
						</div>
						<div class="{$like}" id="item-{$user['id']}"></div>
					</div>
					<div class="user-info-plate">
						<ul>
							<li>{$userName}</li>
							<li>{$user['login']}</li>
							<li> Company: {$userComp}</li>
							<li> Blog: {$userBlog}</li>
							<li> Location: {$userLoc}</li>
							<li> On GitHub since: {$user['updated_at']}</li>
							<li> Followers: {$user['followers']}</li>
						</ul>
					</div>
				</div>
			</div>
EOT;
	return $html;
}

/*model*/

function setLike($id, $like, $table) {
	$mysql = new MysqlClass();
	return $mysql->setLike($id, $like, $table);
}

function getSearch($value) {
	$curl = new Github();
	$result = $curl->search($value);
	return $result;
}

function getSingleUser($data) {
	$curl = new Github();
	$result = $curl->getSingleuser($data);
	return $result;
}
?>
