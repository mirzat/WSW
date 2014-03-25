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
		
		if($this->trainInfo = $this->getFile())
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
			
	
		private function addToDatabase(){
			
			// Extract train information into 2 dimensional array
			$i = 0;	
			foreach ($this->trainInfo as $train)
				$trainData[$i++] = explode(",", $train);

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
							foreach ($row as $data){
								echo "<td>$data</td>";
								}
							echo '</tr>';
						}
						?>									
						</table>
					</div>
				</body>
			</html>	
		<?php	}		
}

$display = new Timetable();
?>







