<?
require("shared.inc");
if(!strstr($MYSITE,"bugs.php.net")) {
        Header("Location: http://bugs.php.net/bugstats.php");
		exit;
}

	if ($ver != 4 and $ver != 3) {
		$ver = 0;
	}

	function mydate($str) {
		$year = substr($str,0,4);
		$month = substr($str,5,2);
		$day = substr($str,8,2);
		$hour = substr($str,11,2);
		$min = substr($str,14,2);
		$sec = substr($str,17,2);
		return mktime($hour,$min,$sec,$month,$day,$year);
	}

	function ShowTime($sec) {
		if($sec<60) {
			return "$sec seconds";
		} else if($sec<120) {
			return (int)($sec/60)." minute ".($sec%60)." seconds";
		} else if($sec<3600) {
			return (int)($sec/60)." minutes ".($sec%60)." seconds";
		} else if($sec<7200) {
			return (int)($sec/3600)." hour ".(int)(($sec%3600)/60)." minutes ".(($sec%3600)%60)." seconds";
		} else if($sec<86400) {
			return (int)($sec/3600)." hours ".(int)(($sec%3600)/60)." minutes ".(($sec%3600)%60)." seconds";
		} else if($sec<172800) {
			return (int)($sec/86400)." day ".(int)(($sec%86400)/3600)." hours ".(int)((($sec%86400)%3600)/60)." minutes ".((($sec%86400)%3600)%60)." seconds";
		} else {
			return (int)($sec/86400)." days ".(int)(($sec%86400)/3600)." hours ".(int)((($sec%86400)%3600)/60)." minutes ".((($sec%86400)%3600)%60)." seconds";
		}
	}

	commonHeader("Bug Stats");

	if ($ver > 0) {
		$other = ($ver == 4 ? 3 : 4);
		echo '<p>Currently displaying PHP'. $ver . ' bugs only. Display <a href="bugstats.php">all bugs</a> or <a href="bugstats.php?version=' . $other . '">only PHP' . $other . ' bugs</a>.</p>' . "\n";
	}
	else {
		echo '<p>Currently displaying all bugs. Display <a href="bugstats.php?version=3">only PHP3 bugs</a> or <a href="bugstats.php?version=4">only PHP4 bugs</a>.</p>' . "\n";
	
	}
	
	mysql_connect("localhost","nobody","");
	mysql_select_db("php3");

	$query = "SELECT * from bugdb";

	if ($ver > 0) {
		$query .= " WHERE php_version LIKE '" . $ver . "%'";
	}

	$result=mysql_query($query);
	while($row=mysql_fetch_row($result)) {
		$bug_type['all'][$row[1]]++;
		if($row[7]=="Open") {
			$bug_type['open'][$row[1]]++;
			$bug_type['open']['all']++;
		}
		if($row[7]=="Analyzed") {
			$bug_type['analyzed'][$row[1]]++;
			$bug_type['analyzed']['all']++;
		}
		if($row[7]=="Feedback") {
			$bug_type['feedback'][$row[1]]++;
			$bug_type['feedback']['all']++;
		}
		if($row[7]=="Suspended") {
			$bug_type['suspended'][$row[1]]++;
			$bug_type['suspended']['all']++;
		}
		if($row[7]=="Duplicate") {
			$bug_type['duplicate'][$row[1]]++;
			$bug_type['duplicate']['all']++;
		}
		if($row[7]=="Assigned") {
			$bug_type['assigned'][$row[1]]++;
			$bug_type['assigned']['all']++;
		}
		$email[$row[2]]++;
		$php_version[$row[5]]++;
		$php_os[$row[6]]++;
		$status[$row[7]]++;
		if($row[7]=="Closed") {
			$bug_type['closed'][$row[1]]++;
			$bug_type['closed']['all']++;
			if (mydate($row[10]) > mydate($row[9])) {
				$time_to_close[] = mydate($row[10]) - mydate($row[9]);
			}
			$closed_by[$row[11]]++;
		}
		$total++;
	}

	function bugstats($status, $type) {
		global $bug_type, $ver;
		if ($bug_type[$status][$type] > 0) {
			if ($ver == 4) {
				$page = "bugs.php";
			}
			else {
				$page = "bugs-php3.php";
			}
			return '<A href="/' . $page . '?cmd=Display+Bugs&status=' . ucfirst($status) . '&bug_type=' . ($type == 'all' ? 'Any' : urlencode($type)) . '&by=Any">' . $bug_type[$status][$type] . "</A>\n";
		}
	}

	mysql_freeresult($result);
	echo "<table>\n";

	echo "<tr bgcolor=#aabbcc><th align=right>Total bug entries in system:</th><td>$total</td><th>Closed</th><th>Open</th><th>Analyzed</th><th>Suspended</th><th>Duplicate</th><th>Assigned</th><th>Feedback</th></tr>\n";

	echo "<tr><th align=right bgcolor=#aabbcc>All:</th><td align=center bgcolor=#ccddee>$total</td><td align=center bgcolor=#ddeeff>".bugstats('closed', 'all')."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('open', 'all')."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('analyzed', 'all')."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('suspended','all')."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('duplicate', 'all')."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('assigned','all')."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('feedback','all')."&nbsp;</td></tr>\n";

	while(list($type,$value)=each($bug_type['all'])) {
		echo "<tr><th align=right bgcolor=#aabbcc>$type:</th><td align=center bgcolor=#ccddee>$value</td><td align=center bgcolor=#ddeeff>".bugstats('closed', $type)."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('open', $type)."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('analyzed', $type)."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('suspended',$type)."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('duplicate', $type)."&nbsp;</td><td align=center bgcolor=#ccddee>".bugstats('assigned',$type)."&nbsp;</td><td align=center bgcolor=#ddeeff>".bugstats('feedback',$type)."&nbsp;</td></tr>\n";
	}
	echo "</table>\n";
	
	sort($time_to_close);
	$c=count($time_to_close);
	$sum=0;
	for($i=0;$i<$c;$i++) {
		$sum+=$time_to_close[$i];
	}
	$median = $time_to_close[(int)($c/2)];

	echo "<p><b>Bug Report Time to Close Stats</b>\n";
	echo "<table>\n";
	echo "<tr bgcolor=#aabbcc><th align=right>Average life of a report:</th><td bgcolor=#ccddee>".ShowTime((int)($sum/$c))."</td></tr>\n";
	echo "<tr bgcolor=#aabbcc><th align=right>Median life of a report:</th><td bgcolor=#ccddee>".ShowTime($median)."</td></tr>\n";
	echo "<tr bgcolor=#aabbcc><th align=right>Slowest report closure:</th><td bgcolor=#ccddee>".ShowTime($time_to_close[$c-1])."</td></tr>\n";
	echo "<tr bgcolor=#aabbcc><th align=right>Quickest report closure:</th><td bgcolor=#ccddee>".ShowTime($time_to_close[0])."</td></tr>\n";
	echo "</table>\n";
	arsort($closed_by);
	echo "<p><b>Who is closing the bug reports?</b>\n";
	echo "<table>\n";
	while(list($who,$value)=each($closed_by)) {
		echo "<tr bgcolor=#aabbcc><th>$who</th><td bgcolor=#ccddee>$value</td></tr>\n";
	}
	echo "</table>\n";

	arsort($email);
	echo "<p><b>Who is submitting bug reports?</b>\n";
	echo "<table>\n";
	while(list($who,$value)=each($email)) {
		if ($value > 2) {
			echo "<tr bgcolor=#aabbcc><th>$who</th><td bgcolor=#ccddee>$value</td></tr>\n";
		}
	}
	echo "</table>\n";

	commonFooter();
?>
