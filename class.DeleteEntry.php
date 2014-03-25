<?php
	class DeleteEntry
		{
			private $dbConnect;
			private $runNumber;
								
			public function __construct(){
				$this->dbConnect = Database::createConnection();
				$this->runNumber = $_GET['run_Number'];
				$this->deleteTime();
			}			
			
			private function deleteTime(){
				$this->sql = "DELETE FROM timetable WHERE run_number = '".$this->runNumber."'";
				try{	
					$dbInsert = $this->dbConnect->query($this->sql);
				}
				catch (Exception $e){
					echo $e->getMessage();
				}
			}
		}
?>