/** @format */
$(document).ready(function () {
	var cantidadComentariosPersona = [];
	// Create chart instance
	var chart = am4core.create('chartdiv', am4charts.XYChart);
	$.ajax({
		url: 'report/ajaxCantidadComentarioPersona',
		type: 'get',
		dataType: 'json',
	})
		.done(function (respuesta) {
			if (typeof respuesta.exito !== 'undefined') {
				respuesta.cantidad_comentarios.forEach(function (elemento, indice, array) {
					cantidadComentariosPersona.push({
						name: elemento.nombres,
						points: elemento.total_comentario,
						color: chart.colors.next(),
						bullet: 'https://www.amcharts.com/lib/images/faces/A04.png',
					});
				});
				am4core.ready(function () {
					// Themes begin
					am4core.useTheme(am4themes_animated);
					// Themes end

					// Add data
					chart.data = cantidadComentariosPersona;

					// Create axes
					var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
					categoryAxis.dataFields.category = 'name';
					categoryAxis.renderer.grid.template.disabled = false;
					categoryAxis.renderer.minGridDistance = 30;
					categoryAxis.renderer.inside = true;
					categoryAxis.renderer.labels.template.fill = am4core.color('#000');
					categoryAxis.renderer.labels.template.fontSize = 9;

					var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
					valueAxis.renderer.grid.template.strokeDasharray = '4,4';
					valueAxis.renderer.labels.template.disabled = true;
					valueAxis.min = 0;

					// Do not crop bullets
					chart.maskBullets = false;

					// Remove padding
					chart.paddingBottom = 0;

					// Create series
					var series = chart.series.push(new am4charts.ColumnSeries());
					series.dataFields.valueY = 'points';
					series.dataFields.categoryX = 'name';
					series.columns.template.propertyFields.fill = 'color';
					series.columns.template.propertyFields.stroke = 'color';
					series.columns.template.column.cornerRadiusTopLeft = 15;
					series.columns.template.column.cornerRadiusTopRight = 15;
					series.columns.template.tooltipText = '{categoryX}: [bold]{valueY}[/b]';

					// Add bullets
					var bullet = series.bullets.push(new am4charts.Bullet());
					var image = bullet.createChild(am4core.Image);
					image.horizontalCenter = 'middle';
					image.verticalCenter = 'bottom';
					image.dy = 20;
					image.y = am4core.percent(100);
					image.propertyFields.href = 'bullet';
					image.tooltipText = series.columns.template.tooltipText;
					image.propertyFields.fill = 'color';
					image.filters.push(new am4core.DropShadowFilter());
				}); // end am4core.ready()
			} else {
				simpleAlert('ERROR', respuesta.error, 'top-right', 'error', 6000);
			}
		})
		.fail(function (jqXHR, textStatus) {
			simpleAlert(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
			console.log(jqXHR.responseText);
		});
});
