<?php

ERROR_REPORTING(E_ALL);

function __autoload($className){
	include 'class.'.$className.'.php';
}

class TimeTable{
	
	private $dbConnect;
	private $trainInfo;
	private $trainData;
	private	$crud;
	
	
	public function __construct(){
		$this->dbConnect = Database::createConnection();
		
		// CREATE
		if(isset($_POST['create'])){
			$this->crud = new TimeEntry;
		}
		
		// UPDATE
		if(isset($_POST['update'])){
			$this->crud = new UpdateEntry;
		}
		
		
		elseif(isset($_GET['action'])){
			if ($_GET['action'] == 'delete')
				$this->crud = new DeleteEntry;
			elseif ($_GET['action'] == 'update')
				echo 'update';
		}
		
		
		
		elseif($this->trainInfo = $this->getFile())
			$this->trainData = $this->addToDatabase();
			
		else
			echo '<h1>Error: File was not uploaded correctly</h1>';		
			
	
			$this->displayTable();
			$this->dbConnect = Database::closeConnection();
		}
		
		
		private function getFile(){
			// If a file was uploaded and there were no errors and the file is the uploaded file
			if (isset($_FILES['csvFile'])){
				if ($_FILES['csvFile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['csvFile']['tmp_name'])) {          
			 		// Read data from file into array
					$fileName = $_FILES['csvFile']['tmp_name'];
					if ($fh = fopen($fileName, "r")) {
						$trainInfo = explode("\n", file_get_contents($fileName));
						fclose($fh);
						return $trainInfo;
					}
				}			
			}
		}
			
	
		public function addToDatabase(){
			
			// Extract train information into 2 dimensional array
			$i = 0;	
			foreach ($this->trainInfo as $train)
				$trainData[$i++] = explode(", ", $train);

			/*// Get the index of the run number in title row
			foreach ($trainData[0] as $key=>$value){
				if (stripos($value, 'number')){
					$GLOBALS['runNumber'] = $key;
					break;
				}
			}*/

			// Remove the field names
			unset($trainData[0]);

			$i = 1;
			$j = 0;
			
			$this->sql = "INSERT INTO timetable VALUES ";
			foreach ($trainData as $row){
				if ($i == count($trainData))
					$this->sql .= "('".$row[$j++]."', '".$row[$j++]."', '".$row[$j++]."', '".$row[$j]."');";
				else
					$this->sql .= "('".$row[$j++]."', '".$row[$j++]."', '".$row[$j++]."', '".$row[$j]."'), ";
				$i++;
				$j = 0;
			}
			
			try{	
				$dbInsert = $this->dbConnect->query($this->sql);
			}
			catch (Exception $e){
				echo $e->getMessage();
			}
			
			return $trainData;
		}

	
		private function displayTable(){	?>
			<!DOCTYPE html>
			<head><link rel="stylesheet" href="css/main.css" type="text/css"></head>
			<html>
				<body>
					<div id="trainInformation">
						<table class="dataTable">
						<tr class="titles">
							<td>Train Line</td>
							<td>Route</td>
							<td>Run Number</td>
							<td>Operator ID</td>
						</tr>
						
						<?php
						$sql = "SELECT * FROM timetable";
						$result = $this->dbConnect->query($sql);
						$assocArray = $result->fetch_all(MYSQLI_ASSOC);
								
						// Function to sort train data by run number		
						function sortByRunNumber($a, $b){  
							return strnatcmp($a['run_number'], $b['run_number']);
						}      		
						uasort($assocArray, "sortByRunNumber"); 	// Sort Function call
									
						// Print the human friendly format
						foreach ($assocArray as $row){
							echo '<tr>';
							foreach ($row as $key=>$value){
								if ($key == 'run_number')
									$runNumber = $value;
								echo "<td>$value</td>";
								}
								
								echo "<td><a class='update' href='update.php?action=update&run_Number=".$runNumber."'>Update</a></td>"; 
								echo "<td><a class='delete' href='class.Timetable.php?action=delete&run_Number=".$runNumber."'>Delete</a></td>"; 
								
						}
						?>							
							<tr>
								<form name="addTime" method="POST">
									<td><input type="text" name="trainLine"></td>
									<td><input type="text" name="route"></td>
									<td><input type="text" name="runNumber"></td>
									<td><input type="text" name="operatorID"></td>
									<td><input type="submit" name="create" value="Add New Entry"></td>
								</form>
								
							</tr>					
						</table>
					</div>
				</body>
			</html>	
		<?php	}		
}

$display = new Timetable();
?>







