<!DOCTYPE html>
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Alex+Brush' rel='stylesheet' type='text/css'>
    <style>
        body {
            text-align: center;
        }
        table {
            display:inline-block;
            vertical-align:top;
            margin-bottom:20px;
            margin-right: 20px;
        }
        td.table-headers {
            background: tomato;
        }
        td {
            width:40px;
            height: 40px;
            text-align: center;
            border:1px solid black;
            font-family: 'Alex Brush', cursive;
            font-size:23px;
            background: #FF9900;
        }
        tr.table-header-row {
            background:tomato;
        }
        div.year-welcome-msg {
            font-family: 'Alex Brush', cursive;
            text-align: center;
            font-size: 50px;
        }
        thead.month-text {
            font-family: 'Alex Brush', cursive;
            font-size:30px;
        }
        td.table-cells-weekends {
            background: red;
        }
    </style>
</head>
<body>

<?php
date_default_timezone_set("Europe/Sofia");

function draw_calendar($month, $year){
    //that string will contain the table and everything in it, we`ll add cells and rows to it
    $calendar = '<table><thead class="month-text"><th colspan="7">' .date('M', mktime(0, 0, 0, $month, 1, $year)) . '</th></thead>';
    $counter = 1;
    //contans all headers that will be the same for every month
    $headers = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    //we have to add these headings to the table using concatenation
    $calendar .= '<tr class="table-header-row"><td class="table-headers">' . implode('</td><td class="table-headers">', $headers) . '</td></tr>';

    /* numeric representations of the days of the week */
    $days_of_the_week = date('w', mktime(0, 0, 0, $month, 1, $year));
    /* total days in a month - 28 to 31 */
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

    //let`s print blank cells until the first day of the week - today is thursday so from 0 to 3 it will print blank cells
    $calendar .= '<tr class="calendar-row">';

    for($i = 0; $i < $days_of_the_week ;$i++) {
        $calendar .= '<td class="empty-cells"> </td>';
    }

    //continue for the rest of the days
    for($i = $days_of_the_week; $i <= $days_in_month ;$i++) {
        if($days_of_the_week == 0 || $days_of_the_week == 6) {
            $calendar .= '<td class="table-cells-weekends">';
        }
        else {
            $calendar .= '<td class="table-cells">';
        }
        $calendar .= '<div class="table-cell-info">' . $counter . '</div>';
        $calendar .= '</td>';

        if($days_of_the_week == 6) {
            $calendar .= '</tr>';
            $days_of_the_week = -1;
            if($counter != $days_in_month) {
                $i--;
            }

        }
        $counter++;
        if($counter > $days_in_month) {
            break;
        }
        $days_of_the_week++;
    }
    $calendar .= '</tr></table>';

    return $calendar;
}

$inputYear = 2014;
echo '<div class="year-welcome-msg">' . $inputYear . '</div>';
for($i = 1; $i <= 12 ;$i++) {
    echo draw_calendar($i, $inputYear);
}

?>

</body>
</html>