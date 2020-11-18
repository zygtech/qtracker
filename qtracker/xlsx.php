<!--
     Author: Krzysztof Hrybacz <krzysztof@zygtech.pl>
     License: GNU General Public License -- version 3
-->
<?php
	require_once('config.php');
	require_once('SimpleXLSXGen.php');
	if ($_GET['id']!='') {
		$excel=array();
		$row=array();
		$row[]='Date';
		for ($i=$minhour;$i<=$maxhour;$i++)
			$row[]=$i . ':00';
		$excel[]=$row;
		$lines=file($installdir . '/places/' . $_GET['id'] . '.txt');
		$l=intval(substr(explode(' ',$lines[0])[1],0,2));
		$row=array();
		for ($i=0;$i<$l-$minhour;$i++)
			$row[]=0;
		foreach ($lines as $line) {
			$row[]=round(floatval(substr(explode(' ',$line)[2],0,strlen(explode(' ',$line)[2])-1)),2);
			$l++;
			if ($l==$maxhour+1) {
				array_unshift($row,explode(' ',$line)[0]);
				$excel[]=$row;
				$l=$minhour;
				$row=array();
			}
		}
		if ($l>$minhour) {
				array_unshift($row,explode(' ',$line)[0]);
				$excel[]=$row;
		}
		$xlsx = SimpleXLSXGen::fromArray( $excel );
		$xlsx->downloadAs('PlaceStats.xlsx');
	} else {
		$dir=scandir($installdir . '/names');
		foreach ($dir as $file)
			if ($file!='.' && $file!='..') 
				$names[explode('.',$file)[0]]=trim(file($installdir . '/names/' . $file)[0]);
		$excel=array();
		$row=array();
		$row[]='Localization';
		$row[]='Date';
		for ($i=$minhour;$i<=$maxhour;$i++)
			$row[]=$i . ':00';
		$excel[]=$row;
		foreach ($names as $key=>$name) {
			$lines=file($installdir . '/places/' . $key . '.txt');
			$l=intval(substr(explode(' ',$lines[0])[1],0,2));
			$row=array();
			for ($i=0;$i<$l-$minhour;$i++)
				$row[]=0;
			foreach ($lines as $line) {
				$row[]=round(floatval(substr(explode(' ',$line)[2],0,strlen(explode(' ',$line)[2])-1)),2);
				$l++;
				if ($l==$maxhour+1) {
					array_unshift($row,explode(' ',$line)[0]);
					array_unshift($row,$name);
					$excel[]=$row;
					$l=$minhour;
					$row=array();
				}
			}
			if ($l>$minhour) {
				array_unshift($row,explode(' ',$line)[0]);
				array_unshift($row,$name);
				$excel[]=$row;
			}
		}
		$xlsx = SimpleXLSXGen::fromArray( $excel );
		$xlsx->downloadAs('GlobalStats.xlsx');
}
?>
