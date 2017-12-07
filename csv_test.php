<?php
require_once("csv.php");
/*
*	Enable this to prevent csv from reporting
*	error in case a file does not exist in read mode
*/
//error_reporting(0);


//To write to a csv file
$c=new CSV('table.csv',CSV::write);
if($c->is_open()){
	//Write multiline value to csv file
	$c->write(array(array('Name','Sex','Age'),array('Dave','Male','50')));
	//Write single line value to csv file
	$c->write_line(array('Nathan','Male','54'));
	//or just set $c=null to close
	$c->close();
}
else
	echo "Can't open file for writing";
//To read a csv file
//CSV::read is optional
$c=new CSV('table.csv',CSV::read);
if($c->is_open()){
	echo '<table border="1">';
			/*while($arr=$c->read_line()){
				echo '<tr>';
					foreach($arr as $val)
						echo "<td>$val</td>";
				echo '</tr>';
			}*/
			$value=$c->read();
			foreach($value as $arr){
				echo '<tr>';
					foreach($arr as $val)
						echo "<td>$val</td>";
				echo '</tr>';
			}
	echo '</table>';
	
}
else
	echo "Can't open file for reading";


//To append to a csv file
$c=new CSV('table.csv',CSV::append);
if($c->is_open()){
	//Append multiline value to csv file
	$c->append(array(array('israel','Male','30'),array('Dave','Male','50')));
	//Append single line value to csv file
	$c->append_line(array('Nathan','Male','54'));
	//or just set $c=null to close
	$c->close();
}
else
	echo "Can't open file for Appending";

?>