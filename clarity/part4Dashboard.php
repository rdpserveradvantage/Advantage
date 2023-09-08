<? include('config.php');
// header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Kolkata');

$datetimeString = '2023-08-02 18:10:19';
$timestamp = strtotime($datetimeString) * 1000; // Convert to Unix timestamp in milliseconds

echo $timestamp;
echo '<br>';

$atmid = 'S1BW006240024';
$sql = mysqli_query($con, "SELECT * FROM event_log WHERE atmid='".$atmid."' ORDER BY event_timestamp ASC");

$data = []; // Initialize an empty array to hold the chart data
$prevEventTimestamp = null;

while ($sql_result = mysqli_fetch_assoc($sql)) {
    $eventName = $sql_result['event_name'];
    echo $sql_result['event_timestamp'] ; 
    echo ' '.$event_timestamp = strtotime($sql_result['event_timestamp']) * 1000; // Convert to milliseconds
echo '<br />';
    // Calculate completed amount based on the difference with the previous event's timestamp
    $completionAmount = 1.0; // Default value for the last event

    if ($prevEventTimestamp !== null) {
        $timeDifference = ($event_timestamp - $prevEventTimestamp) / (24 * 60 * 60 * 1000); // Convert to days
        $completionAmount = $timeDifference / 7; // Assuming 1 week duration for 100% completion
        $completionAmount = min(1.0, $completionAmount); // Ensure it doesn't exceed 100%
    }

    $dataItem = [
        'start' => $event_timestamp,
        'end' => $event_timestamp, // You can adjust this based on your use case
        'completed' => [
            'amount' => $completionAmount
        ],
        'name' => $eventName
    ];

    $data[] = $dataItem; // Add the data item to the array

    $prevEventTimestamp = $event_timestamp; // Store the current event timestamp for the next iteration
}


return ; 

var_dump($data); // Output the array as JSON for use in the Highcharts configuration

// return ; 

?>

<html lang="en"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@200;300;400;500;600;700&display=swap');
#container,
#button-container {
    max-width: 800px;
    margin: 1em auto;
}

#pdf {
    border: 1px solid silver;
    border-radius: 3px;
    background: #a4edba;
    padding: 0.5em 1em;
}

#pdf i {
    margin-right: 1em;
}

body {
    max-width: 100%;
    margin: 0;
    font-family: "IBM Plex Sans",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    box-sizing: border-box;
}
hr {
    all: initial;
}
p.highcharts-description {
    background-color: #FFF;
    padding: 0.5em;
    margin: 0;
}
p.highcharts-description code {
    background-color: #EBEBEB;
    color: #9E0000;
}
</style>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css">
</head>
<body>
<script src="https://code.highcharts.com/gantt/highcharts-gantt.js"></script>
<script src="https://code.highcharts.com/gantt/modules/exporting.js"></script>
<script src="https://code.highcharts.com/gantt/modules/accessibility.js"></script>

<div id="container"></div>


<div id="button-container">
	<button id="pdf">
		<i class="fa fa-download"></i> Download PDF
	</button>
</div>
<script id="theme-script" src=""></script>
<script defer="">
Highcharts.ganttChart('container', {

    title: {
        text: 'Highcharts Gantt Chart'
    },

    yAxis: {
        uniqueNames: true
    },

    accessibility: {
        point: {
            descriptionFormat: '{yCategory}. ' +
                '{#if completed}Task {(multiply completed.amount 100):.1f}% completed. {/if}' +
                'Start {x:%Y-%m-%d}, end {x2:%Y-%m-%d}.'
        }
    },

    lang: {
        accessibility: {
            axis: {
                xAxisDescriptionPlural: 'The chart has a two-part X axis showing time in both week numbers and days.'
            }
        }
    },

    series: [{
        name: 'Project 1',
        data: <? echo json_encode($data); ?>
    }]
});

// Activate the custom button
document.getElementById('pdf').addEventListener('click', function () {
    Highcharts.charts[0].exportChart({
        type: 'application/pdf'
    });
});

</script>
<script defer="">
function messageParent(state = 'iframe-resized'){
    window.parent.postMessage({
        name: state,
        boundingRect: window.document.documentElement.getBoundingClientRect(),
    }, '*');
}

const resizeObserver = new ResizeObserver((entries) => {
  messageParent();
});

resizeObserver.observe(window.document.documentElement)

</script>

</body></html>