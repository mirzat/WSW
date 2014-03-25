<?php
	class TimeEntry
		{
			// Declare Variables
			private $dbConnect;
			private $trainLine;
			private $route;
			private $runNumber;
			private $operatorID;
									
			public function __construct(){
				$this->dbConnect = Database::createConnection();
				$this->trainLine = $_POST['trainLine'];
				$this->route = $_POST['route'];
				$this->runNumber = $_POST['runNumber'];
				$this->operatorID = $_POST['operatorID'];
				// All of the above data must be sanitized for inserting into db
				$this->addTime();
			}			
			
			// Function to add new entry to table
			private function addTime(){
				$this->sql = "INSERT INTO timetable VALUES ('".$this->trainLine."', '".$this->route."', '".$this->runNumber."', '".$this->operatorID."')";
				
				try{	
					$dbInsert = $this->dbConnect->query($this->sql);
				}
				catch (Exception $e){
					echo $e->getMessage();
				}
			}
		}
?>