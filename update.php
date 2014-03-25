
<h1>Update data for Run Number: <?=$_GET['run_Number']?></h1>

<form name="updateTime" method="POST" action="class.Timetable.php">
	<table class="dataTable">
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