<!DOCTYPE html>
<head><link rel="stylesheet" href="css/main.css" type="text/css"></head>
<html>
	<body>
		<h1>Update data for Run Number: <?=$_GET['run_Number']?></h1>

		<!--Simple form to capture new data from user-->
		<form name="updateTime" method="POST" action="class.Timetable.php">
			<table class="update">
			<tr class="titles">
				<td>Train Line</td>
				<td>Route</td>
				<td>Operator ID</td>
			</tr>
			<tr>
				<td><input type="text" name="trainLine"></td>
				<td><input type="text" name="route"></td>
				<td><input type="text" name="operatorID"></td>
				<td><input type="hidden" name="runNumber" value="<?=$_GET['run_Number']?>"></td>
				<td><input type="submit" name="update" value="Update Entry"></td>
			</tr>	
		</form>
	</body>
</html>