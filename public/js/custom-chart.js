



// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart', 'bar']});


// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(pie_Chart_1);
google.charts.setOnLoadCallback(bar_chart);
google.charts.setOnLoadCallback(line_chart);



// Start Pie Chart
function pie_Chart_1() {

	// Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      ['Mushrooms', 2],
      ['Onions', 2],
      ['Olives', 2],
      ['Zucchini', 2],
      ['Pepperoni', 2]
    ]);


    // Set chart options
    var options = {
    	'title':'How Much Pizza I Ate Last Night',
    	height: 500
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie-chart-1'));
    chart.draw(data, options);


}


// Start Column Chart
function bar_chart() {

	var data = google.visualization.arrayToDataTable([
      	['Year', 'Sales'],
        ['2006', 900],
        ['2007', 800],
        ['2008', 700],
        ['2009', 850],
      	['2010', 1000],
      	['2011', 1170],
      	['2012', 660],
      	['2013', 660],
        ['2014', 1030],
        ['2015', 1230],
        ['2016', 1330],
        ['2017', 1430],
      	['2018', 1530]
    ]);

  	var options = {
      	chart: {
        	title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
      	},
      	colors: ['#314258'],
        bar: {groupWidth: "75%"},
        height: 600
    };


    var chart = new google.charts.Bar(document.getElementById('sale-column-chart'));
    chart.draw(data, google.charts.Bar.convertOptions(options));

}



//Start Line Chart
function line_chart() {

	var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Expenses'],
        ['2004',  1000,      400],
        ['2005',  1170,      460],
        ['2006',  660,       1120],
        ['2007',  1030,      540]
    ]);

    var options = {
        title: 'Company Performance',
        curveType: 'function',
        legend: { position: 'bottom' },
        height: 500
    };

	var chart = new google.visualization.LineChart(document.getElementById('line-chart'));
    chart.draw(data, options);
}