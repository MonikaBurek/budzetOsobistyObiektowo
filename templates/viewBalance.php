<?php if(!isset($this)) die(); ?>
<div class="viewBalanceDiv" onload="createPieChart()"> 
	<div class="row text-center">
	    <div class="col-md-4 col-md-offset-2 bg3">	
		    <?php echo $tableIncomes ?>
		</div>
	    <div class="col-md-1"></div>
		<div class="col-md-4 bg3">
            <?php echo $tableExpenses ?>
		</div>	
		<div class="col-md-1"></div>
	</div>
    <div class="row emptyRow"></div>
								
	<div class="row ">
		<div class="col-md-6  col-sm-12 col-md-offset-3 ">
				
<script>
function createPieChart () 
{
	var chart = new CanvasJS.Chart("chartContainer", {
				exportEnabled: true,
				animationEnabled: true,
				title:{
					text: "Zestawienie wydatków w danym okresie."
				},
				legend:{
					cursor: "pointer",
					itemclick: explodePie
				},
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} (#percent%)",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			
	chart.render();
	chart.title.set("fontSize", 24);
	chart.title.set("fontColor", "#092834", false);
	chart.legend.set("fontSize", 16);
}

function explodePie (e) 
{
			if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
			} else {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
			}
			e.chart.render();

}
</script>	
							
<?php		
	if ($noExpenses == false)
		echo '<div id="chartContainer"></div>';
?>
							
		</div>
		<div class="col-md-3"></div>
	</div>
					
    <div class="row emptyRow"></div>				
				
	<div class="row">
		<div class="col-md-6 col-md-offset-3 bg7">
			<div class="col-md-5">Suma przychodów [zł]:</div>
			<div class="col-md-4">
				<div class="well well-sm wellResult">
					<?php echo $sumIncomes ?>
		        </div>
			</div>	
			<div class="col-md-3"></div>	
		</div>
		<div class="col-md-3"></div>
	</div>
					
	<div class="row ">
		<div class="col-md-6 col-md-offset-3 bg7 ">
			<div class="col-md-5">Suma wydatków [zł]:</div>
			<div class="col-md-4">
				<div class="well well-sm wellResult">
				   <?php echo $sumExpenses ?>
				</div>
			</div>	
			<div class="col-md-3"></div>	
		</div>
		<div class="col-md-3"></div>
	</div>
					
	<div class="row ">
		<div class="col-md-6 col-md-offset-3 bg7 ">
		    <div class="col-md-3 col-md-offset-2">Różnica:</div>
			<div class="col-md-3">
				<div class="well well-sm wellFinalResult">
				    <div id="differenceNumber">
						<?php
						$difference = $sumIncomes - $sumExpenses;
						echo number_format($difference,2,'.', '');
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4"></div>	
		</div>
		<div class="col-md-3"></div>
	</div>
	
	<div class="row ">
		<div class="col-md-6 col-md-offset-3 bg7">
			<div class="col-md-6 col-md-offset-3 bg8">
				<div id="differenceText"></div>
				<button class="btnSave" onclick="displayText()">Sprawdź czy dobrze zarządzasz finasami?</button>
				<script src="js/functionDisplayText.js"></script>
			</div>
			<div class="col-md-3 "></div>
		</div>	
		<div class="col-md-3 "></div>	
	</div>
					
	<div class="row emptyRow"></div>
</div>