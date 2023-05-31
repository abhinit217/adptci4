class Overview {
    constructor() {
      this.map = null;
      this.map1 = null;
      this.generateProgramwiseMap();
      $('#back_button').click(()=>{
        $('#program_wise_data_back').css('display','block');
        $('#rcih_wise_data_back').css('display','block');
        $('#rcih_wise_data').css('display','none');
        $('#program_wise_data').css('display','none');
        $('#back_button').css('display','none');
      })
    }
   
      generateProgramwiseMap() {
          
        this.map = L.map("map").setView([-11.202692, 17.873886], 3);
        L.tileLayer(
          "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw",
          {
            maxZoom: 18,
            attribution:
              'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
              '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
              'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: "mapbox/streets-v11",
          }
        ).addTo(this.map);

				var home = {
					lat: -11.202692,
					lng: 17.873886,
					zoom: 3
				}; 
				
				L.easyButton('fa-home',function(btn,map){
					map.setView([home.lat, home.lng], home.zoom);
				},'Zoom To Home').addTo(this.map);

        
        
        const getOverviewData=(request)=>{
          //const request = { purpose: "PO1" };
           request.purpose="overview";
           request.request_type="country_id";
           //console.log(request);
          post("dashboard",request).then(
            response=>{
              //console.log(response);
              const html = `
              <div class="col-md-12"><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.5: Program-wise protocols developed for rapid cycle breeding : <strong style="font-size: 16px;">${response.protocols_developed_actual}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.protocols_developed_actual - response.protocols_developed_target[0]['value']))>0 ? 'green':'red'};"> ${(response.protocols_developed_actual-response.protocols_developed_target[0]['value'])}</font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.6: Program-wise generations achieved this year : <strong style="font-size: 16px;">${response.generationsachieved_actual}</strong></h6>

                <h6 class="ml-10">Variance : <font style="color: ${((response.generationsachieved_actual - response.generationsachieved_target[0]['value']))>0 ? 'green':'red'};"> ${(response.generationsachieved_actual-response.generationsachieved_target[0]['value'])}</font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.7: Program-wise fixed lines developed this year : <strong style="font-size: 16px;">${response.fixedlines_developed_actual}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fixedlines_developed_actual - response.fixedlines_developed_target[0]['value']))>0 ? 'green':'red'};"> ${( response.fixedlines_developed_actual - response.fixedlines_developed_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.12: Number of lines/ hybrids submitted to NPT/ DUS</h6>
                <h6 class="ml-10"><font style="color: gray;">NPT :</font> <strong style="font-size: 16px;">${response.npd_data_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">DUS :</font> <strong style="font-size: 16px;">${response.dus_data_count}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.npd_data_count+response.dus_data_count) - response.npt_dus_target[0]['value']))>0 ? 'green':'red'};"> ${(response.npd_data_count+response.dus_data_count) - response.npt_dus_target[0]['value']} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.13: Number of hybrid/ OPV/ SPV varieties released </h6>
                <h6 class="ml-10"><font style="color: gray;">Hybrid :</font> <strong style="font-size: 16px;">${response.global_hybrid_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">OPV :</font> <strong style="font-size: 16px;">${response.global_opv_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">SPV :</font> <strong style="font-size: 16px;">${response.global_spv_count}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.global_hybrid_count+response.global_opv_count+response.global_spv_count) - response.hybrid_opv_spv_target[0]['value']))>0 ? 'green':'red'};"> ${(response.global_hybrid_count+response.global_opv_count+response.global_spv_count) - response.hybrid_opv_spv_target[0]['value']} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.20: Program-wise multi- locational trials conducted : <strong style="font-size: 16px;">${response.multi_locationtrials_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.multi_locationtrials_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};"> ${(response.multi_locationtrials_actual - response.multi_locationtrials_target[0]['value'])} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.22: Program-wise on- farm trials conducted : <strong style="font-size: 16px;">${response.Onfarmtrials_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.Onfarmtrials_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};"> ${(response.Onfarmtrials_actual - response.multi_locationtrials_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.23: Program-wise FPVS conducted : <strong style="font-size: 16px;">${response.fpv_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fpv_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};">${(response.fpv_actual - response.multi_locationtrials_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #2.1: Progress made towards digitization of the breeding program (%) : <strong style="font-size: 16px;">${Number((response.indicator_2_1_actualval).toFixed(2))}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.indicator_2_1_actualval - response.indicator_2_1_targetval[0]['value']))>0 ? 'green':'red'};"> ${Number((response.indicator_2_1_actualval - response.indicator_2_1_targetval[0]['value']).toFixed(2))}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #2.4: Program-wise number of RCIHs and NARS adopting and implementing WEAI and/ or GREAT methodology : <strong style="font-size: 16px;">${response.weai_great_data} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.weai_great_data - response.weai_great_data_target[0]['value']))>0 ? 'green':'red'};">${(response.weai_great_data - response.weai_great_data_target[0]['value'])} </font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #3.8: Program-wise percent of women and youth adopting new varieties : <strong style="font-size: 16px;">${response.adopting_newvarieties}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.adopting_newvarieties - response.adopting_newvarieties_target[0]['value']))>0 ? 'green':'red'};"> ${(response.adopting_newvarieties - response.adopting_newvarieties_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #3.9: Program-wise percent women and youth buying high quality seed of improved varieties from different sources : <strong style="font-size: 16px;">${response.seed_improvedvarities}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.seed_improvedvarities - response.seed_improvedvarities_target[0]['value']))>0 ? 'green':'red'};"> ${(response.seed_improvedvarities - response.seed_improvedvarities_target[0]['value'])}</font></h6><hr class="new4"><h6 class="ml-10 info">Indicator #3.10: Program-wise average number of seasons that women and youth farmers recycle their seed before replacing it : <strong style="font-size: 16px;">${response.farmersrecycle}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.farmersrecycle - response.farmersrecycle_target[0]['value']))>0 ? 'green':'red'};"> ${(response.farmersrecycle - response.farmersrecycle_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.3: Program-wise number of demonstrations conducted : <strong style="font-size: 16px;">${response.demos_conducted}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.demos_conducted - response.demos_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${(response.demos_conducted - response.demos_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.4: Program-wise number of field days conducted : <strong style="font-size: 16px;">${response.fielddays_conducted}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fielddays_conducted - response.fielddays_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${(response.fielddays_conducted - response.fielddays_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.5: Program-wise number of seed fairs and agriculture shows conducted</h6>
                <h6 class="ml-10"><font style="color: gray;">Seed fairs conducted :</font> <strong style="font-size: 16px;">${(response.seed_conducted)}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">Agriculture shows conducted :</font> <strong style="font-size: 16px;">${(response.agri_conducted)}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.seed_conducted+response.agri_conducted) - response.seed_agri_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${((response.seed_conducted+response.agri_conducted) -response.seed_agri_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.6: Program-wise number of radio/ TV shows facilitated/conducted : <strong style="font-size: 16px;">${response.radio_tv_shows}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.radio_tv_shows - response.radio_tv_shows_target[0]['value']))>0 ? 'green':'red'};"> ${(response.radio_tv_shows - response.radio_tv_shows_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.14: Volume of breeder seed produced (tons) : <strong style="font-size: 16px;">${response.breederseed}</strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.breederseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${(response.breederseed - response.seed_count_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.15: Volume of foundation seed produced (tons : <strong style="font-size: 16px;">${response.foundationseed} </strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.foundationseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${Number((response.foundationseed - response.seed_count_target[0]['value']).toFixed(2))}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.16: Volume of certified and QDS seed produced (tons) : <strong style="font-size: 16px;">${response.certifiedqdsseed} </strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.certifiedqdsseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${Number((response.certifiedqdsseed - response.seed_count_target[0]['value']).toFixed(2))}</font></h6><hr class="new4">
            </div>
          `;
          $("#program_indicaters").html(html);
  
            }
          ).catch().finally();
        }
        for (let i = 0; i < villages.length; i++) {
          let country = villages[i]["name"];
          let lat = villages[i]["lat"];
          let lng = villages[i]["lang"];
          let partners = villages[i]["partners"];
          let crops = villages[i]["Crops"];
          let marker = L.marker(new L.LatLng(lat, lng), {
            title: country,
            crops: crops,
            partners: partners,
          });
          const html = `
          <div class="row">
            <div class="col-sm-12">
              <span>${country}</span>
              <p> ${partners}</p>
              <p> ${crops}</p>
            </div>
          </div>
      `;
      
          /* adding click event */
          marker.on("click", function (e) {
            let name = e.target.options;
            // var side_info = name + "Clicked.";
            // adding info into side bar
            $("#map_crops").html(name.crops);
            $("#map_partners").html(name.partners);
            
            let markerData=villages[i];
            getOverviewData(markerData)
            $("#rcih_wise_data").css("display","none");
            $("#program_wise_data").css("display","block");
            //console.log(getOverviewData);
            $('#back_button').css('display','block');
            $('#program_wise_data_back').css('display','none');
            $('#rcih_wise_data_back').css('display','none');
          });
          this.map.addLayer(marker);
        }

        //rcih map
        const getOverviewRcihData=(request)=>{
          //const request = { purpose: "PO1" };
           request.purpose="overview";
           request.request_type="Rcih";
           console.log(request);
          post("dashboard",request).then(
            response=>{
              //console.log(response);
              const html = `
              <div class="col-md-12"><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.5: RCIH-wise protocols developed for rapid cycle breeding : <strong style="font-size: 16px;">${response.protocols_developed_actual}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.protocols_developed_actual - response.protocols_developed_target[0]['value']))>0 ? 'green':'red'};"> ${(response.protocols_developed_actual-response.protocols_developed_target[0]['value'])}</font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.6: RCIH-wise generations achieved this year : <strong style="font-size: 16px;">${response.generationsachieved_actual}</strong></h6>

                <h6 class="ml-10">Variance : <font style="color: ${((response.generationsachieved_actual - response.generationsachieved_target[0]['value']))>0 ? 'green':'red'};"> ${(response.generationsachieved_actual-response.generationsachieved_target[0]['value'])}</font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.7: RCIH-wise fixed lines developed this year : <strong style="font-size: 16px;">${response.fixedlines_developed_actual}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fixedlines_developed_actual - response.fixedlines_developed_target[0]['value']))>0 ? 'green':'red'};"> ${( response.fixedlines_developed_actual - response.fixedlines_developed_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.12: Number of lines/ hybrids submitted to NPT/ DUS</h6>
                <h6 class="ml-10"><font style="color: gray;">NPT :</font> <strong style="font-size: 16px;">${response.npd_data_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">DUS :</font> <strong style="font-size: 16px;"> ${response.dus_data_count}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.npd_data_count+response.dus_data_count) - response.npt_dus_target[0]['value']))>0 ? 'green':'red'};"> ${(response.npd_data_count+response.dus_data_count) - response.npt_dus_target[0]['value']} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.13: Number of hybrid/ OPV/ SPV varieties released </h6>
                <h6 class="ml-10"><font style="color: gray;">Hybrid :</font> <strong style="font-size: 16px;"> ${response.global_hybrid_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">OPV :</font> <strong style="font-size: 16px;"> ${response.global_opv_count}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">SPV :</font> <strong style="font-size: 16px;"> ${response.global_spv_count}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.global_hybrid_count+response.global_opv_count+response.global_spv_count) - response.hybrid_opv_spv_target[0]['value']))>0 ? 'green':'red'};"> ${(response.global_hybrid_count+response.global_opv_count+response.global_spv_count) - response.hybrid_opv_spv_target[0]['value']} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.20: RCIH-wise multi- locational trials conducted : <strong style="font-size: 16px;">${response.multi_locationtrials_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.multi_locationtrials_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};"> ${(response.multi_locationtrials_actual - response.multi_locationtrials_target[0]['value'])} </font></h6><hr class="new4">

                <h6 class="ml-10 info">Indicator #1.22: RCIH-wise on- farm trials conducted : <strong style="font-size: 16px;">${response.Onfarmtrials_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.Onfarmtrials_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};"> ${(response.Onfarmtrials_actual - response.multi_locationtrials_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #1.23: RCIH-wise FPVS conducted : <strong style="font-size: 16px;">${response.fpv_actual} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fpv_actual - response.multi_locationtrials_target[0]['value']))>0 ? 'green':'red'};">${(response.fpv_actual - response.multi_locationtrials_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #2.1: Progress made towards digitization of the breeding program (%) : <strong style="font-size: 16px;">${Number((response.indicator_2_1_actualval).toFixed(2))}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.indicator_2_1_actualval - response.indicator_2_1_targetval[0]['value']))>0 ? 'green':'red'};"> ${Number((response.indicator_2_1_actualval - response.indicator_2_1_targetval[0]['value']).toFixed(2))}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #2.4: RCIH-wise number of RCIHs and NARS adopting and implementing WEAI and/ or GREAT methodology : <strong style="font-size: 16px;">${response.weai_great_data} </strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.weai_great_data - response.weai_great_data_target[0]['value']))>0 ? 'green':'red'};">${(response.weai_great_data - response.weai_great_data_target[0]['value'])} </font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #3.8: RCIH-wise percent of women and youth adopting new varieties : <strong style="font-size: 16px;">${response.adopting_newvarieties}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.adopting_newvarieties - response.adopting_newvarieties_target[0]['value']))>0 ? 'green':'red'};"> ${(response.adopting_newvarieties - response.adopting_newvarieties_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #3.9: RCIH-wise percent women and youth buying high quality seed of improved varieties from different sources : <strong style="font-size: 16px;">${response.seed_improvedvarities}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.seed_improvedvarities - response.seed_improvedvarities_target[0]['value']))>0 ? 'green':'red'};"> ${(response.seed_improvedvarities - response.seed_improvedvarities_target[0]['value'])}</font></h6><hr class="new4"><h6 class="ml-10 info">Indicator #3.10: RCIH-wise average number of seasons that women and youth farmers recycle their seed before replacing it : <strong style="font-size: 16px;">${response.farmersrecycle}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.farmersrecycle - response.farmersrecycle_target[0]['value']))>0 ? 'green':'red'};"> ${(response.farmersrecycle - response.farmersrecycle_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.3: RCIH-wise number of demonstrations conducted : <strong style="font-size: 16px;">${response.demos_conducted}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.demos_conducted - response.demos_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${(response.demos_conducted - response.demos_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.4: RCIH-wise number of field days conducted : <strong style="font-size: 16px;">${response.fielddays_conducted}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.fielddays_conducted - response.fielddays_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${(response.fielddays_conducted - response.fielddays_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.5: RCIH-wise number of seed fairs and agriculture shows conducted</h6>
                <h6 class="ml-10"><font style="color: gray;">Seed fairs conducted :</font> <strong style="font-size: 16px;"> ${(response.seed_conducted)}</strong></h6>
                <h6 class="ml-10"><font style="color: gray;">Agriculture shows conducted :</font> <strong style="font-size: 16px;"> ${(response.agri_conducted)}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${(((response.seed_conducted+response.agri_conducted) - response.seed_agri_conducted_target[0]['value']))>0 ? 'green':'red'};"> ${((response.seed_conducted+response.agri_conducted) -response.seed_agri_conducted_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.6: RCIH-wise number of radio/ TV shows facilitated/conducted : <strong style="font-size: 16px;">${response.radio_tv_shows}</strong></h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.radio_tv_shows - response.radio_tv_shows_target[0]['value']))>0 ? 'green':'red'};"> ${(response.radio_tv_shows - response.radio_tv_shows_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.14: Volume of breeder seed produced (tons) : <strong style="font-size: 16px;">${response.breederseed}</strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.breederseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${(response.breederseed - response.seed_count_target[0]['value'])}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.15: Volume of foundation seed produced (tons : <strong style="font-size: 16px;">${response.foundationseed} </strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.foundationseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${Number((response.foundationseed - response.seed_count_target[0]['value']).toFixed(2))}</font></h6><hr class="new4">
                <h6 class="ml-10 info">Indicator #4.16: Volume of certified and QDS seed produced (tons) : <strong style="font-size: 16px;">${response.certifiedqdsseed} </strong> Tons</h6>
                <h6 class="ml-10">Variance : <font style="color: ${((response.certifiedqdsseed - response.seed_count_target[0]['value']))>0 ? 'green':'red'};"> ${Number((response.certifiedqdsseed - response.seed_count_target[0]['value']).toFixed(2))}</font></h6><hr class="new4">
            </div>
          `;
          $("#rcih_indicaters").html(html);
  
            }
          ).catch().finally();
        }
        const greenIcon = L.icon({
            iconUrl: `${imgUrl}map_pointer/greenmarker.png`,
            shadowUrl:
              "https://unpkg.com/leaflet@1.3.1/dist/images/marker-shadow.png",
          });
        let markers = L.markerClusterGroup();
            for (let i = 0; i < RCIH.length; i++) {
              let rcih_name = RCIH[i]["rcih_name"];
              let lat = RCIH[i]["lat"];
              let lng = RCIH[i]["lang"];
              let location = RCIH[i]["location"];
              let Organization = RCIH[i]["Organization"];
              let marker = L.marker(new L.LatLng(lat, lng), {
                rcih_name: rcih_name,
                Organization: Organization,
                location: location,
                icon: greenIcon,
              });
              const html = `
                <div class="row">
                  <div class="col-sm-12">
                    <span>${rcih_name}</span>
                    <p> ${Organization}</p>
                    <p> ${location}</p>
                  </div>
                </div>
            `;
              // marker /.on('click', onMapClick);
              // marker.bindPopup(html);
              markers.addLayer(marker);
              /* adding click event */
              marker.on("click", function (e) {
                let name = e.target.options;
                // let side_info = name + "Clicked.";
                // adding info into side bar
                $("#rcih_location").html(name.location);
                $("#rcih_organization").html(name.Organization);
                $("#rcih_name").html(name.rcih_name);
                let markerData=RCIH[i];
                getOverviewRcihData(markerData)
                $("#program_wise_data").css("display","none");
                $("#rcih_wise_data").css("display","block");
                $('#back_button').css('display','block');
                $('#program_wise_data_back').css('display','none');
                $('#rcih_wise_data_back').css('display','none');
              });
            }
            this.map.addLayer(markers);
            let popup = L.popup();

            
      }

      

      
}
