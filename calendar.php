<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

.block-on-center {
	position: absolute;
	top: 3%;
	left: 3%;
 
}

.cal{
	border: 1px solid #ccc;
	color: #333;
	background: #F6F6F6;
	font: Arial;
	font-size: 14px;
	text-align: center;}

.caltoday{
	font: Arial;
	font-size: 14px;
	text-align: center;
	font-weight: bold;
	color: #ccc;
	text-align: center;
}

.navi{
	font: Arial;
	font-size: 16px;
	font-weight: bold;
	
}

.navi a{
	text-decoration: none;
}

.datehead{
	font: Arial;
	font-size: 16px;
	font-weight: bold;
	color: #fff;
}

.dateheadGroupe{
	text-align: center;
}

.img{
	margin-left: 50px;
}



</style>
<title>Календарь</title>
</head>
<body>
<?php

// местоположение скрипта
$self = $_SERVER['PHP_SELF'];

// проверяем, если в переменная month была установлена в URL-адресе,
//либо используем PHP функцию date(), чтобы установить текущий месяц.
if(isset($_GET['month'])) 
	$month = $_GET['month'];
elseif(isset($_GET['viewmonth'])) 
	$month = $_GET['viewmonth'];
else 
	$month = date('m');

// Теперь мы проверим, если переменная года устанавливается в URL,
//либо использовать PHP функцию date(),
//чтобы установить текущий год, если текущий год не установлен в URL-адресе.
if(isset($_GET['year'])) 
	$year = $_GET['year'];
elseif(isset($_GET['viewyear'])) 
	$year = $_GET['viewyear'];
else 
	$year = date('Y');

if($month == '12') 
	$next_year = $year + 1;
else 
	$next_year = $year;
	
	
$Month_r = array(
"1" => "January",
"2" => "February",
"3" => "March",
"4" => "April",
"5" => "May",
"6" => "June",
"7" => "July",
"8" => "August",
"9" => "September",
"10" => "October",
"11" => "November",
"12" => "December"); 

$first_of_month = mktime(0, 0, 0, $month, 1, $year);

// Массив имен всех дней в неделю
$day_headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

$maxdays = date('t', $first_of_month);
$date_info = getdate($first_of_month);
$month = $date_info['mon'];
$year = $date_info['year'];

// Если текущий месяц это январь,
//и мы пролистываем календарь задом наперед число,
//обозначающее год, должно уменьшаться на один. 
if($month == '1') 
	$last_year = $year-1;
else 
	$last_year = $year;

// Вычитаем один день с первого дня месяца,
//чтобы получить в конец прошлого месяца
$timestamp_last_month = $first_of_month - (24*60*60);
$last_month = date("m", $timestamp_last_month);

// Проверяем, что если месяц декабрь,
//на следующий месяц равен 1, а не 13
if($month == '12') 
	$next_month = '1';
else 
	$next_month = $month+1;
	
$calendar = "
<div class=\"block-on-center\">
<table width='390px' height='280px' style='border: 1px solid #cccccc';>
    <tr style='background: #bdc3c7;'>
        <td colspan='7' class='navi'>
            <a style='margin-right: 50px; color: #ffffff;' href='$self?month=".$last_month."&year=".$last_year."'> <img class='img' src=\"https://img.icons8.com/cotton/30/000000/circled-left-2.png\"/> </a>
           ".$Month_r[$month]." ".$year."
            <a style='margin-left: 50px; color: #ffffff;' href='$self?month=".$next_month."&year=".$next_year."'> <img src=\"https://img.icons8.com/cotton/30/000000/circled-right--v1.png\"/> </a>
        </td>
    </tr>
    <tr class='dateheadGroupe'>
        <td class='datehead' title='Monday'>M</td>
        <td class='datehead' title='Tuesday'>T</td>
        <td class='datehead' title='Wednesday'>W</td>
        <td class='datehead' title='Thursday'>T</td>
        <td class='datehead' title='Friday'>F</td>
        <td class='datehead' title='Saturday'>S</td>
		<td class='datehead' title='Sunday'>S</td>
    </tr>
    <tr>"; 

// очищаем имя класса css
$class = "";

$weekday = $date_info['wday'];

// Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
$weekday = $weekday-1; 
if($weekday == -1) $weekday=6;

// станавливаем текущий день как единица 1
$day = 1;

// выводим ширину календаря
if($weekday > 0) 
	$calendar .= "<td colspan='$weekday'> </td>";
	
while($day <= $maxdays)
{
	// если суббота, выволдим новую колонку.
    if($weekday == 7) {
		$calendar .= "</tr><tr>";
		$weekday = 0;
	}
	
	$linkDate = mktime(0, 0, 0, $month, $day, $year);

	// проверяем, если распечатанная дата является сегодняшней датой.
	//если так, используем другой класс css, чтобы выделить её 
    if((($day < 10 and "0$day" == date('d')) or ($day >= 10 and "$day" == date('d'))) and (($month < 10 and "0$month" == date('m')) or ($month >= 10 and "$month" == date('m'))) and $year == date('Y'))
	     $class = "caltoday";
		 
	//в противном случае, печатаем только ссылку на вкладку
    else {
		$d = date('m/d/Y', $linkDate);

	    $class = "cal";
	}
	
	//помечаем выходные дни красным
	if($weekday == 5 || $weekday == 6) $red='style="color: red" ';
	else $red=''; 	 
	
    $calendar .= "
        <td class='{$class}'><span ".$red.">{$day}</span>
        </td>";
    $day++;
    $weekday++;	
}

if($weekday != 7) 
	$calendar .= "<td colspan='" . (7 - $weekday) . "'> </td>";

// выводим сам календарь
echo $calendar . "</tr></table>"; 

$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

echo "<form style='float: right; margin-right: 10px;' action='$self' method='get'><select name='month'>";
	
for($i=0; $i<=11; $i++) {
	echo "<option value='".($i+1)."'";
	if($month == $i+1) 
		echo "selected = 'selected'";
	echo ">".$months[$i]."</option>";
}
		
echo "</select>";
echo "<select name='year'>";

for($i=date('Y'); $i<=(date('Y')+20); $i++)
{
	$selected = ($year == $i ? "selected = 'selected'" : '');
	
	echo "<option value=\"".($i)."\"$selected>".$i."</option>";
}

echo "</select><input type='submit' value='Watch' /></form>";

if($month != date('m') || $year != date('Y'))
	echo "<a style='float: left; margin-left: 18px; font-size: 18px; padding-top: 5px; color: #ccc999 ' href='".$self."?month=".date('m')."&year=".date('Y')."'> <img style=' padding-right: 7px; padding-top: 5px; ' src=\"https://img.icons8.com/flat_round/20/000000/rotate-left--v1.png\"/> Back to date...</a>";
echo "</div>"; 

?>
</body>
</html>