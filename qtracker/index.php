<!--
     Author: Krzysztof Hrybacz <krzysztof@zygtech.pl>
     License: GNU General Public License -- version 3
-->
<html>
<head>
	<title>Query Popularity Tracker</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
	<style>
		body { font-family: serif; font-size: 16; }
		input,select,label { font-family: sans; font-size: 14px; }
		a { text-decoration: none; color: #000000; }
		a:hover { text-decoration: underline; }
	</style>
</head>
<body>
	<center>
<?php
require_once('config.php');
$dir=scandir($installdir . '/names');
foreach ($dir as $file)
	if ($file!='.' && $file!='..') 
		$names[explode('.',$file)[0]]=trim(file($installdir . '/names/' . $file)[0]);
?>
	<form>
		<label>PLACE:</label>
		<select style="width: 909px;" name="id">
		<option disabled<?php if ($_GET['id']=='') echo ' selected'; ?>>CHOOSE LOCALIZATION</option>
		<?php
		foreach ($names as $key=>$line) {
			echo '<option value="' . $key . '"';
			if ($key==$_GET['id'])
				echo ' selected';
			echo '>' . $line . '</option>';
		}
		?>
		</select>
		<label>HOUR:</label>
		<select name="hour">
		<?php
		for ($i=$minhour;$i<=$maxhour;$i++) {
			echo '<option value="' . $i . '"';
			if ($i==$_GET['hour'])
				echo ' selected';
			echo'>' . $i . ':00</option>';
		}
		?>
		</select>
		<input type="submit" value="CHART" /> <a style="font-family: sans; font-size: 14px;" href="./">RESET</a>
	</form><br />
	<?php
	if ($_GET['id']!='' && $_GET['hour']!='') {;
		$lines=file($installdir . '/places/' . $_GET['id'] . '.txt');
		foreach ($lines as $line)
			if ($_GET['hour']==substr(explode(' ',$line)[1],0,2)) {
				$chart[]=round(floatval(substr(explode(' ',$line)[2],0,strlen(explode(' ',$line)[2])-1)),2);
				$label[]=explode(' ',$line)[0];
			}
		$data = json_encode($chart);
		$labels = json_encode($label);
		?>
		<a href="xlsx.php?id=<?php echo $_GET['id']; ?>">EXPORT ALL HOURS TO EXCEL</a>
		<div style="width: 1280px; height: 720px;"><canvas id="myChart" width="1280" height="720"></canvas></div>
<script>
var ctx = document.getElementById('myChart');
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
		labels:  <?php echo $labels; ?>,
		datasets: [{ 
			label: "Popularity",
			backgroundColor: 'rgba(0, 0, 255, 0.5)',
			borderColor: 'rgba(0, 0, 255, 0.8)',
			borderWidth: 1,
			data: <?php echo $data; ?>
		}]
	},
    options: {
		responsive: true,
		maintainAspectRatio: false,
		legend: {
			position: 'bottom',
		},
        title: {
            display: true,
            text: "Statistics at <?php echo $_GET['hour']; ?>:00"
        },
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 100
                }
            }]
        }
    }
});
</script>
	<?php
	} else echo '<a href="xlsx.php">EXPORT ALL DATA TO EXCEL</a>';
	?>
	</center>
</body>
</html>
