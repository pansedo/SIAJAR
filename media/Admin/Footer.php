	<script src="../Assets/js/lib/jquery/jquery.min.js"></script>
	<script src="../Assets/js/lib/tether/tether.min.js"></script>
	<script src="../Assets/js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="../Assets/js/plugins.js"></script>
	<script type="text/javascript" src="../Assets/js/lib/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../Assets/js/lib/lobipanel/lobipanel.min.js"></script>
	<script type="text/javascript" src="../Assets/js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="../Assets/js/jquery.uploadPreview.min.js"></script>
	<script src="../Assets/js/lib/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="../Assets/js/lib/select2/select2.full.min.js"></script>
	<script src="../Assets/js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
	<script src="../Assets/js/lib/jquery-tag-editor/jquery.tag-editor.min.js"></script>

<!--  -->
	<script src="../Assets/js/lib/ladda-button/spin.min.js"></script>
	<script src="../Assets/js/lib/ladda-button/ladda.min.js"></script>
	<script src="../Assets/js/lib/ladda-button/ladda-button-init.js"></script>
<!--  -->
	<script src="../Assets/js/lib/uploadfile/custom-file-input.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
		  $.uploadPreview({
		    input_field: "#image-upload",
		    preview_box: "#image-preview",
		    label_field: "#image-label"
		  });
		}); 
	</script>
	<script type="text/javascript">
		$(function() {
			$('#tags-editor-textarea').tagEditor();
		});
		$('#option').change(function() {
		    opt = $(this).val();
		    if (opt=="0") {
		        $('#data').html('<h2>Pilihan</h2>');
		    }else if (opt == "opt1") {
		        $('#data').html('<fieldset class="form-group"> <label class="form-label">Tautan</label> <input type="text" class="form-control maxlength-simple" id="tautan" name="tautan" placeholder="Tautan" > </fieldset>');
		    }else if (opt == "opt2") {
		        $('#data').html('<div class="box" style="padding-top: 5%;"> <input hidden="true" type="file" name="dokumen" id="file-7" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple /> <label for="file-7"><span></span> <strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> Choose a file&hellip;</strong></label></div>');
		    }
		});
	</script> 
	<script>
		$(document).ready(function(){
			$('.panel').lobiPanel({
				sortable: true
			});
			$('.panel').on('dragged.lobiPanel', function(ev, lobiPanel){
				$('.dahsboard-column').matchHeight();
			});

			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('string', 'Day');
				dataTable.addColumn('number', 'Values');
				// A column for custom tooltip content
				dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
				dataTable.addRows([
					['MON',  130, ' '],
					['TUE',  130, '130'],
					['WED',  180, '180'],
					['THU',  175, '175'],
					['FRI',  200, '200'],
					['SAT',  170, '170'],
					['SUN',  250, '250'],
					['MON',  220, '220'],
					['TUE',  220, ' ']
				]);

				var options = {
					height: 314,
					legend: 'none',
					areaOpacity: 0.18,
					axisTitlesPosition: 'out',
					hAxis: {
						title: '',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						textPosition: 'out'
					},
					vAxis: {
						minValue: 0,
						textPosition: 'out',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						baselineColor: '#16b4fc',
						ticks: [0,25,50,75,100,125,150,175,200,225,250,275,300,325,350],
						gridlines: {
							color: '#1ba0fc',
							count: 15
						},
					},
					lineWidth: 2,
					colors: ['#fff'],
					curveType: 'function',
					pointSize: 5,
					pointShapeType: 'circle',
					pointFillColor: '#f00',
					backgroundColor: {
						fill: '#008ffb',
						strokeWidth: 0,
					},
					chartArea:{
						left:0,
						top:0,
						width:'100%',
						height:'100%'
					},
					fontSize: 11,
					fontName: 'Proxima Nova',
					tooltip: {
						trigger: 'selection',
						isHtml: true
					}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(dataTable, options);
			}
			$(window).resize(function(){
				drawChart();
				setTimeout(function(){
				}, 1000);
			});
		});
	</script>
	<script src="../Assets/js/lib/datatables-net/datatables.min.js"></script>
	<script>
		$(function() {
			var table = $('#datatable').DataTable({
				scrollX:        true,
				scrollCollapse: true,
				paging:         true,
				fixedColumns:   true
			});

			setTimeout(function() {
				table.draw();
			}, 50);

		});
	</script>
<script src="../Assets/js/app.js"></script>
</body>
</html>