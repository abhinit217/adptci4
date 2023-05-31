// let map = null;
// let map1 = null;


// var villages = [{
//     name: "Mali",
//     lat: 17.570692,
//     lang: -3.996166,
//     partners: "NARS: Institute of Rural Economy (IER) <br>CGIAR: IITA, ICRISAT",
//     Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum"
// },
// {
//     name: "Burkina Faso",
//     lat: 12.238333,
//     lang: -1.561593,
//     partners: "NARS: Environmental Institute for Agricultural Research (INERA) <br>CGIAR: IITA, ICRISAT",
//     Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum"
// },
// {
//     name: "Ghana",
//     lat: 7.946527,
//     lang: -1.023194,
//     partners: "NARS: Council for Scientific and Industrial Research (CSIR) <br>CGIAR: IITA, ICRISAT",
//     Crops: "Cowpea, Groundnut, Non-crop Specific"
// },
// {
//     name: "Nigeria",
//     lat: 9.081999,
//     lang: 8.675277,
//     partners: "NARS: Institute for Agricultural Research (IAR) <br>CGIAR: IITA, ICRISAT <br>SFSA",
//     Crops: "Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum"
// },
// {
//     name: "Ethiopia",
//     lat: 9.145,
//     lang: 40.489674,
//     partners: "NARS: Ethiopian Institute of Agricultural Research (EIAR) <br>CGIAR: CIAT, ICRISAT",
//     Crops: "Common bean, Finger millet, Sorghum"
// },
// {
//     name: "Uganda",
//     lat: 1.5333554,
//     lang: 32.2166578,
//     partners: "NARS: National Agricultural Research Organisation (NARO) <br>CGIAR: CIAT, ICRISAT",
//     Crops: "Common bean, Finger millet, Groundnut, Sorghum"
// },
// {
//     name: "Tanzania",
//     lat: -6.5247123,
//     lang: 35.7878438,
//     partners: "NARS: Tanzania Agricultural Research Institute (TARI) <br>CGIAR: CIAT, ICRISAT <br>SFSA",
//     Crops: "Common bean, Finger millet, Groundnut, Sorghum"
// }
// ]

// var RCIH = [
//     {
//         rcih_name: "ICRISAT-WCA",
//         location: "Bamako, Mali",
//         Organization: "ICRISAT",
//         lat: "12.6132655",
//         lang: "-7.9847391"
//     },
//     {
//         rcih_name: "IITA",
//         location: "Kano, Nigeria",
//         Organization: "IITA",
//         lat: "11.8948389",
//         lang: "8.5364136"
//     },
//     {
//         rcih_name: "CIAT",
//         location: "Kawanda, Uganda",
//         Organization: "CIAT",
//         lat: "0.4172778",
//         lang: "32.5355326"
//     },
//     {
//         rcih_name: "ICRISAT-ESA",
//         location: "Bulawayo, Zimbabwe",
//         Organization: "ICRISAT",
//         lat: "-20.1560599",
//         lang: "28.5887063"
//     },

// ]
// map = L.map('map').setView([-11.202692, 17.873886], 3);
// L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
//     maxZoom: 18,
//     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
//         '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
//         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
//     id: 'mapbox/streets-v11'
// }).addTo(map);


// var markers = L.markerClusterGroup();
// for (var i = 0; i < villages.length; i++) {
//     var country = villages[i]['name'];
//     var lat = villages[i]['lat'];
//     var lng = villages[i]['lang'];
//     var partners = villages[i]['partners'];
//     var crops = villages[i]['Crops'];
//     var marker = L.marker(new L.LatLng(lat, lng), {
//         title: country,
//         crops: crops,
//         partners: partners
//     });
//     const html = `
//       <div class="row">
//         <div class="col-sm-12">
//           <span>${country}</span>
//           <p> ${partners}</p>
//           <p> ${crops}</p>
//         </div>
//       </div>
//   `;

//     // marker /.on('click', onMapClick);
//     // marker.bindPopup(html);
//     markers.addLayer(marker);
//     /* adding click event */
//     marker.on('click', function (e) {
//         var name = e.target.options;
//         // var side_info = name + "Clicked.";
//         // adding info into side bar
//         $("#map_crops").html(name.crops);
//         $("#map_partners").html(name.partners);

//     });
// }
// map.addLayer(markers);





// //.openPopup();


// $('#base-rcihs1').on('click', () => {
//     setTimeout(() => {
//         if (!map1) {
//             map1 = L.map('map1').setView([-11.202692, 17.873886], 3);
//             L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
//                 maxZoom: 18,
//                 attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
//                     '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
//                     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
//                 id: 'mapbox/streets-v11'
//             }).addTo(map1);

//             var markers = L.markerClusterGroup();
//             for (var i = 0; i < RCIH.length; i++) {
//                 var rcih_name = RCIH[i]['rcih_name'];
//                 var lat = RCIH[i]['lat'];
//                 var lng = RCIH[i]['lang'];
//                 var location = RCIH[i]['location'];
//                 var Organization = RCIH[i]['Organization'];
//                 var marker = L.marker(new L.LatLng(lat, lng), {
//                     rcih_name: rcih_name,
//                     Organization: Organization,
//                     location: location
//                 });
//                 const html = `
//       <div class="row">
//         <div class="col-sm-12">
//           <span>${rcih_name}</span>
//           <p> ${Organization}</p>
//           <p> ${location}</p>
//         </div>
//       </div>
//   `;


//                 // marker /.on('click', onMapClick);
//                 // marker.bindPopup(html);
//                 markers.addLayer(marker);
//                 /* adding click event */
//                 marker.on('click', function (e) {
//                     var name = e.target.options;
//                     // var side_info = name + "Clicked.";
//                     // adding info into side bar
//                     $("#rcih_location").html(name.location);
//                     $("#rcih_organization").html(name.Organization);
//                     $("#rcih_name").html(name.rcih_name);

//                 });
//             }
//             map1.addLayer(markers);
//             var popup = L.popup();
//             // setTimeout(ale => {
//                 $('.leaflet-marker-icon').attr('src', './assets/images/map_pointer/greenmarker.png');
//             // }, 1000);



//             // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'

//             // }).addTo(map1);

//             // L.marker([-11.202692, 17.873886]).addTo(map1)
//             //     .bindPopup('RCIHs 1')
//         }
//     })
// })



