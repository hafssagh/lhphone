<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/map.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>


<div id="container" style="min-width: 400px; height: 600px; margin: 0 auto"></div>

<script>
    // Chargez les données GeoJSON depuis votre fichier externe
    Highcharts.ajax({
        url: '/maps/your-geojson-file.geojson', // Mettez le chemin correct vers votre fichier GeoJSON
        dataType: 'json',
        success: function(geojson) {
            Highcharts.mapChart('container', {
                chart: {
                    type: 'map'
                },
                title: {
                    text: 'Carte des départements de France'
                },
                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },
                tooltip: {
                    headerFormat: '',
                    pointFormat: 'Département : {point.properties.dep}'
                },
                series: [{
                    name: 'Départements',
                    data: geojson.features, // Utilisez les données GeoJSON chargées
                    joinBy: 'code_commune_insee', // Assurez-vous que c'est le bon champ pour rejoindre vos données GeoJSON
                    states: {
                        hover: {
                            color: '#BADA55'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.properties.code_commune_insee}',
                        allowOverlap: false // Prevent data labels from overlapping
                    },
                    point: {
                        events: {
                            click: function() {
                                // Gérez le zoom et l'affichage des codes postaux ici
                                // You can implement code to display postal codes on click or zoom in here
                            }
                        }
                    }
                }]
            });
        }
    });
</script>
