google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawCrosshairs);
function drawCrosshairs() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'X');
	data.addColumn('number', 'Unikalni użytkownicy');
	data.addRows(ajaxRequest());	

	var options = {
		hAxis: {
			title: 'Czas'
		},
        vAxis: {
			title: 'Odwiedziny'
        },
        colors: ['#a52714', '#097138'],
        crosshair: {
			color: '#000',
			trigger: 'selection'
        }
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

	$("#chart_div").html("");
	chart.draw(data, options);
	chart.setSelection([{row: 38, column: 1}]);
}

function ajaxRequest(){
	var array;
	$.ajax({
		url: "ajax/pageViewChartData.php",
		type: "POST",
		async: false,
		data: false,
		success: function(data){
			var arr = eval("[" + data + "]");
			array = arr;
		}
	});
	return array;
}