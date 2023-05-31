         let map_p2 = null;
            let map_r2 = null;

        var villages = [{
                name: "Jhintisasan",
                lat: 20.1718,
                lang: 85.9062
            },

            {
                name: "Angola",
                lat: -11.202692,
                lang: 17.873886
            }
        ]
         map = L.map('map_p2').setView([-11.202692, 17.873886], 3);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11'
        }).addTo(map);



        var markers = L.markerClusterGroup();
        for (var i = 0; i < villages.length; i++) {
            var name = villages[i]['name'];
            var lat = villages[i]['lat'];
            var lng = villages[i]['lang'];
            var marker = L.marker(new L.LatLng(lat, lng), {
                title: name,
            });
            const html = `
      <div class="row">
        <div class="col-sm-12">
          <h4>${name}</h4>
        </div>
      </div>
  `;
            marker.bindPopup(html);
            markers.addLayer(marker);
            /* adding click event */
            marker.on('click', function(e) {
                var name = e.target._popup._content;
                var side_info = name + "Clicked.";

                // adding info into side bar
                $("#centers_info_sidebar").html(side_info);

            });
        }
        map.addLayer(markers);
        // var popup = L.popup();
        // setTimeout(ale => {
        //    $('.leaflet-marker-icon').attr('src','./images/pin1.png');
        // }, 1000);



        
        //.openPopup();



        $('#base-rcih2').on('click', () => {
            setTimeout( ()=> {
                if(!map_r2){
                     map2 = L.map('map_r2').setView([-11.202692, 17.873886], 3);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'

                    }).addTo(map2);

                    L.marker([-11.202692, 17.873886]).addTo(map2)
                        .bindPopup('RCIHs 1')
                }
            },5000)
        })