<?php
	class UpdateEntry
		{
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
				$this->updateTime();
			}			
			
			private function updateTime(){
				$this->sql = "UPDATE timetable SET train_line = '".$this->trainLine."', route = '".$this->route."', operator_id = '".$this->operatorID."' WHERE run_number = '".$this->runNumber."'";	
				try{	
					$dbInsert = $this->dbConnect->query($this->sql);
				}
				catch (Exception $e){
					echo $e->getMessage();
				}
			}
		}
?>