<?php
 
class DbOperation
{
    
    private $con;
 
   
    function __construct()
    {
       
        require_once dirname(__FILE__) . '/DbConnect.php';
 
       
        $db = new DbConnect();
 
        $this->con = $db->connect();
    }
	
	
	function createJob($title, $descj, $req, $salary){
		$stmt = $this->con->prepare("INSERT INTO jobs (title, descj, req, salary) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $title, $descj, $req, $salary);
		if($stmt->execute()){
			return true; }
		else{
		return false; 
		}
	}

	
	function showJob(){
		$stmt = $this->con->prepare("SELECT id, title, descj, req, salary FROM jobs");
		$stmt->execute();
		$stmt->bind_result($id, $title, $descj, $req, $salary);
		
		$jobs = array(); 
		
		while($stmt->fetch()){
			$job  = array();

			$job['id'] = $id; 
			$job['title'] = $title; 
			$job['descj'] = $descj; 
			$job['req'] = $req; 
			$job['salary'] = $salary; 
			
			array_push($jobs, $job); 
		}
		
		return $jobs; 
	}
	
	
	function updateJob($id, $title, $descj, $req, $salary){
		$stmt = $this->con->prepare("UPDATE jobs SET title = ?, descj = ?, req = ?, salary = ? WHERE id = ?");
		$stmt->bind_param("ssssi", $title, $descj, $req, $salary, $id);
		if($stmt->execute())
			return true; 
		return false; 
	}
	
	

	function deleteJob($id){
		$stmt = $this->con->prepare("DELETE FROM jobs WHERE id = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		
		return false; 
	}
}