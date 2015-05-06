<?php
/*created by Sergey Rusanov*/
/*include file with setting for connectiоn*/
require_once dirname(__DIR__)."/etc/params.scr";

class MysqlClass {
	private $mysqli;
	private $ret_val; 
	
	public function __construct(){
			global $connect;
			$this->ret_val = NULL;
			@$this->mysqli = new mysqli($connect['dbHost'], $connect['dbLogin'], $connect['dbPass'], $connect['dbName']);
				if($this->mysqli->connect_errno || !$this->mysqli->set_charset('utf8')){
					$this->ret_val = "can't connect"; 
				}
	}	
	
	public function execSql(){
	if(isset($this->ret_val)) return $this->ret_val;
		switch(func_num_args()){
			case 1:
					$sqlType = trim(strtoupper(substr(func_get_arg(0), 0, strpos(func_get_arg(0),' '))));
					$resultSet = $this->mysqli->query(func_get_arg(0));
					
					if(!$resultSet)
						return $this->mysqli->error;
					else{
						$results = array();
						switch($sqlType){
						case 'SELECT':
								while($row = $resultSet->fetch_assoc())
										$results[] = $row;
							break;
						case 'INSERT':
								$results = $this->mysqli->insert_id;
							break;
						case 'DELETE':
						case 'UPDATE':
								$results = $this->mysqli->affected_rows;
							break;
						default: 
								$results = "Wrong statement in query.";
							break;
						}
						
						return $results;
					}
			default:
					return "Nothing to execute in sql";
				break;
		}
	}
	
	public function getLike($id, $table = 'tbUsers') {
		$results = $this->execSql("select id from {$table} where id = {$id}");
		if(is_array($results)) 
			$results = (bool)count($results);
		return $results;
	}
	
	public function setLike($id, $like, $table = 'tbUsers') {
		if($like === 1) 
			$results = $this->execSql("insert into {$table} set id = {$id}");
		else 
			$results = $this->execSql("delete from {$table} where id = {$id}");
		return $results;
	}
}
?>
