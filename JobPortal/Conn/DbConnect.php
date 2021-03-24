<?php 
	


	class DbConnect
	{
	
		private $con;
	 
	
		function __construct()
		{
	 
		}
	 
		
		function connect()
		{
			
			include_once dirname(__FILE__) . '/Constants.php';
	 
			
			$this->con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 
			
			if (mysqli_connect_errno()) {
				echo "Your db is not connected: " . mysqli_connect_error();
			}
	 
		
			return $this->con;
		}
	 
	}