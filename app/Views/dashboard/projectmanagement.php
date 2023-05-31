<style>
    .search {
            position: absolute;
            top: 16px;
            right: -272px;
        }
        .app-content.page-body {
            margin-top: 5rem!important;
        }
        @media only screen and (max-width: 600px){
.stricky {
        position: relative;
        top: 4px;
        width: auto;
        z-index: 111;
    }
}
</style>


<div class="app-content page-body mb-5">
<div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card border-0">
                        <div class="card-header border-0 bg-white">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="title">SUMMARY</h3>
                                </div>
                                <div>
                                    <input class="form-control" id="myInput" type="text" placeholder="Search.." style="width: 150px;border-radius: 30px;">
                                    <span class="search"><img src="<?php echo base_url(); ?>include/assets/images/search.png"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                  <tr class="tbl_bg_head">
                                    <th>Serial #</th>
                                    <th>Cluster</th>
                                    <th># of Indicators</th>
                                    <th>Reported</th>
                                    <th>Yet to Report</th>
                                    <th style="width: 300px;">Overall Progress</th>
                                  </tr>
                                </thead>
                                <tbody id="myTable">
                                  <tr>
                                    <td>1</td>
                                    <td>Cluster Name</td>
                                    <td>45</td>
                                    <td>15</td>
                                    <td>30</td>
                                    <td>
                                       <div class="d-flex justify-content-beetween">
                                           <div>
                                            <div class="progress">
                                                <div class="progress-bar1" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
                                                </div>
                                              </div>
                                           </div>
                                           <div>
                                            <span class="text-percent pl-3">33% </span>
                                           </div>
                                       </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Cluster Name</td>
                                    <td>45</td>
                                    <td>15</td>
                                    <td>30</td>
                                    <td>
                                        <div class="d-flex justify-content-beetween">
                                            <div>
                                             <div class="progress">
                                                 <div class="progress-bar2" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;">
                                                 </div>
                                               </div>
                                            </div>
                                            <div>
                                             <span class="text-percent pl-3">50% </span>
                                            </div>
                                        </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Cluster Name</td>
                                    <td>45</td>
                                    <td>15</td>
                                    <td>30</td>
                                    <td>
                                        <div class="d-flex justify-content-beetween">
                                            <div>
                                             <div class="progress">
                                                 <div class="progress-bar3" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;">
                                                 </div>
                                               </div>
                                            </div>
                                            <div>
                                             <span class="text-percent pl-3">87% </span>
                                            </div>
                                        </div>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

