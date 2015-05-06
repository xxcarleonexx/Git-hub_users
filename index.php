<?php
/*created by Sergey Rusanov*/
  require_once dirname(__DIR__)."/testMobidev/header.php";
  /*Take infо using Ajax*/
  
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if(isset($_GET['operation'])) {
      $operation = (int)$_GET['operation'];

      switch($operation) {
        case 1: { // Like & unlike Users or Projects
      if(isset($_GET['id'], $_GET['like'], $_GET['type'])) {
        $id = (int)$_GET['id'];
        $like = (int)$_GET['like'];
        $type = (int)$_GET['type'];
        
      if($type === 10) echo setLike($id, $like, "tbUsers");
      if($type === 20) echo setLike($id, $like, "tbProject");
      }
          break;
                }
                
        case 2: { // Take info from search engine of the GitHub.
          if(isset($_GET['q'])){
              $value = $_GET['q'];
              echo formSearch($value);
          }
              break;
              }
          
        case 3: { // Take info about some project.
          if(isset($_GET['owner'], $_GET['repo'])){
              $data['owner'] = stripcslashes($_GET['owner']);
              $data['repo'] = stripcslashes($_GET['repo']);
          
              echo formDetails($data);
              echo formContributors($data);
            }
          break;
          }
          
        case 4: { // Take info about user.
          if(isset($_GET['username'])){
              $data['username'] = stripcslashes($_GET['username']);
              echo formUser($data);
            }
          break;
          }
        default: exit;
      }
      }
  exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MobidevTest</title>
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
  <script src="js/jquery-ui.js" type="text/javascript"></script>
  <script src="js/index.js" type="text/javascript"></script>
</head>
	<body>
<?php
  echo formHead();
?>
    <div class="mainPlate">
<?php 

  echo formDetails(); 
  echo formContributors(); 
  //echo formUser(['username' => 'yii']);
?>
	</body>
</html>
