<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<style>
    #map {
        height: 700px;
        margin: 0 auto;
    }

    #map2 {
        height: 700px;
        margin: 0 auto;
    }

    .loading {
        margin-top: 10em;
        text-align: center;
        color: gray;
    }
</style>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div id="map2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (async () => {
        const topology = await fetch(
            'https://code.highcharts.com/mapdata/countries/fr/custom/fr-all-all-mainland.topo.json'
        ).then(response => response.json());

        const data = [{
                code: 'fr-bre-mb',
                value1: {{ $dep56 }},
                value2: '56'
            },
            {
                code: 'fr-pac-am',
                value1: {{ $dep06 }},
                value2: '6'
            },
            {
                code: 'fr-pac-vr',
                value1: {{ $dep83 }},
                value2: '83'
            },
            {
                code: 'fr-pdl-vd',
                value1: {{ $dep85 }},
                value2: '85'
            },
            {
                code: 'fr-ara-ai',
                value1: {{ $dep1 }},
                value2: '1'
            },
            {
                code: 'fr-occ-ad',
                value1: {{ $dep11 }},
                value2: '11'
            },
            {
                code: 'fr-pac-vc',
                value1: {{ $dep84 }},
                value2: '84'
            },
            {
                code: 'fr-occ-hg',
                value1: {{ $dep31 }},
                value2: '31'
            },
            {
                code: 'fr-ara-cl',
                value1: {{ $dep15 }},
                value2: '15'
            },
            {
                code: 'fr-occ-lz',
                value1: {{ $dep48 }},
                value2: '48'
            },
            {
                code: 'fr-ges-mm',
                value1: {{ $dep54 }},
                value2: '54'
            },
            {
                code: 'fr-hdf-no',
                value1: {{ $dep59 }},
                value2: '59'
            },
            {
                code: 'fr-occ-hp',
                value1: {{ $dep65 }},
                value2: '65'
            },
            {
                code: 'fr-naq-dd',
                value1: {{ $dep17 }},
                value2: '17'
            },
            {
                code: 'fr-naq-cm',
                value1: {{ $dep24 }},
                value2: '24'
            },
            {
                code: 'fr-pac-ap',
                value1: {{ $dep04 }},
                value2: '4'
            },
            {
                code: 'fr-hdf-as',
                value1: {{ $dep02 }},
                value2: '2'
            },
            {
                code: 'fr-occ-av',
                value1: {{ $dep12 }},
                value2: '12'
            },
            {
                code: 'fr-occ-ga',
                value1: {{ $dep30 }},
                value2: '30'
            },
            {
                code: 'fr-ges-ab',
                value1: {{ $dep10 }},
                value2: '10'
            },
            {
                code: 'fr-bfc-co',
                value1: {{ $dep21 }},
                value2: '21'
            },
            {
                code: 'fr-bfc-sl',
                value1: {{ $dep71 }},
                value2: '71'
            },
            {
                code: 'fr-cvl-ch',
                value1: {{ $dep18 }},
                value2: '18'
            },
            {
                code: 'fr-naq-cr',
                value1: {{ $dep23 }},
                value2: '23'
            },
            {
                code: 'fr-pdl-ml',
                value1: {{ $dep49 }},
                value2: '49'
            },
            {
                code: 'fr-naq-ds',
                value1: {{ $dep79 }},
                value2: '79'
            },
            {
                code: 'fr-naq-ct',
                value1: {{ $dep16 }},
                value2: '16'
            },
            {
                code: 'fr-ara-dm',
                value1: {{ $dep26 }},
                value2: '26'
            },
            {
                code: 'fr-ara-ah',
                value1: {{ $dep07 }},
                value2: '7'
            },
            {
                code: 'fr-nor-eu',
                value1: {{ $dep27 }},
                value2: '27'
            },
            {
                code: 'fr-idf-es',
                value1: {{ $dep91 }},
                value2: '91'
            },
            {
                code: 'fr-cvl-el',
                value1: {{ $dep28 }},
                value2: '28'
            },
            {
                code: 'fr-ara-hs',
                value1: {{ $dep74 }},
                value2: '74'
            },
            {
                code: 'fr-idf-hd',
                value1: {{ $dep01 }},
                value2: '1'
            },
            {
                code: 'fr-pdl-st',
                value1: {{ $dep72 }},
                value2: '72'
            },
            {
                code: 'fr-cvl-il',
                value1: {{ $dep37 }},
                value2: '37'
            },
            {
                code: 'fr-ara-is',
                value1: {{ $dep38 }},
                value2: '38'
            },
            {
                code: 'fr-bfc-ju',
                value1: {{ $dep39 }},
                value2: '39'
            },
            {
                code: 'fr-ara-lr',
                value1: {{ $dep42 }},
                value2: '42'
            },
            {
                code: 'fr-occ-lo',
                value1: {{ $dep46 }},
                value2: '46'
            },
            {
                code: 'fr-occ-tg',
                value1: {{ $dep82 }},
                value2: '82'
            },
            {
                code: 'fr-naq-lg',
                value1: {{ $dep47 }},
                value2: '47'
            },
            {
                code: 'fr-bre-iv',
                value1: {{ $dep35 }},
                value2: '35'
            },
            {
                code: 'fr-ges-ms',
                value1: {{ $dep55 }},
                value2: '55'
            },
            {
                code: 'fr-bfc-ni',
                value1: {{ $dep58 }},
                value2: '58'
            },
            {
                code: 'fr-cvl-lt',
                value1: {{ $dep45 }},
                value2: '45'
            },
            {
                code: 'fr-idf-vp',
                value1: {{ $dep01 }},
                value2: '1'
            },
            {
                code: 'fr-naq-cz',
                value1: {{ $dep19 }},
                value2: '19'
            },
            {
                code: 'fr-ara-pd',
                value1: {{ $dep63 }},
                value2: '63'
            },
            {
                code: 'fr-occ-ge',
                value1: {{ $dep32 }},
                value2: '32'
            },
            {
                code: 'fr-naq-pa',
                value1: {{ $dep64 }},
                value2: '64'
            },
            {
                code: 'fr-idf-se',
                value1: {{ $dep77 }},
                value2: '77'
            },
            {
                code: 'fr-idf-ss',
                value1: {{ $dep01 }},
                value2: '1'
            },
            {
                code: 'fr-hdf-so',
                value1: {{ $dep80 }},
                value2: '80'
            },
            {
                code: 'fr-bfc-tb',
                value1: {{ $dep90 }},
                value2: '90'
            },
            {
                code: 'fr-bfc-hn',
                value1: {{ $dep70 }},
                value2: '70'
            },
            {
                code: 'fr-idf-vo',
                value1: {{ $dep95 }},
                value2: '95'
            },
            {
                code: 'fr-idf-vm',
                value1: {{ $dep01 }},
                value2: '1'
            },
            {
                code: 'fr-naq-vn',
                value1: {{ $dep86 }},
                value2: '86'
            },
            {
                code: 'fr-ges-vg',
                value1: {{ $dep88 }},
                value2: '88'
            },
            {
                code: 'fr-idf-yv',
                value1: {{ $dep78 }},
                value2: '78'
            },
            {
                code: 'fr-pac-bd',
                value1: {{ $dep13 }},
                value2: '13'
            },
            {
                code: 'fr-cvl-lc',
                value1: {{ $dep41 }},
                value2: '41'
            },
            {
                code: 'fr-bre-fi',
                value1: {{ $dep29 }},
                value2: '29'
            },
            {
                code: 'fr-nor-mh',
                value1: {{ $dep50 }},
                value2: '50'
            },
            {
                code: 'fr-ges-an',
                value1: {{ $dep08 }},
                value2: '8'
            },
            {
                code: 'fr-occ-ag',
                value1: {{ $dep09 }},
                value2: '9'
            },
            {
                code: 'fr-ges-br',
                value1: {{ $dep67 }},
                value2: '67'
            },
            {
                code: 'fr-nor-cv',
                value1: {{ $dep14 }},
                value2: '14'
            },
            {
                code: 'fr-bre-ca',
                value1: {{ $dep22 }},
                value2: '22'
            },
            {
                code: 'fr-bfc-db',
                value1: {{ $dep25 }},
                value2: '25'
            },
            {
                code: 'fr-naq-gi',
                value1: {{ $dep33 }},
                value2: '33'
            },
            {
                code: 'fr-ges-hr',
                value1: {{ $dep68 }},
                value2: '68'
            },
            {
                code: 'fr-ara-hl',
                value1: {{ $dep43 }},
                value2: '43'
            },
            {
                code: 'fr-ges-hm',
                value1: {{ $dep52 }},
                value2: '52'
            },
            {
                code: 'fr-pac-ha',
                value1: {{ $dep04 }},
                value2: '4'
            },
            {
                code: 'fr-occ-he',
                value1: {{ $dep34 }},
                value2: '34'
            },
            {
                code: 'fr-naq-ld',
                value1: {{ $dep40 }},
                value2: '40'
            },
            {
                code: 'fr-pdl-la',
                value1: {{ $dep44 }},
                value2: '44'
            },
            {
                code: 'fr-ges-mr',
                value1: {{ $dep51 }},
                value2: '51'
            },
            {
                code: 'fr-pdl-my',
                value1: {{ $dep53 }},
                value2: '53'
            },
            {
                code: 'fr-ges-mo',
                value1: {{ $dep57 }},
                value2: '57'
            },
            {
                code: 'fr-nor-or',
                value1: {{ $dep61 }},
                value2: '61'
            },
            {
                code: 'fr-hdf-pc',
                value1: {{ $dep62 }},
                value2: '62'
            },
            {
                code: 'fr-occ-po',
                value1: {{ $dep66 }},
                value2: '66'
            },
            {
                code: 'fr-ara-al',
                value1: {{ $dep03 }},
                value2: '3'
            },
            {
                code: 'fr-ara-sv',
                value1: {{ $dep73 }},
                value2: '73'
            },
            {
                code: 'fr-nor-sm',
                value1: {{ $dep76 }},
                value2: '76'
            },
            {
                code: 'fr-naq-hv',
                value1: {{ $dep87 }},
                value2: '87'
            },
            {
                code: 'fr-cvl-in',
                value1: {{ $dep36 }},
                value2: '36'
            },
            {
                code: 'fr-hdf-oi',
                value1: {{ $dep60 }},
                value2: '60'
            },
            {
                code: 'fr-ara-rh',
                value1: {{ $dep69 }},
                value2: '69'
            },
            {
                code: 'fr-occ-ta',
                value1: {{ $dep81 }},
                value2: '81'
            },
            {
                code: 'fr-bfc-yo',
                value1: {{ $dep89 }},
                value2: '89'
            }
        ];

        Highcharts.mapChart('map', {
            chart: {
                map: topology
            },

            title: {
                text: 'Répartition des Rendez-vous Confirmés'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 0,
                max: 5,
                stops: [
                    [0, '#D0D3D4'],
                    [1, '#14A44D']
                ],
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                data: data.map(item => ({
                    'hc-key': item.code,
                    value: item.value1,
                    thirdValue: item.value2
                })),
                name: 'rdv',
                states: {
                    hover: {
                        color: ''
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: ' {point.thirdValue}'
                }
            }]
        });
    })();
</script>


<script>
    (async () => {
        const topology = await fetch(
            'https://code.highcharts.com/mapdata/countries/fr/custom/fr-all-all-mainland.topo.json'
        ).then(response => response.json());

        const data = [{
                code: 'fr-bre-mb',
                value1: {{ $dep56All }},
                value2: '56'
            },
            {
                code: 'fr-pac-am',
                value1: {{ $dep06All }},
                value2: '6'
            },
            {
                code: 'fr-pac-vr',
                value1: {{ $dep83All }},
                value2: '83'
            },
            {
                code: 'fr-pdl-vd',
                value1: {{ $dep85All }},
                value2: '85'
            },
            {
                code: 'fr-ara-ai',
                value1: {{ $dep1All }},
                value2: '1'
            },
            {
                code: 'fr-occ-ad',
                value1: {{ $dep11All }},
                value2: '11'
            },
            {
                code: 'fr-pac-vc',
                value1: {{ $dep84All }},
                value2: '84'
            },
            {
                code: 'fr-occ-hg',
                value1: {{ $dep31All }},
                value2: '31'
            },
            {
                code: 'fr-ara-cl',
                value1: {{ $dep15All }},
                value2: '15'
            },
            {
                code: 'fr-occ-lz',
                value1: {{ $dep48All }},
                value2: '48'
            },
            {
                code: 'fr-ges-mm',
                value1: {{ $dep54All }},
                value2: '54'
            },
            {
                code: 'fr-hdf-no',
                value1: {{ $dep59All }},
                value2: '59'
            },
            {
                code: 'fr-occ-hp',
                value1: {{ $dep65All }},
                value2: '65'
            },
            {
                code: 'fr-naq-dd',
                value1: {{ $dep17All }},
                value2: '17'
            },
            {
                code: 'fr-naq-cm',
                value1: {{ $dep24All }},
                value2: '24'
            },
            {
                code: 'fr-pac-ap',
                value1: {{ $dep04All }},
                value2: '4'
            },
            {
                code: 'fr-hdf-as',
                value1: {{ $dep02All }},
                value2: '2'
            },
            {
                code: 'fr-occ-av',
                value1: {{ $dep12All }},
                value2: '12'
            },
            {
                code: 'fr-occ-ga',
                value1: {{ $dep30All }},
                value2: '30'
            },
            {
                code: 'fr-ges-ab',
                value1: {{ $dep10All }},
                value2: '10'
            },
            {
                code: 'fr-bfc-co',
                value1: {{ $dep21All }},
                value2: '21'
            },
            {
                code: 'fr-bfc-sl',
                value1: {{ $dep71All }},
                value2: '71'
            },
            {
                code: 'fr-cvl-ch',
                value1: {{ $dep18All }},
                value2: '18'
            },
            {
                code: 'fr-naq-cr',
                value1: {{ $dep23All }},
                value2: '23'
            },
            {
                code: 'fr-pdl-ml',
                value1: {{ $dep49All }},
                value2: '49'
            },
            {
                code: 'fr-naq-ds',
                value1: {{ $dep79All }},
                value2: '79'
            },
            {
                code: 'fr-naq-ct',
                value1: {{ $dep16All }},
                value2: '16'
            },
            {
                code: 'fr-ara-dm',
                value1: {{ $dep26All }},
                value2: '26'
            },
            {
                code: 'fr-ara-ah',
                value1: {{ $dep07All }},
                value2: '7'
            },
            {
                code: 'fr-nor-eu',
                value1: {{ $dep27All }},
                value2: '27'
            },
            {
                code: 'fr-idf-es',
                value1: {{ $dep91All }},
                value2: '91'
            },
            {
                code: 'fr-cvl-el',
                value1: {{ $dep28All }},
                value2: '28'
            },
            {
                code: 'fr-ara-hs',
                value1: {{ $dep74All }},
                value2: '74'
            },
            {
                code: 'fr-idf-hd',
                value1: {{ $dep01All }},
                value2: '1'
            },
            {
                code: 'fr-pdl-st',
                value1: {{ $dep72All }},
                value2: '72'
            },
            {
                code: 'fr-cvl-il',
                value1: {{ $dep37All }},
                value2: '37'
            },
            {
                code: 'fr-ara-is',
                value1: {{ $dep38All }},
                value2: '38'
            },
            {
                code: 'fr-bfc-ju',
                value1: {{ $dep39All }},
                value2: '39'
            },
            {
                code: 'fr-ara-lr',
                value1: {{ $dep42All }},
                value2: '42'
            },
            {
                code: 'fr-occ-lo',
                value1: {{ $dep46All }},
                value2: '46'
            },
            {
                code: 'fr-occ-tg',
                value1: {{ $dep82All }},
                value2: '82'
            },
            {
                code: 'fr-naq-lg',
                value1: {{ $dep47All }},
                value2: '47'
            },
            {
                code: 'fr-bre-iv',
                value1: {{ $dep35All }},
                value2: '35'
            },
            {
                code: 'fr-ges-ms',
                value1: {{ $dep55All }},
                value2: '55'
            },
            {
                code: 'fr-bfc-ni',
                value1: {{ $dep58All }},
                value2: '58'
            },
            {
                code: 'fr-cvl-lt',
                value1: {{ $dep45All }},
                value2: '45'
            },
            {
                code: 'fr-idf-vp',
                value1: {{ $dep01All }},
                value2: '1'
            },
            {
                code: 'fr-naq-cz',
                value1: {{ $dep19All }},
                value2: '19'
            },
            {
                code: 'fr-ara-pd',
                value1: {{ $dep63All }},
                value2: '63'
            },
            {
                code: 'fr-occ-ge',
                value1: {{ $dep32All }},
                value2: '32'
            },
            {
                code: 'fr-naq-pa',
                value1: {{ $dep64All }},
                value2: '64'
            },
            {
                code: 'fr-idf-se',
                value1: {{ $dep77All }},
                value2: '77'
            },
            {
                code: 'fr-idf-ss',
                value1: {{ $dep01All }},
                value2: '1'
            },
            {
                code: 'fr-hdf-so',
                value1: {{ $dep80All }},
                value2: '80'
            },
            {
                code: 'fr-bfc-tb',
                value1: {{ $dep90All }},
                value2: '90'
            },
            {
                code: 'fr-bfc-hn',
                value1: {{ $dep70All }},
                value2: '70'
            },
            {
                code: 'fr-idf-vo',
                value1: {{ $dep95All }},
                value2: '95'
            },
            {
                code: 'fr-idf-vm',
                value1: {{ $dep01All }},
                value2: '1'
            },
            {
                code: 'fr-naq-vn',
                value1: {{ $dep86All }},
                value2: '86'
            },
            {
                code: 'fr-ges-vg',
                value1: {{ $dep88All }},
                value2: '88'
            },
            {
                code: 'fr-idf-yv',
                value1: {{ $dep78All }},
                value2: '78'
            },
            {
                code: 'fr-pac-bd',
                value1: {{ $dep13All }},
                value2: '13'
            },
            {
                code: 'fr-cvl-lc',
                value1: {{ $dep41All }},
                value2: '41'
            },
            {
                code: 'fr-bre-fi',
                value1: {{ $dep29All }},
                value2: '29'
            },
            {
                code: 'fr-nor-mh',
                value1: {{ $dep50All }},
                value2: '50'
            },
            {
                code: 'fr-ges-an',
                value1: {{ $dep08All }},
                value2: '8'
            },
            {
                code: 'fr-occ-ag',
                value1: {{ $dep09All }},
                value2: '9'
            },
            {
                code: 'fr-ges-br',
                value1: {{ $dep67All }},
                value2: '67'
            },
            {
                code: 'fr-nor-cv',
                value1: {{ $dep14All }},
                value2: '14'
            },
            {
                code: 'fr-bre-ca',
                value1: {{ $dep22All }},
                value2: '22'
            },
            {
                code: 'fr-bfc-db',
                value1: {{ $dep25All }},
                value2: '25'
            },
            {
                code: 'fr-naq-gi',
                value1: {{ $dep33All }},
                value2: '33'
            },
            {
                code: 'fr-ges-hr',
                value1: {{ $dep68All }},
                value2: '68'
            },
            {
                code: 'fr-ara-hl',
                value1: {{ $dep43All }},
                value2: '43'
            },
            {
                code: 'fr-ges-hm',
                value1: {{ $dep52All }},
                value2: '52'
            },
            {
                code: 'fr-pac-ha',
                value1: {{ $dep04All }},
                value2: '4'
            },
            {
                code: 'fr-occ-he',
                value1: {{ $dep34All }},
                value2: '34'
            },
            {
                code: 'fr-naq-ld',
                value1: {{ $dep40All }},
                value2: '40'
            },
            {
                code: 'fr-pdl-la',
                value1: {{ $dep44All }},
                value2: '44'
            },
            {
                code: 'fr-ges-mr',
                value1: {{ $dep51All }},
                value2: '51'
            },
            {
                code: 'fr-pdl-my',
                value1: {{ $dep53All }},
                value2: '53'
            },
            {
                code: 'fr-ges-mo',
                value1: {{ $dep57All }},
                value2: '57'
            },
            {
                code: 'fr-nor-or',
                value1: {{ $dep61All }},
                value2: '61'
            },
            {
                code: 'fr-hdf-pc',
                value1: {{ $dep62All }},
                value2: '62'
            },
            {
                code: 'fr-occ-po',
                value1: {{ $dep66All }},
                value2: '66'
            },
            {
                code: 'fr-ara-al',
                value1: {{ $dep03All }},
                value2: '3'
            },
            {
                code: 'fr-ara-sv',
                value1: {{ $dep73All }},
                value2: '73'
            },
            {
                code: 'fr-nor-sm',
                value1: {{ $dep76All }},
                value2: '76'
            },
            {
                code: 'fr-naq-hv',
                value1: {{ $dep87All }},
                value2: '87'
            },
            {
                code: 'fr-cvl-in',
                value1: {{ $dep36All }},
                value2: '36'
            },
            {
                code: 'fr-hdf-oi',
                value1: {{ $dep60All }},
                value2: '60'
            },
            {
                code: 'fr-ara-rh',
                value1: {{ $dep69All }},
                value2: '69'
            },
            {
                code: 'fr-occ-ta',
                value1: {{ $dep81All }},
                value2: '81'
            },
            {
                code: 'fr-bfc-yo',
                value1: {{ $dep89All }},
                value2: '89'
            }
        ];

        Highcharts.mapChart('map2', {
            chart: {
                map: topology
            },

            title: {
                text: 'Répartition des Rendez-Vous Pris'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 0,
                max: 5,
                stops: [
                    [0, '#D0D3D4'],
                    [1, '#DC4C64']
                ],
                labels: {
                    format: '{value}'
                }
            },
            series: [{
                data: data.map(item => ({
                    'hc-key': item.code,
                    value: item.value1,
                    thirdValue: item.value2
                })),
                name: 'rdv',
                states: {
                    hover: {
                        color: ''
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.thirdValue}'
                }
            }]
        });
    })();
</script>
