<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Contributions'],
          <?php echo $chartData ?>
          
        ]);

        var options = {
          title: 'Monthly Contributions',
          pieSliceText: 'label',
          slices: {  2: {offset: 0.2},
                  4: {offset: 0.3},
                  6: {offset: 0.2},
                  8: {offset: 0.3},
                  10: {offset: 0.4},

          },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>