(function(window, $) {
    "use strict";

    function MapHandler(){
        var self = this;

        self.init();
    }

    MapHandler.prototype = {

        init: function () {
            var self = this;
            var map = null;

            this.initMap();

        },
        initMap(){
            var self = this;
            const map = L.map('map').setView([37.8, -96], 4);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: ''
            }).addTo(map);



            /*L.mask = function (latLngs, options) {
                return new L.Mask(latLngs, options);
            };*/

            // control that shows state info on hover
            const info = L.control();

            info.onAdd = function (map) {
                this._div = L.DomUtil.create('div', 'info');
                this.update();
                return this._div;
            };

            info.update = function (props) {
                const contents = props ? `<b>${props.name}</b><br />${props.density} people / mi<sup>2</sup>` : 'Hover over a state';
                this._div.innerHTML = `<h4>US Population Density</h4>${contents}`;
            };

            info.addTo(map);


            // get color depending on population density value
            function getColor(d) {
                return d === parameters.state ? 'red' : 'white';
                /*return d > 1000 ? '#800026' :
                    d > 500  ? '#BD0026' :
                        d > 200  ? '#E31A1C' :
                            d > 100  ? '#FC4E2A' :
                                d > 50   ? '#FD8D3C' :
                                    d > 20   ? '#FEB24C' :
                                        d > 10   ? '#FED976' : '#FFEDA0';*/
            }

            function style(feature) {
                return {
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 1,
                    fillColor: getColor(feature.properties.name)
                };
            }

            function highlightFeature(e) {
                const layer = e.target;

                layer.setStyle({
                    weight: 5,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.7
                });

                layer.bringToFront();

                info.update(layer.feature.properties);
            }

            /* global statesData */
            const geojson = L.geoJson(statesData, {
                style,
                onEachFeature
            }).addTo(map);

            function resetHighlight(e) {
                geojson.resetStyle(e.target);
                info.update();
            }

            function zoomToFeature(e) {
                map.fitBounds(e.target.getBounds());
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }

            //map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');


            /*const legend = L.control({position: 'bottomright'});

            legend.onAdd = function (map) {

                const div = L.DomUtil.create('div', 'info legend');
                const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
                const labels = [];
                let from, to;

                for (let i = 0; i < grades.length; i++) {
                    from = grades[i];
                    to = grades[i + 1];

                    labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
                }

                div.innerHTML = labels.join('<br>');
                return div;
            };

            legend.addTo(map);*/

        },
        loadMarkersAjax(map) {
            var self = this;
            $.ajax({
                type: 'POST',
                url: parameters.ajax_url,
                data: {
                    'action': 'get_ffl',
                },
                dataType: "json",
                success: function (response) {

                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    alert(msg);
                }

            });
        },
        calcCrow(lat1, lon1, lat2, lon2)
        {
            var self = this;
            var R = 6371;
            var dLat = self.toRad(lat2-lat1);
            var dLon = self.toRad(lon2-lon1);
            var lat1 = self.toRad(lat1);
            var lat2 = self.toRad(lat2);

            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var d = R * c;
            return d;
        },
        toRad(value)
        {
            return value * Math.PI / 180;
        }
    }

    window.Mpl = window.Mpl || {};
    window.Mpl.MapHandler = new MapHandler();

    $(window).load(function(){
    });

})(window, window.jQuery);


