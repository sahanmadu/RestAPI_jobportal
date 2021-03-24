<?php 

	
	require_once '../Conn/DbConnect.php';
	require_once '../Conn/DbOperation.php';

	function isTheseParametersAvailable($params){
		
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
		
			echo json_encode($response);
			
			
			die();
		}
	}
	
	
	$response = array();
	
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			
			case 'createjob':
				
				isTheseParametersAvailable(array('title','descj','req','salary'));
				
			
				$db = new DbOperation();
				
				
				$result = $db->createJob(
					$_POST['title'],
					$_POST['descj'],
					$_POST['req'],
					$_POST['salary']
				);
				

			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'New job added successfully';

				
					$response['jobs'] = $db->showJob();
				}else{

			
					$response['error'] = true; 

					$response['message'] = 'Some error occurred please try again';
				}
				
			break; 
			
		
			case 'showjobs':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Request successfully completed';
				$response['jobs'] = $db->showJob();
			break; 
			
			
			
			case 'updatejob':
				isTheseParametersAvailable(array('id','title','descj','req','salary'));
				$db = new DbOperation();
				$result = $db->updateJob(
					$_POST['id'],
					$_POST['title'],
					$_POST['descj'],
					$_POST['req'],
					$_POST['salary']
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Job updated successfully';
					$response['jobs'] = $db->showJob();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Some error occurred please try again';
				}
			break; 
			
			
			case 'deletejob':

				
				if(isset($_GET['id'])){
					$db = new DbOperation();
					if($db->deleteJob($_GET['id'])){
						$response['error'] = false; 
						$response['message'] = 'job deleted successfully';
						$response['jobs'] = $db->showJob();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Some error occurred please try again';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Nothing to delete, provide an id please';
				}
			break; 
		}
		
	}else{
		
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	

	echo json_encode($response);
	
	
