<!-- Page Script -->
<style type="text/css">
	.h4_heading{
		color: #f44336 !important;
	    font-size: 18px !important;
	    font-weight: bold;
	}
	.table-responsive th{
		color: #FFFFFF;
	}
	h6{
		color: #1f7fb6 !important;
	    font-size: 14px !important;
	    font-weight: bold;
	}
</style>

<script type="text/javascript">
function close_window() {
   
   close();
 
}	
	function getchild_field(data, $elem) {
		var classname = 'childof'+data.field_id;

		var fieldtype = data.fieldtype;

		$.ajax({
        	url: "<?php echo base_url(); ?>reporting/check_childfields",
	        type: "POST",
	        dataType: "json",
	        data : {
	           field_id : data.field_id,
	           field_value : data.field_value,
	           calltype : data.calltype,
	           form_id : <?php echo $this->uri->segment(6); ?>
	        },
	        error : function(){
	        	if(fieldtype == 'groupfield'){
	        		$elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
	        	}else{
	        		$('.'+classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
	        	}	        

		        setTimeout(function(){
		          	$('.'+classname).empty();
		        }, 5000);
	        },
	        success : function (response) {
	        	if(response.status == 1){
	        		if(response.child_field.length > 0){
	        			var CHILD_HTML = '';
	        			for(var field of response.child_field) {
	        				switch (field.type){
	        					case 'radio-group' :
	        						CHILD_HTML += '<div class="col-md-4">\
										<div class="form-group">\
											<label class="english">'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
											if(field.description != null){ 
											  	CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
											CHILD_HTML += '<div class="form-check">\
										    	<div class="row">';
										    		field.options.forEach(function(option, optionindex ){
										    			CHILD_HTML += '<div class="col-md-4">';
										    				if(field.inline == "true" || field.inline == "TRUE"){ 
										    					var radioclass = 'radio-inline'; 
										    				}else{
										    					var radioclass = '';
										    				}
										    				var inputradioclass = (field.className != '') ? field.className : "";
										    				if(typeof field.value !== 'undefined'){
										    					var columnfield = "field_"+field.field_id;
										    					if(field.value == option.value){
										    						var selectedvalue = "checked";
										    					}else{
										    						var selectedvalue = '';
										    					}
										    				}else{
										    					if(option.selected == 'true' || option.selected == 'TRUE'){ 
											    					var selectedvalue = "checked"; 
											    				}else{
											    					var selectedvalue = '';
											    				}
										    				}
										    				if(fieldtype == 'groupfield'){
										    					var radioname = "field_"+field.field_id+"["+data.groupfieldcount+"]";
										    				}else{
										    					var radioname = "field_"+field.field_id+"";
										    				}
										    				var requiredval = (field.required == 1) ? "required" : "notrequired";
										          			CHILD_HTML += '<label class="'+radioclass+'" >\
										            			<input type="radio" name="'+radioname+'"  class="'+inputradioclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" >'+option.label+'\
										          			</label>\
										        		</div>';
										    		});
										    	CHILD_HTML += '</div>\
										  	</div>';
											CHILD_HTML += '<p class="error red-800"></p>\
										</div>\
				                    </div>';
				                    if(field.child_count > 0){
			                    		CHILD_HTML += '<div class="col-md-12">\
			                    			<div class="row childfields childof'+field.field_id+'"></div>\
			                    		</div>';
			                    	}
	        						break;

	        					case 'checkbox-group' :
	        						//console.log('hai');
	        						CHILD_HTML += '<div class="col-md-4">\
										<div class="form-group">\
											<label class="english">'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
											if(field.description != null){ 
											  	CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
											CHILD_HTML += '<div class="form-check">\
										    	<div class="row">';
										    		field.options.forEach(function(option, optionindex ){
										    			CHILD_HTML += '<div class="col-md-4">';
										    				if(field.inline == "true" || field.inline == "TRUE"){ 
										    					var radioclass = 'radio-inline'; 
										    				}else{
										    					var radioclass = '';
										    				}
										    				var inputcheckboxclass = (field.className != '') ? field.className : "";
										    				if(typeof field.value !== 'undefined'){
										    					var columnfield = "field_"+field.field_id;
										    					if(field.value == option.value){
										    						var selectedvalue = "checked";
										    					}else{
										    						var selectedvalue = '';
										    					}
										    				}else{
										    					if(option.selected == 'true' || option.selected == 'TRUE'){ 
											    					var selectedvalue = "checked"; 
											    				}else{
											    					var selectedvalue = '';
											    				}
										    				}
										    				if(fieldtype == 'groupfield'){
										    					var checkbox_name = "field_"+field.field_id+"["+data.groupfieldcount+"][]";
										    				}else{
										    					var checkbox_name = "field_"+field.field_id+"[]";
										    				}
										    				var requiredval = (field.required == 1) ? "required" : "notrequired";
										          			CHILD_HTML += '<label class="'+radioclass+'" >\
										            			<input type="checkbox" name="'+checkbox_name+'"  class="'+inputcheckboxclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" >'+option.label+'\
										          			</label>\
										        		</div>';
										    		});
										    	CHILD_HTML += '</div>\
										  	</div>';
											CHILD_HTML += '<p class="error red-800"></p>\
										</div>\
				                    </div>';
				                    if(field.child_count > 0){
			                    		CHILD_HTML += '<div class="col-md-12">\
			                    			<div class="row childfields childof'+field.field_id+'"></div>\
			                    		</div>';
			                    	}
	        						break;

	        					case 'select':
	        						CHILD_HTML += '<div class="col-md-4">\
										<div class="form-group">\
											<label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
											if(field.description != null){
		                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
								  			var requiredval = (field.required == 1) ? "required" : "notrequired";
								  			if(fieldtype == 'groupfield'){
								  				if(field.multiple == 'true' || field.multiple == 'TRUE'){
								  					var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"][]";
								  					var selectmultiple = "multiple";
								  				}else{
								  					var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
								  				}
						    					
						    				}else{
						    					if(field.multiple == 'true' || field.multiple == 'TRUE'){
						    						var select_name = "field_"+field.field_id+"[]";
						    						var selectmultiple = "multiple";
						    					}else{
						    						var select_name = "field_"+field.field_id+"";
						    					}						    					
						    				}
						    				CHILD_HTML += '<select name="'+select_name+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+requiredval+'" data-field_id = "'+field.field_id+'"  data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-maxlength ="'+field.maxlength+'">';
								   			if(field.multiple == 'true' || field.multiple == 'TRUE'){
								    		}else{
								      			CHILD_HTML += '<option value="">Select an option</option>';
								    		}
								    		
								    		field.options.forEach(function(option, optionindex){
								    			if(typeof field.value !== 'undefined'){
							    					if(field.value == option.value){
							    						var optionselected = "selected";
							    					}else{
							    						var optionselected = '';
							    					}
							    				}else{
							    					if(option.selected == "true" || option.selected == "TRUE"){
									    				var optionselected = "selected";
									    			}else{
									    				var optionselected = "";
									    			}
							    				}

								    			CHILD_HTML +='<option value = "'+option.value+'" '+optionselected+'>'+option.label+'</option>';
								    		});
								    		CHILD_HTML += '</select>\
								    		<p class="error red-800"></p>\
										</div>\
				                    </div>';
				                    if(field.child_count > 0){
			                    		CHILD_HTML += '<div class="col-md-12">\
			                    			<div class="row childfields childof'+field.field_id+'"></div>\
			                    		</div>';
			                    	}
	        						break;

	        					case 'number':
	        						CHILD_HTML += '<div class="col-md-4">\
			                        	<div class="form-group">\
			                          		<label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
											if(field.description != null){
			                            		CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
						    				var inputclass = (field.className != '') ? field.className : "";
						    				var requiredval = (field.required == 1) ? "required" : "notrequired";
						    				if(typeof field.value !== 'undefined' && field.value != null){
						    					var columnfield = "field_"+field.field_id;
						    					if(field.value == null){
						    						var numberfield_value = '';
						    					}else{
						    						var numberfield_value = field.value;
						    					}
						    				}else{
						    					var numberfield_value = '';
						    				}
						    				if(fieldtype == 'groupfield'){
						    					var number_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
						    				}else{
						    					var number_name = "field_"+field.field_id+"";
						    				}
	                             			switch (field.subtype) {
				                                case 'desimal': 
				                                  	CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' decimal" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" data-maxvalue = "'+field.max_val+'"  value="'+numberfield_value+'" >';
				                                break;

				                                case 'number':
				                                  	CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' number" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" data-maxvalue = "'+field.max_val+'" value="'+numberfield_value+'" >';
				                                break;

				                                case 'latitude':
				                                  	CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' latlong" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
				                                break;

				                                case 'longitude':
				                                  	CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' latlong" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
				                                break;
				                                
				                                default:
				                                  	CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' numberfield" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
				                                break;
	                              			}
	                              			CHILD_HTML += '<p class="error red-800"></p>\
	                              			<p class="maxlengtherror red-800"></p>\
			                        	</div>\
			                      	</div>';
	        						break;

	        					case 'text' :
	        						CHILD_HTML += '<div class="col-md-6">\
				                      	<div class="form-group">\
					                        <label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
					                        if(field.description != null){
		                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
						    				var inputclass = (field.className != '') ? field.className : "";
						    				var requiredval = (field.required == 1) ? "required" : "notrequired";
						    				if(typeof field.value !== 'undefined' && field.value != null){
						    					var columnfield = "field_"+field.field_id;
						    					var textfield_value = field.value;
						    				}else{
						    					var textfield_value = '';
						    				}
						    				if(fieldtype == 'groupfield'){
						    					var text_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
						    				}else{
						    					var text_name = "field_"+field.field_id+"";
						    				}
			                            	CHILD_HTML += '<input type="text" name="'+text_name+'" class="'+inputclass+'" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" >';
			                            	CHILD_HTML += '<p class="error red-800"></p>\
			                            	<p class="maxlengtherror red-800"></p>\
				                      	</div>\
				                    </div>';
	        						break;

	        					case 'header':
				                    CHILD_HTML += '<div class="col-md-12">\
				                    	<'+field.subtype+' style="margin-top: 0px; margin-bottom: 20px;">'+field.label+'</'+field.subtype+'>\
				                    </div>';
				                	break;

				                case 'date':
				                	CHILD_HTML += '<div class="col-md-4">\
				                      	<div class="form-group">\
					                        <label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
					                        if(field.description != null){
		                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
						    				var inputclass = (field.className != '') ? field.className : "";
						    				var requiredval = (field.required == 1) ? "required" : "notrequired";
						    				if(typeof field.value !== 'undefined' && field.value != null){
						    					var columnfield = "field_"+field.field_id;
						    					var textfield_value = field.value;
						    				}else{
						    					var textfield_value = '';
						    				}
						    				if(fieldtype == 'groupfield'){
						    					var date_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
						    				}else{
						    					var date_name = "field_"+field.field_id+"";
						    				}
			                              	CHILD_HTML += '<input type="text" name="'+date_name+'" class="'+inputclass+' picker" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" autocomplete="off" onkeydown="return false">';
			                            	CHILD_HTML += '<p class="error red-800"></p>\
			                            	<p class="maxlengtherror red-800"></p>\
				                      	</div>\
				                    </div>';
				                	break;

				                case 'month':
				                	CHILD_HTML += '<div class="col-md-4">\
				                      	<div class="form-group">\
					                        <label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
					                        if(field.description != null){
		                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
						    				var inputclass = (field.className != '') ? field.className : "";
						    				var requiredval = (field.required == 1) ? "required" : "notrequired";
						    				if(typeof field.value !== 'undefined' && field.value != null){
						    					var columnfield = "field_"+field.field_id;
						    					var textfield_value = field.value;
						    				}else{
						    					var textfield_value = '';
						    				}
						    				if(fieldtype == 'groupfield'){
						    					var month_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
						    				}else{
						    					var month_name = "field_"+field.field_id+"";
						    				}
			                            	CHILD_HTML += '<input type="text" name="'+month_name+'" class="'+inputclass+' monthpicker" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" autocomplete="off" onkeydown="return false">';
			                            	CHILD_HTML += '<p class="error red-800"></p>\
			                            	<p class="maxlengtherror red-800"></p>\
				                      	</div>\
				                    </div>';
				                	break;

				                case 'uploadfile':
				                	CHILD_HTML += '<div class="col-md-12">';
				                		if(field.subtype == 'excel'){
					                      	CHILD_HTML += '<div class="form-group">\
												<label>'+field.label;
												  	if(field.required == 1){ 
												  		CHILD_HTML += '<font color="red">*</font>';
												  	}
												CHILD_HTML += '</label>';
												if(field.description != null){
			                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
												}
												var requiredval = (field.required == 1) ? "required" : "notrequired";
												(field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>' : '';
					                        	CHILD_HTML += '<div class="row">\
					                          		<div class="col-md-6">\
					                          			<p style="font-size: 10px; font-style: italic; color: gray;">Note: only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>\
					                          			Use this Excel template to upload the data:<a href="<?php echo base_url(); ?>includeout/avisareporting_excelformats/'+field.description+'" download=""><img src="<?php echo base_url(); ?>includeout/images/excel.png" style="width: 30px;">'+field.description+'</a>\
					                            		<input type="file" class="uploadfile" data-fieldtype = "'+field.type+'" data-fieldsubtype = "'+field.subtype+'"  data-required = "'+requiredval+'" name="field_'+field.field_id+'">\
					                            		<p style="font-size: 10px; font-style: italic; color: gray;">\
					                              			File size must be less than 500KB<br/>\
					                              			Only .xlsx, .xls file type are allowed\
					                            		</p>\
					                           			<p class="error" style="color: red"></p>\
					                          		</div>\
					                        	</div>\
					                      	</div>';
						                }else if(field.subtype == 'document'){
						                	CHILD_HTML += '<div class="form-group">\
												<label>'+field.label;
												  	if(field.required == 1){ 
												  		CHILD_HTML += '<font color="red">*</font>';
												  	}
												CHILD_HTML += '</label>';
												if(field.description != null){
			                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
												}
												var requiredval = (field.required == 1) ? "required" : "notrequired";
												(field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>' : '';
					                        	CHILD_HTML += '<div class="row">\
					                          		<div class="col-md-6">\
					                            		<input type="file" class="uploaddocument" data-fieldtype = "'+field.type+'" data-fieldsubtype = "'+field.subtype+'"  data-required = "'+requiredval+'" name="field_'+field.field_id+'">\
					                            		<p style="font-size: 10px; font-style: italic; color: gray;">\
					                              			File size must be less than 500KB<br/>\
					                              			Only .pdf file type are allowed\
					                            		</p>\
					                           			<p class="error" style="color: red"></p>\
					                          		</div>\
					                        	</div>\
					                      	</div>';
						                }
				                    CHILD_HTML += '</div>';
				                	break;

				                case 'textarea' :
				                	CHILD_HTML += '<div class="col-md-4">\
				                      	<div class="form-group">\
					                        <label>'+field.label;
											  	if(field.required == 1){ 
											  		CHILD_HTML += '<font color="red">*</font>';
											  	}
											CHILD_HTML += '</label>';
					                        if(field.description != null){
		                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
											}
						    				var inputclass = (field.className != '') ? field.className : "";
						    				var requiredval = (field.required == 1) ? "required" : "notrequired";

						    				if(typeof field.value !== 'undefined' && field.value != null){
						    					var columnfield = "field_"+field.field_id;
						    					var textfield_value = field.value;
						    				}else{
						    					var textfield_value = '';
						    				}
						    				CHILD_HTML += '<textarea name="field_'+field.field_id+'" rows="8" class="'+inputclass+'" data-subtype="'+field.subtype+'" data-maxlength = "'+field.maxlength+'" data-required="'+requiredval+'">'+textfield_value+'</textarea>';
			                            	CHILD_HTML += '<p class="error red-800"></p>\
			                            	<p class="maxlengtherror red-800"></p>\
				                      	</div>\
				                    </div>';
				                	break;

				                case 'uploadgroupdata_excel':
				               		CHILD_HTML += '<div class="col-md-12" style="margin-bottom: 15px;">\
				               			<a class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;" target="_blank">Upload data using excel</a>\
				               		</div>';
				               		break;

				               	case 'group': 
        							CHILD_HTML += '<div class="col-md-12 addmoremaindiv">\
										<div class="row addmore addmore_div">';
											var indicator_groupfieldscount = field.groupfields.length;
											var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
								        	CHILD_HTML += '<div class="col-md-'+i_divmainclass+'">\
								        		<div class="row">';
								        			field.groupfields.forEach(function(indicatorgroupfield, g_index){
								        				if(indicator_groupfieldscount == 1){
								        					var i_divclass = 12
								        				}else if(indicator_groupfieldscount == 2){
								        					var i_divclass = 6;
								        				}else if(indicator_groupfieldscount == 3){
								        					var i_divclass = 4;
								        				}else{
								        					var i_divclass = 3;
								        				}
								        				switch(indicatorgroupfield.type){
								        					case 'text':
								        						CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
										        					<div class="form-group">';
											        					CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																		if(indicatorgroupfield.description != null){
																			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
																		CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="" data-subtype="'+indicatorgroupfield.subtype+'">\
																		<p class="error red-800"></p>\
										                            	<p class="maxlengtherror red-800"></p>\
										        					</div>\
										        				</div>';
								        						break;

								        					case 'textarea' :
											                	CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
											                      	<div class="form-group">';
												                        CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
												                        if(indicatorgroupfield.description != null){
									                            			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
													    				var inputclass = (indicatorgroupfield.className != '') ? indicatorgroupfield.className : "";
													    				var requiredval = (indicatorgroupfield.required == 1) ? "required" : "notrequired";

													    				if(typeof indicatorgroupfield.value !== 'undefined' && indicatorgroupfield.value != null){
													    					var columnfield = "field_"+indicatorgroupfield.field_id;
													    					var textfield_value = indicatorgroupfield.value;
													    				}else{
													    					var textfield_value = '';
													    				}
													    				CHILD_HTML += '<textarea name="field_'+indicatorgroupfield.field_id+'[0]" rows="8" class="'+inputclass+'" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required="'+requiredval+'">'+textfield_value+'</textarea>';
										                            	CHILD_HTML += '<p class="error red-800"></p>\
										                            	<p class="maxlengtherror red-800"></p>\
											                      	</div>\
											                    </div>';
											                	break;

								        					case 'select':
										                    	CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
																	<div class="form-group">';
																		CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																		if(indicatorgroupfield.description != null){
																			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
																		if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
															  				var selectname = "field_"+indicatorgroupfield.field_id+"[0][]";
															  				var selectmultiple = "multiple";
															  			}else{
															  				var selectname = "field_"+indicatorgroupfield.field_id+"[0]";
															  				var selectmultiple = "";
															  			} 
															  			CHILD_HTML +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'" data-fieldtype="groupfield" data-groupfieldcount = "0" data-maxlength ="'+indicatorgroupfield.maxlength+'" data-fieldtype="groupfield">';
															   			if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
															      		}else{
															        		CHILD_HTML += '<option value="">Select an option</option>';
															        	}
															        	indicatorgroupfield.options.forEach(function(option, index){
															        		if(option.selected == 'true' || option.selected == 'TRUE'){ 
										                          				var select_value = "selected"; 
										                          			}else{
										                          				var select_value = '';
										                          			}
										                          			CHILD_HTML += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
															        	});
														    			CHILD_HTML += '</select>\
														    			<p class="error red-800"></p>\
																	</div>\
										                    	</div>';
										                    	if(indicatorgroupfield.child_count > 0){
										                    		CHILD_HTML += '<div class="col-md-12">\
										                    			<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
										                    		</div>';
										                    	}
							        							break;

							        						case 'radio-group':
											                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
																	<div class="form-group">';
																		CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																		if(indicatorgroupfield.description != null){
																			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
																		CHILD_HTML += '<div class="form-check">\
																	    	<div class="row">';
																	    		indicatorgroupfield.options.forEach(function(option, index){
																	    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
																	    			if(option.selected == 'true' || option.selected == 'TRUE'){ 
											                                			var radio_value = "checked"; 
											                                		}else{
											                                			var radio_value = '';
											                                		}
																	    			CHILD_HTML += '<div class="col-md-6">\
																	    				<label><input type="radio" name="field_'+indicatorgroupfield.field_id+'[0]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>\
																	    			</div>';
																	    		});
																	    	CHILD_HTML += '</div>\
																	  	</div>\
																	  	<p class="error red-800"></p>\
																	</div>\
											                    </div>';
											                    if(indicatorgroupfield.child_count > 0){
										                    		CHILD_HTML += '<div class="col-md-12">\
										                    			<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
										                    		</div>';
										                    	}
							        							break;

							        						case 'checkbox-group':
											                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
																	<div class="form-group">';
																		CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																		if(indicatorgroupfield.description != null){
																			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
																		CHILD_HTML += '<div class="form-check row">\
																	    	<div class="col-md-12">';
																	    		indicatorgroupfield.options.forEach(function(option, index){
																	    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
																	    			if(option.selected == 'true' || option.selected == 'TRUE'){ 
											                                			var radio_value = "checked"; 
											                                		}else{
											                                			var radio_value = '';
											                                		}
																	    			CHILD_HTML += '<label><input type="checkbox" name="field_'+indicatorgroupfield.field_id+'[0][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>';
																	    		});
																	    	CHILD_HTML += '</div>\
																	  	</div>\
																	  	<p class="error red-800"></p>\
																	</div>\
											                    </div>';
											                    if(indicatorgroupfield.child_count > 0){
										                    		CHILD_HTML += '<div class="col-md-12">\
										                    			<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
										                    		</div>';
										                    	}
							        							break;

							        						case 'number':
							        							CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
										                        	<div class="form-group">';
										                          		CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																		if(indicatorgroupfield.description != null){
																			CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																		}
								                             			switch (indicatorgroupfield.subtype) {
											                                case 'desimal':
											                                	CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' decimal" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
											                                	break;

											                                case 'number':
											                                	CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' number" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
											                                	break;

											                                case 'latitude':
											                                	CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
											                                  	break;

											                                case 'longitude':
											                                	CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
											                                  	break;
											                                
											                                default:
											                                	CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' numberfield" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
											                                  	break;
								                              			}
									                              		CHILD_HTML += '<p class="error red-800"></p>\
								                              			<p class="maxlengtherror red-800"></p>\
							                              			</div>\
									                      		</div>';
							        							break;
								        				}		
								        			});
								        		CHILD_HTML += '</div>\
								        	</div>\
								        	<div class="col-md-1 mt-20 add_remove_button">\
								        		<button type="button" class="btn btn-success btn-sm addmorefields pull-left" style="margin-bottom: 15px; margin-top:10px;"><span class="glyphicon glyphicon-plus"></span> Add\
					                    		</button>\
								        	</div>\
								        	<div class="col-md-12">\
								        		<hr style="margin-top: 0px; border: 1px; height: 1px; background-color: #8e8ec0;">\
								        	</div>\
								        </div>\
									</div>';
        							break;
		        			}
	        			};

	        			if(fieldtype == 'groupfield'){
	        				$elem.closest('.row').find('.'+classname).html(CHILD_HTML);
	        			}else{
	        				$('.'+classname).html(CHILD_HTML);
	        			}

	        			//Date picker
					    $('.picker').datepicker({
					       format: 'yyyy-mm-dd',
					       autoclose: true
					    });

					    //month picker
						$('.monthpicker').datepicker({
							format: 'yyyy-mm',
							autoclose: true,
							viewMode: "months", 
							minViewMode: "months"
						});

	        		}
	        	}else{
			        if(fieldtype == 'groupfield'){
			        	$elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');

			        	$('html,body').animate({
				          	scrollTop: $elem.closest('.row').find('.'+classname).offset().top - 300
				        }, 500);

				        setTimeout(function(){
				          	$elem.closest('.row').find('.'+classname).empty();
				        }, 5000);
			        }else{
			        	$('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');

			        	$('html,body').animate({
				          	scrollTop: $('.'+classname).offset().top - 300
				        }, 500);

				        setTimeout(function(){
				          	$('.'+classname).empty();
				        }, 5000);
			        }
	        	}
	        }
        });
	}
</script>

<?php $avisa_countries = array(
	//34 => 
); ?>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="sendBackModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Send back query</h3>
			</div>
			
			<?php echo form_open('', array('id'=>'sendBackForm')); ?>
			<div class="modal-body">
				<div class="form-group">
					<label>
						<strong style="text-decoration:underline;">Send Back To The Following Users</strong><br/>
						Level 3 Users<br/>
						User Who Approved - <span style="font-weight:500;" id="backToApproved"></span><br/>
						User Who Submitted - <span style="font-weight:500;" id="backToSubmitted"></span>
					</label>
				</div>
				<div class="form-group">
					<label for="reason">Query</label> <span class="text-danger">*</span>
					<textarea id="query" placeholder="Provide query to send back..." class="form-control" name="query" rows="5" style="resize:vertical;"></textarea>
					<span class="query error text-danger"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-success">Send Back</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="app-content page-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
			<a href="javascript:close_window();" class="btn btn-sm btn-success pull-right">Back</a>
				<h4><?php echo $title['title']; ?></h4>
			</div>
			<div class="col-md-12 mt-3">
				<?php if(count($form_data) > 0){
					//print_r($form_data);
					foreach ($form_data as $key => $data) { 
						$data_array = json_decode($data['form_data'], true); ?>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="row" id="data_<?php echo $key; ?>">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-1">
														<label style="background-color: #ff0000; width: 30px; text-align: center; color: #FFFFFF !important; margin-bottom: 0px; margin-top:10px;"><?php echo $key+1; ?></label>
													</div>
													<div class="col-md-2">
														<p class=""><?php if($data['status'] == 3){ ?>
															Status: <span class="text-success"><b>Data approved</b></span>
														<?php } ?></p>
														<p class=""><?php if($data['status'] == 2){ ?>
															Status: <span class="text-warning"><b>Data Submitted</b></span>
														<?php } ?></p>
														<p class=""><?php if($data['status'] == 1){ ?>
															Status: <span class="text-alert"><b>Data Saved</b></span>
														<?php } ?></p>
														<p class=""><?php if($data['status'] == 0){ ?>
															Status: <span class="text-alert"><b>Data Deleted</b></span>
														<?php } ?></p>
													</div>
													<div class="col-md-2">
													<?php if($data['useaprrname']!=''){?><p class="pull-left">Approved by: <?php echo $data['useaprrname']; ?></p>
													<?php } ?></div>
													<div class="col-md-2">
														<?php if($data['approve_date']!='') { ?><p class="pull-right"> Approved on: <?php echo $data['approve_date']; ?> (UTC)</p><?php } ?>
													</div>
													<div class="col-md-2">
													<?php if($data['username']!=''){?>	<p class="pull-left">Submitted by: <?php echo $data['username']; ?></p>
													<?php } ?></div>
													<div class="col-md-2">
														<p class="pull-right"> Submitted on: <?php echo $data['reg_date_time']; ?> (UTC)</p>
													</div>
												</div>
												<hr style="margin-top: 0px; border: none; height: 1px; background-color: #030195;">
											</div>
											<div class="col-md-12">
												<?php if(($data['user_id'] == $this->session->userdata('login_id') && ($data['status'] == 2 || $data['status'] == 1)) || $this->session->userdata('role') == 6){ ?>
													<a href="javascript:void(0);" class="pull-right delete_data" style="color: red;" data-recordid = "<?php echo $data['data_id']; ?>"><i class="fa fa-trash" style="font-size:18px;"></i> Delete record</a>
												<?php } ?>

												<?php if($data['status'] == 2 && ($this->session->userdata('role') != 6 || ($data['user_id'] == $this->session->userdata('login_id')))){ ?>
													<a href="javascript:void(0);" class="pull-right getfields_tosubmit_savedata" style="color: blue; margin-right: 15px;" data-urole ="<?php echo $this->session->userdata('role'); ?>" data-recordid = "<?php echo $data['data_id']; ?>" data-formtype="edit"><i class="fa fa-pencil" style="font-size:18px;"></i> Edit</a>
												<?php } ?>

												<?php if($data['status'] == 1 && ($this->session->userdata('role') != 6 || ($data['user_id'] == $this->session->userdata('login_id')))){ ?>
													<a href="javascript:void(0);" class="pull-right getfields_tosubmit_savedata" style="color: blue; margin-right: 15px;" data-urole ="<?php echo $this->session->userdata('role'); ?>" data-recordid = "<?php echo $data['data_id']; ?>" data-formtype="save"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit</a>
												<?php } ?>

												<?php if($this->session->userdata('role') == 5){ ?>
													<a href="javascript:void(0);" class="pull-right getfields_tosubmit_savedata" style="color: blue; margin-right: 15px;" data-urole ="<?php echo $this->session->userdata('role'); ?>" data-recordid = "<?php echo $data['data_id']; ?>" data-formtype="edit"><i class="fa fa-pencil" style="font-size:18px;"></i> Edit data</a>
												<?php } ?>

												<?php if($this->session->userdata('role') == 6 && $data['status'] == 3){ ?>
													<button type="button" class="btn btn-sm btn-warning pull-right send_back" data-recordid="<?php echo $data['data_id']; ?>" data-subby="<?php echo $data['username']; ?>" data-apprby="<?php echo $data['useaprrname']; ?>" style="margin-top: -10px; margin-right:10px;">Send Back</button>
												<?php } ?>
											</div>
											
											<div class="col-md-12"></div>
											
											<div class="col-md-12">
												<div class="table-responsive">
								    				<table class="table table-bordered" id="datatable">
														<thead>
															<tr style="background-color:#050c43;">
																<th>Country</th>
																<th>Crop</th>
																<th>Comment</th>
																<?php foreach ($form_fields as $lkey => $value) { ?>
																	<th><?php echo $value['label']; ?></th>											
																<?php } ?>
															</tr>
														</thead>
														<tbody>									
															<tr>
																<td><?php echo $data['country_name']; ?></td>
																<td><?php echo $data['crop_name']; ?></td>
																<td><?php echo ($data['comment'] == NULL) ? "N/A" : $data['comment']; ?></td>
																<?php foreach ($form_fields as $f_key => $field) {
																	$field_key = "field_".$field['field_id'];

																	switch ($field['type']) {
																		case 'header':
																			echo "<td></td>";
																			break;
																		
																		default:
																			if(!isset($data_array[$field_key]) || $data_array[$field_key] == '' || $data_array[$field_key] == NULL){
																				echo "<td>N/A</td>";
																			}else{
																				if($field['type'] != 'uploadfile'){ ?>
																					<td><?php echo $data_array[$field_key];  ?></td>
																				<?php }else{ ?>
																					<td>
																						<a href="<?php echo base_url(); ?>upload/survey/<?php echo $data_array[$field_key]; ?>" download>Download file</a>
																					</td>
																				<?php }
																			}
																			break;
																	}
																} ?>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											<div class="col-md-12 mt-10">
												<?php if (isset($group_array) && (count($data) > 0)) {
													foreach ($group_array as $key => $group) { ?>
														<h4 class="title"><?php echo $group['group_lable']['label']; ?></h4>
														<div class="table-responsive">
									        				<table class="table table-bordered" id="datatable">
																<thead>
																	<tr style="background-color:#050c43;">
																		<th>Sl.no</th>
																		<?php foreach ($group['group_fields'] as $key => $g_field) { ?>
																			<th style="width: 31%;"><?php echo $g_field['label']; ?></th>
																		<?php }
																		if((($data['status'] == 2 || $data['status'] == 1) && ($data['user_id'] == $this->session->userdata('login_id'))) || $this->session->userdata('role') == 6){ ?>
																			<th>Action</th>
																		<?php } ?>
																	</tr>
																</thead>
																<tbody>
																	<?php if(count($data['groupdata']) > 0){
																		foreach ($data['groupdata'] as $gkey => $g_data) { 
																			$g_data_array = json_decode($g_data['formgroup_data'], true);
																			if($group['group_lable']['field_id'] == $g_data['groupfield_id']){ ?>
																				<tr id="data_<?php echo $key; ?><?php echo $gkey; ?>">
																					<td><?php echo $gkey+1; ?></td>
																					
																					<?php foreach ($group['group_fields'] as $key => $g_field) { 
																						$field_key = "field_".$g_field['field_id']; ?>
																						<td>
																							<?php echo (isset($g_data_array[$field_key])) ? $g_data_array[$field_key] : 'N/A';  ?>
																						</td>
																					<?php }
																					if((($data['status'] == 2 || $data['status'] == 1) && ($data['user_id'] == $this->session->userdata('login_id'))) || $this->session->userdata('role') == 6){ ?>
																						<td>
																							<a class="delete_groupdata" style="color: red;" data-group_recordid = "<?php echo $g_data['group_id']; ?>" data-recordid = "<?php echo $data['id']; ?>" data-gdata_id = "<?php echo $data['data_id']; ?>" data-group_table = "<?php echo (isset($group_table)) ? $group_table : ""; ?>"><i class="fa fa-trash" style="font-size:18px;"></i> Delete</a>
																						</td>
																					<?php } ?>
																				</tr>
																			<?php }
																		}
																	}else{ ?>
																		<tr>
																			<td colspan="<?php echo count($group['group_fields'])+2; ?>">No data found</td>
																		</tr>
																	<?php } ?>
																</tbody>
															</table>
														</div>
													<?php }
												} ?>
											</div>

											<?php if($data['nothingto_report'] == 1){ ?>
												<div class="col-md-12">
													<p class="text-danger" style="font-weight:bold;">"User has selected Nothing to Report"</p>
												</div>
											<?php } ?>
											
											<div class="col-md-12"></div>
											<div class="col-md-12 usersindicator_list mt-20"></div>

										<?php if('0'){ ?>	<div class="col-md-12">
												<?php if($data['status'] == 3){ ?>
													<span class="text-success pull-right"><b>Data approved</b></span>
												<?php } ?>
											</div> <?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php }
				}else{ ?>
					<div class="card">
						<div class="card-body">
							<h4 class="title">No data found</h4>
						</div>
					</div>
				<?php } ?>
			</div>						
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>include/app-assets/vendors/js/extensions/sweetalert.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('body')
		.on('click', '.addmorefields', function(){
			$('.error').html('');
			$elem = $(this);
			$elem.closest('.addmoremaindiv').find('.removeaddmore').parent().html('');

			var addmore_count = $elem.closest('.addmoremaindiv').find('.addmore').length;
			var $template = $elem.closest('.addmoremaindiv').find('.addmore_div'),
			$clone = $template
                    .clone()
                    .removeClass('addmore_div')
                    .addClass('dulicate_addmore_div')
                    .attr('style', 'border-top:1px solid #8e8ec0; margin:0px;');

            $clone.find('input[type="text"]').val('');
            $clone.find('textarea').val('');
            $clone.find('select').val('');
            $clone.find('input[type="radio"]').prop("checked", false);
            $clone.find('input[type="checkbox"]').prop("checked", false);
            $clone.find('input[type="radio"]').prop("checked", false);

            $clone.find('.childfields').html('');
            

            $clone.find('input[type="text"]').each(function() {
            	var name = $(this).attr("name");
            	name = name.replace("[0]", "["+addmore_count+"]");
            	$(this).attr('name', name);
            	$(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('textarea').each(function() {
            	var name = $(this).attr("name");
            	name = name.replace("[0]", "["+addmore_count+"]");
            	$(this).attr('name', name);
            	$(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('input[type="radio"]').each(function() {
            	var name = $(this).attr("name");
            	name = name.replace("[0]", "["+addmore_count+"]");
            	$(this).attr('name', name);
            	$(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('input[type="checkbox"]').each(function() {
            	var name = $(this).attr("name");
            	name = name.replace("[0]", "["+addmore_count+"]");
            	$(this).attr('name', name);
            	$(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('select').each(function() {
            	var name = $(this).attr("name");
            	name = name.replace("[0]", "["+addmore_count+"]");
            	$(this).attr('name', name);
            	$(this).attr('data-groupfieldcount', addmore_count);
            });
            
            $clone.find('.addmorefields').parent().html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:10px;">\
            	<span class="glyphicon glyphicon-minus"></span> Remove\
            </button>');
            $(this).closest('.addmoremaindiv').append($clone);

            //Date picker
		    $('.picker').datepicker({
		       format: 'yyyy-mm-dd',
		       autoclose: true
		    });

		    //month picker
			$('.monthpicker').datepicker({
				format: 'yyyy-mm',
				autoclose: true,
				viewMode: "months", 
				minViewMode: "months"
			});
		})
		.on('click', '.removeaddmore', function() {
			var elem = $(this);

	        var addmore_count = elem.closest('.addmoremaindiv').find('.addmore').length;
	        var fields = elem.closest('.addmoremaindiv').find('.addmore');
	        $.each(fields, function(index) {
				if(index == (addmore_count-2) && index != 0){
					$(this).find('.add_remove_button').html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:10px;">\
		            	<span class="glyphicon glyphicon-minus"></span> Remove\
		            </button>');
				}
			});
			elem.closest('.row').remove();
	    });

		$('body').on('click', '.getfields_tosubmit_savedata', function(){
			$elem = $(this);
            $elem.prop('disabled', true);
            $elem.closest('.row').find('.usersindicator_list').html('');

            var loading = '<div class="col-md-12 text-center">\
				<img class="loading" src="<?php echo base_url(); ?>include/app-assets/images/loading.gif" style="height: 70px;">\
				<p>Please wait...</p>\
	        </div>';

	        $elem.closest('.row').find('.usersindicator_list').html(loading);

	        $('html,body').animate({
	          	scrollTop: $elem.closest('.row').find('.usersindicator_list').offset().top - 300
	        }, 500);

			var recordid = $elem.data("recordid");
			var tablename = $elem.data("tablename");
			var group_table = $elem.data("group_table");
			var formtype = $elem.data("formtype");
			var urole = $elem.data("urole");

			$.ajax({
                url: '<?php echo base_url(); ?>dashboard/edit_andapprovedata',
                type: 'POST',
                dataType : 'json',
                data :{
                	recordid : recordid,
                	form_id : <?php echo $this->uri->segment(6); ?>
                },
                error: function() {
                	$.toast({
                        heading: 'Warning!',
                        text: 'Please check your internet connection and try again.',
                        icon: 'error',
                        afterHidden: function () {
                            $elem.prop('disabled', false);
                        }
                    });
                },
                success: function(response){
                	//console.log(response);
                    if(response.status == 0){
                    	$.toast({
                            heading: 'Warning!',
                            text: response.msg,
                            icon: 'warning',
                            afterHidden: function () {
                                $elem.prop('disabled', false);
                            }
                        });
                    }else{
                    	var form_fields = '<form id="submit_data">';
                    		form_fields += '<div class="row">';
                    			var i = 1;
                    			if(response.get_tabledata != null){
	                				var json_formdata = jQuery.parseJSON(response.get_tabledata.form_data);
	                			}else{
	                				var json_formdata = [];
	                			}
								response.indicator_fields.forEach(function(indicatorfield, ifindex){
									if(indicatorfield.parent_id == null){
										switch(indicatorfield.type){
											case 'group':
												response.get_grouptabledata.forEach(function(groupdata, groupdata_index){
													var jsondata = jQuery.parseJSON(groupdata.formgroup_data);
													//console.log(jsondata);
													if(groupdata.groupfield_id == indicatorfield.field_id){
														form_fields += '<div class="col-md-12">\
															<input type="text" class="form-control hidden" name="id['+groupdata_index+']" value="'+groupdata.group_id+'">\
														</div>';
														form_fields += '<div class="col-md-12 addmoremaindiv">\
															<div class="row addmore addmore_div">';
																var indicator_groupfieldscount = indicatorfield.groupfields.length;
																var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
													        	form_fields += '<div class="col-md-'+i_divmainclass+'">\
													        		<div class="row">';
													        			indicatorfield.groupfields.forEach(function(indicatorgroupfield, ig_index){
													        				if(indicator_groupfieldscount == 1){
													        					var i_divclass = 12
													        				}else if(indicator_groupfieldscount == 2){
													        					var i_divclass = 6;
													        				}else if(indicator_groupfieldscount == 3){
													        					var i_divclass = 4;
													        				}else{
													        					var i_divclass = 3;
													        				}
													        				var group_fieldname = "field_"+indicatorgroupfield.field_id+"";
													        				//console.log(indicatorgroupfield)
													        				switch(indicatorgroupfield.type){
													        					case 'text':
													        						form_fields += '<div class="col-md-'+i_divclass+'">\
															        					<div class="form-group">';
																        					form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" >\
															                            	<p class="error red-800"></p>\
															                            	<p class="maxlengtherror red-800"></p>\
															        					</div>\
															        				</div>';
													        						break;

													        					case 'textarea':
																                    form_fields += '<div class="col-md-'+i_divclass+'">\
																						<div class="form-group">';
																							form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																				    		form_fields += '<textarea name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" rows="8" class="'+indicatorgroupfield.className+'" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'">'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'</textarea>\
																				    		<p class="error red-800"></p>\
																				    		<p class="maxlengtherror red-800"></p>\
																						</div>\
																                    </div>';
												        							break;

													        					case 'select':
															                    	form_fields += '<div class="col-md-'+i_divclass+'">\
																						<div class="form-group">';
																							form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
																				  				var selectname = "field_"+indicatorgroupfield.field_id+"["+groupdata_index+"][]";
																				  				var selectmultiple = "multiple";
																				  			}else{
																				  				var selectname = "field_"+indicatorgroupfield.field_id+"["+groupdata_index+"]";
																				  				var selectmultiple = "";
																				  			} 
																				  			form_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'"  data-fieldtype="groupfield" data-groupfieldcount = "'+groupdata_index+'">';
																				   			if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
																				      		}else{
																				        		form_fields += '<option value="">Select an option</option>';
																				        	}
																				        	indicatorgroupfield.options.forEach(function(option, index){
																				        		if(option.value == jsondata[group_fieldname]){ 
															                          				var select_value = "selected"; 
															                          			}else{
															                          				var select_value = '';
															                          			}
															                          			form_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
																				        	});
																			    			form_fields += '</select>\
																			    			<p class="error red-800"></p>\
																						</div>\
																						<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
															                    	</div>';
												        							break;

												        						case 'radio-group':
																                    form_fields += '<div class="col-md-'+i_divclass+'">\
																						<div class="form-group">';
																							form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							form_fields += '<div class="form-check">\
																						    	<div class="row">';
																						    		indicatorgroupfield.options.forEach(function(option, index){
																						    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
																						    			if(option.value == jsondata[group_fieldname]){
																                                			var radio_value = "checked";
																                                		}else{
																                                			var radio_value = '';
																                                		}
																						    			form_fields += '<div class="col-md-4">\
																						          			<label><input type="radio" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' >'+option.label+'</label>\
																						        		</div>';
																						    		});
																						    	form_fields += '</div>\
																						  	</div>\
																							<p class="error red-800"></p>\
																						</div>\
																						<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
																                    </div>';
												        							break;

												        						case 'checkbox-group':
																                    form_fields += '<div class="col-md-'+i_divclass+'">\
																						<div class="form-group">';
																							form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							form_fields += '<div class="form-check">\
																						    	<div class="row">';
																						    		indicatorgroupfield.options.forEach(function(option, index){
																						    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";

																						    			var checkbox_val = (jsondata[group_fieldname] == null ? '' : jsondata[group_fieldname].split("&#44;"));
													        			
													        											if(jQuery.inArray(option.value, checkbox_val) !== -1){
																                                			var radio_value = "checked"; 
																                                		}else{
																                                			var radio_value = '';
																                                		}
																						    			form_fields += '<div class="col-md-6">\
																						          			<label><input type="checkbox" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+'][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' >'+option.label+'</label>\
																						        		</div>';
																						    		});
																						    	form_fields += '</div>\
																						  	</div>\
																							<p class="error red-800"></p>\
																						</div>\
																						<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
																                    </div>';
												        							break;

												        						case 'number':
												        							form_fields += '<div class="col-md-'+i_divclass+'">\
															                        	<div class="form-group">';
															                          		form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
													                             			switch (indicatorgroupfield.subtype) {
																                                case 'desimal':
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' decimal" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
																                                	break;

																                                case 'number':
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' number" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
																                                	break;

																                                case 'latitude':
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
																                                  	break;

																                                case 'longitude':
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
																                                  	break;

																                                case 'percentage':
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' percentage" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'">';
																                                  	break;
																                                
																                                default:
																                                	form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' numberfield" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
																                                  	break;
													                              			}
													                              			form_fields += '<p class="error red-800"></p>\
													                              			<p class="maxlengtherror red-800"></p>\
															                        	</div>\
															                        	<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
															                      	</div>';
												        							break;

												        						case 'date':
											        								form_fields += '<div class="col-md-'+i_divclass+'">\
																                      	<div class="form-group">';
																	                        form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' picker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
															                            	<p class="error red-800"></p>\
															                            	<p class="maxlengtherror red-800"></p>\
																                      	</div>\
																                    </div>';
											        								break;

											        							case 'month':
											        								form_fields += '<div class="col-md-'+i_divclass+'">\
																                      	<div class="form-group">';
																	                        form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																							if(indicatorgroupfield.description != null){
																								form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																							}
																							form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' monthpicker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
															                            	<p class="error red-800"></p>\
															                            	<p class="maxlengtherror red-800"></p>\
																                      	</div>\
																                    </div>';
											        								break;

													        				}		
													        			});
													        		form_fields += '</div>\
													        	</div>';
													        	form_fields += '<div class="col-md-12">\
													        		<hr style="margin-top: 0px; height: 1px; background-color: #8e8ec0;">\
													        	</div>\
													        </div>\
														</div>';
													}
												});
			        							break;

			        						//display of text box field
			        						case 'text':
		        								form_fields += '<div class="col-md-4">\
							                      	<div class="form-group">';
								                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
								                        if(indicatorfield.field_count == 1){
										            		var label = textquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
										            	form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														var text_fieldname = "field_"+indicatorfield.field_id+"";
														form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" data-subtype="'+indicatorfield.subtype+'" value="'+(json_formdata[text_fieldname] != null ? json_formdata[text_fieldname] : "")+'">\
						                            	<p class="error red-800"></p>\
						                            	<p class="maxlengtherror red-800"></p>\
							                      	</div>\
							                    </div>';
		        								break;

		        							case 'date':
		        								form_fields += '<div class="col-md-4">\
							                      	<div class="form-group">';
								                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
								                        if(indicatorfield.field_count == 1){
										            		var label = datequestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
										            	form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														var date_fieldname = "field_"+indicatorfield.field_id+"";
														form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' picker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="'+(json_formdata[date_fieldname] != null ? json_formdata[date_fieldname] : "")+'" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
						                            	<p class="error red-800"></p>\
						                            	<p class="maxlengtherror red-800"></p>\
							                      	</div>\
							                    </div>';
		        								break;

		        							case 'month':
		        								form_fields += '<div class="col-md-4	">\
							                      	<div class="form-group">';
								                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
								                        if(indicatorfield.field_count == 1){
										            		var label = datequestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
										            	form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														var month_fieldname = "field_"+indicatorfield.field_id+"";
														form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' monthpicker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="'+(json_formdata[month_fieldname] != null ? json_formdata[month_fieldname] : "")+'" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
						                            	<p class="error red-800"></p>\
						                            	<p class="maxlengtherror red-800"></p>\
							                      	</div>\
							                    </div>';
		        								break;

		        							//display number field
			        						case 'number':
			        							form_fields += '<div class="col-md-4">\
						                        	<div class="form-group">';
						                          		var numberquestion = (indicatorfield.field_count == 1) ? i++ : i;
														if(indicatorfield.field_count == 1){
										            		var label = numberquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
														form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														var number_fieldname = "field_"+indicatorfield.field_id+"";
				                             			switch (indicatorfield.subtype) {
							                                case 'desimal':
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' decimal" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'"  data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
							                                	break;

							                                case 'number':
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' number" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
							                                	break;

							                                case 'latitude':
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
							                                  	break;

							                                case 'longitude':
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
							                                  	break;

							                                case 'percentage':
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' percentage" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" data-field_id = "'+indicatorfield.field_id+'">';
							                                  	break;
							                                
							                                default:
							                                	form_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' numberfield" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
							                                  	break;
				                              			}
				                              			form_fields += '<p class="error red-800"></p>\
				                              			<p class="maxlengtherror red-800"></p>\
						                        	</div>\
						                      	</div>\
						                      	<div class="col-md-12">\
							                    	<div class="row childfields childof'+indicatorfield.field_id+'">\
							                    	</div>\
							                    </div>';
			        							break;

			        						//display radio button
			        						case 'radio-group':
			        							var radio_fieldname = "field_"+indicatorfield.field_id+"";
							                    form_fields += '<div class="col-md-12">\
													<div class="form-group">';
														var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
														if(indicatorfield.field_count == 1){
										            		var label = radioquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
										            	if(indicatorfield.required == 1){
										            		var hastrick = "<font color='red'>*</font>";
										            	}else{
										            		var hastrick = "";
										            	}
														form_fields += '<label class="english">'+label+''+hastrick+'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														form_fields += '<div class="form-check">\
													    	<div class="row">';
													    		indicatorfield.options.forEach(function(option, index){
													    			var requiredval = (indicatorfield.required == 1) ? "required" : "";
													    			if((option.value == json_formdata[radio_fieldname]) && (json_formdata[radio_fieldname] != null)){ 
							                                			var radio_value = "checked"; 
							                                		}else{
							                                			var radio_value = '';
							                                		}
													    			form_fields += '<div class="col-md-4">\
													          			<label><input type="radio" name="field_'+indicatorfield.field_id+'" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' >'+option.label+'</label>\
													        		</div>';

													    		});
													
																/***********___radio____
													        	response.get_grouptabledata.forEach(function(groupdata, groupdata_index){
																	var jsondata = jQuery.parseJSON(groupdata.formgroup_data);
																	if(groupdata.groupfield_id == indicatorfield.field_id){
																		form_fields += '<div class="col-md-12">\
																			<input type="text" class="form-control hidden" name="id['+groupdata_index+']" value="'+groupdata.group_id+'">\
																		</div>';
																		form_fields += '<div class="col-md-12 addmoremaindiv">\
																			<div class="row addmore addmore_div">';
																				var indicator_groupfieldscount = indicatorfield.groupfields.length;
																				var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
																	        	form_fields += '<div class="col-md-'+i_divmainclass+'">\
																	        		<div class="row">';
																	        			indicatorfield.groupfields.forEach(function(indicatorgroupfield, ig_index){
																	        				if(indicator_groupfieldscount == 1){
																	        					var i_divclass = 12
																	        				}else if(indicator_groupfieldscount == 2){
																	        					var i_divclass = 6;
																	        				}else if(indicator_groupfieldscount == 3){
																	        					var i_divclass = 4;
																	        				}else{
																	        					var i_divclass = 3;
																	        				}
																	        				var group_fieldname = "field_"+indicatorgroupfield.field_id+"";
																	        				console.log(indicatorgroupfield.type);
																	        				switch(indicatorgroupfield.type){
																	        					case 'text':
																	        						form_fields += '<div class="col-md-'+i_divclass+'">\
																			        					<div class="form-group">';
																				        					form_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																											if(indicatorgroupfield.description != null){
																												form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																											}
																											form_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" >\
																			                            	<p class="error red-800"></p>\
																			                            	<p class="maxlengtherror red-800"></p>\
																			        					</div>\
																			        				</div>';
																	        						break;
																	        				}
													        							});
									        			 			}
									        			 		});
																/*------------------------*/

													    	form_fields += '</div>\
													  	</div>\
														<p class="error red-800"></p>\
													</div>\
							                    </div>\
							                    <div class="col-md-12">\
							                    	<div class="row childfields childof'+indicatorfield.field_id+'">\
							                    	</div>\
							                    </div>';
			        							break;

			        						//display radio button
			        						case 'checkbox-group':
			        							var radio_fieldname = "field_"+indicatorfield.field_id+"";
							                    form_fields += '<div class="col-md-12">\
													<div class="form-group">';
														var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
														if(indicatorfield.field_count == 1){
										            		var label = radioquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
										            	if(indicatorfield.required == 1){
										            		var hastrick = "<font color='red'>*</font>";
										            	}else{
										            		var hastrick = "";
										            	}
														form_fields += '<label class="english">'+label+''+hastrick+'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														form_fields += '<div class="form-check">\
													    	<div class="row">';
													    		indicatorfield.options.forEach(function(option, index){
													    			var requiredval = (indicatorfield.required == 1) ? "required" : "";
							                                		if(json_formdata[radio_fieldname] != null){
													        			var checkbox_val = json_formdata[radio_fieldname].split("&#44;");
													        			
													        			if(jQuery.inArray(option.value, checkbox_val) !== -1){
													        				var radio_value = 'checked';
													        			}else{
													        				var radio_value = '';
													        			}
													        		}else{
													        			var radio_value = '';
													        		}
													    			form_fields += '<div class="col-md-4">\
													          			<label><input type="checkbox" name="field_'+indicatorfield.field_id+'[]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'" '+radio_value+' >'+option.label+'</label>\
													        		</div>';
													    		});
													    	form_fields += '</div>\
													  	</div>\
														<p class="error red-800"></p>\
													</div>\
							                    </div>\
							                    <div class="col-md-12">\
							                    	<div class="row childfields childof'+indicatorfield.field_id+'">\
							                    	</div>\
							                    </div>';
			        							break;

			        						//display of textarea
			        						case 'textarea':
			        							var textarea_fieldname = "field_"+indicatorfield.field_id+"";
							                    form_fields += '<div class="col-md-4">\
													<div class="form-group">';
														var textareaquestion = (indicatorfield.field_count == 1) ? i++ : i;
														if(indicatorfield.field_count == 1){
										            		var label = textareaquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
														form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
											    		form_fields += '<textarea name="field_'+indicatorfield.field_id+'" rows="8" class="'+indicatorfield.className+'" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'">'+(json_formdata[textarea_fieldname] != null ? json_formdata[textarea_fieldname] : "")+'</textarea>\
											    		<p class="error red-800"></p>\
											    		<p class="maxlengtherror red-800"></p>\
													</div>\
							                    </div>';
			        							break;

			        						//display of select box
			        						case 'select':
			        							var select_fieldname = "field_"+indicatorfield.field_id+"";
							                    form_fields += '<div class="col-md-4">\
													<div class="form-group">';
														var selectquestion = (indicatorfield.field_count == 1) ? i++ : i;
														if(indicatorfield.field_count == 1){
										            		var label = selectquestion+'. '+indicatorfield.label;
										            	}else{
										            		var label = indicatorfield.label;
										            	}
														form_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
														if(indicatorfield.description != null){
															form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
														}
														if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
											  				var selectname = "field_"+indicatorfield.field_id+"[]";
											  				var selectmultiple = "multiple";
											  			}else{
											  				var selectname = "field_"+indicatorfield.field_id+"";
											  				var selectmultiple = "";
											  			}
											  			form_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorfield.field_id+'" data-fieldtype="normalfield">';
											   			if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
											      		}else{
											        		form_fields += '<option value="">Select an option</option>';
											        	}
											        	indicatorfield.options.forEach(function(option, index){
											        		if(json_formdata[select_fieldname] != null){
											        			var selectbox_val = json_formdata[select_fieldname].split("&#44;");
											        			
											        			if(jQuery.inArray(option.value, selectbox_val) !== -1){
											        				var select_value = 'selected';
											        			}else{
											        				var select_value = '';
											        			}
											        		}else{
											        			var select_value = '';
											        		}
						                          			form_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
											        	});
											    		form_fields += '</select>\
											    		<p class="error red-800"></p>\
													</div>\
							                    </div>\
							                    <div class="col-md-12">\
							                    	<div class="row childfields childof'+indicatorfield.field_id+'"></div>\
							                    </div>';
			        							break;

			        						case 'header':
							                    form_fields += '<div class="col-md-12">';
							                    	if(indicatorfield.description != null){
							                    		form_fields += indicatorfield.description;
							                    	}
							                    	form_fields += '<'+indicatorfield.subtype+' class="title" style="margin-top: 0px; margin-bottom: 20px;">'+indicatorfield.label+'</'+indicatorfield.subtype+'>';
							                    form_fields += '</div>';
							                	break;

										}
									}
								});
								form_fields += '<div class="col-md-6">\
			                      	<div class="form-group">';
						            	form_fields += '<label class="english">Comment</label>';
										form_fields += '<input type="text" name="indicator_comment" class="form-control" data-required="" data-maxlength = "1000" data-subtype="text" value="'+(response.get_tabledata.comment != null ? response.get_tabledata.comment : "")+'">\
		                            	<p class="error red-800"></p>\
		                            	<p class="maxlengtherror red-800"></p>\
			                      	</div>\
			                    </div>';					
								/*if(urole==3){
									form_fields += '<div class="col-md-12">\
										<button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" style="margin-top: 50px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Submit data</button>\
										<button type="button" class="btn btn-sm btn-success pull-right save_data" style="margin-top: 50px;margin-right: 5px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Save data</button>\
										<button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-top: 50px; margin-right:10px;">Cancel</button>\
									</div>';
								}else {
									form_fields += '<div class="col-md-12">\
										<button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" style="margin-top: 50px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Submit data</button>\
										<button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-top: 50px; margin-right:10px;">Cancel</button>\
									</div>';
								}*/
								if(response.get_tabledata.status==1){
									form_fields += '<div class="col-md-12">\
										<button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" style="margin-top: 50px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Submit data</button>\
										<button type="button" class="btn btn-sm btn-success pull-right save_data" style="margin-top: 50px;margin-right: 5px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Save data</button>\
										<button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-top: 50px; margin-right:10px;">Cancel</button>\
									</div>';
								}else {
									form_fields += '<div class="col-md-12">\
										<button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" style="margin-top: 50px;" data-formtype = "'+formtype+'" data-recordid = "'+recordid+'">Submit data</button>\
										<button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-top: 50px; margin-right:10px;">Cancel</button>\
									</div>';
								}
							form_fields += '</div>\
						</form>';

						$elem.closest('.row').find('.usersindicator_list').html(form_fields);

						//Date picker
					    $('.picker').datepicker({
					       format: 'yyyy-mm-dd',
					       autoclose: true
					    });

					    //month picker
						$('.monthpicker').datepicker({
							format: 'yyyy-mm',
							autoclose: true,
							viewMode: "months", 
							minViewMode: "months"
						});
                    }

                    $elem.prop('disabled', false);
                }
            });
		});

		$('body').on('click', '.cancel', function(){
			$elem = $(this);

			$elem.closest('.usersindicator_list').html('');
		});

		$('body').on('click', '.save_data', function(){
			$elem = $(this);
            $elem.prop('disabled', true);

            $('.error').html('');

            var recordid = $elem.data("recordid");
			var formtype = $elem.data("formtype");
            var form_id = $elem.closest("form").attr('id');

            var surveycount = 0;

            $elem.closest('.card').find('input[type=text]', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if(requiredvalue == 'required'){
                    if($.trim($(this).val()).length === 0){
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if(subtypevalue == 'number' || subtypevalue == 'desimal'){
                    switch (subtypevalue){
                        case 'number':
                            if($(this).val().length > 0){
                                if (/^\d+$/.test($(this).val())) {
                                    $(this).next('.error').empty();
                                } else {
                                    $(this).val('');
                                    $(this).next('.error').html('Please provide a valid number.');
                                    surveycount++;
                                }
                            }
                        break;

                        case 'desimal':
                            if($(this).val().length > 0){
                                if(!/^(\d*\.?\d*)$/.test($(this).val())){
                                    $(this).next('.error').html('Please! Enter only number');
                                    surveycount++;
                                }else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                    $(this).next('.error').html('Field can contain only proper decimal number.');
                                    surveycount++;
                                }
                            }
                        break;
                    }
                }

                if($.trim($(this).val()).length > maxvalue){
          			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
          			surveycount++;
        		}
            });

            $elem.closest('.card').find('textarea', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if(requiredvalue == 'required'){
                    if($.trim($(this).val()).length === 0){
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if($.trim($(this).val()).length > maxvalue){
          			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
          			surveycount++;
        		}
            });

            $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
		        var requiredvalue = $(this).data("required");
		        var subtypevalue = $(this).data("subtype");
		        if(requiredvalue == 'required'){
		          	var name = $(this).attr("name");
		          	if($("input:radio[name='"+name+"']:checked").length == 0){
		            	$(this).closest('.form-group').find('.error').html('This field is required');
		            	surveycount++;
		          	}
		        }
		   	});

		   	$elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
				var requiredvalue = $(this).data("required");
				var subtypevalue = $(this).data("subtype");
				var maxvalue = $(this).data("maxlength");

				if(requiredvalue == 'required'){
					var name = $(this).attr("name");
					if($("input:checkbox[name='"+name+"']:checked").length == 0){
	                  	$(this).closest('.form-group').find('.error').html('This field is required');
	                  	surveycount++;
	                }
				}
			});

		   	$elem.closest('.card').find('select', form_id).each(function() {
        		var requiredvalue = $(this).data("required");
        		var subtypevalue = $(this).data("subtype");
        		if(requiredvalue == 'required'){
        			var name = $(this).attr("name");
          			if($.trim($(this).val()).length == 0){
            			$(this).next('.error').html('This field is required');
            			surveycount++;
          			}
        		}
      		});

            if(surveycount == 0){
            	var indicatorform = new FormData($('#'+form_id)[0]);
                indicatorform.append('recordid', recordid);
                indicatorform.append('formtype', formtype);
                indicatorform.append('form_id', <?php echo $this->uri->segment(6); ?>);
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard/update_formdata',
                    type: 'POST',
                    dataType : 'json',
                    data: indicatorform,
                    processData: false,
                    contentType: false,
                    error: function() {
                    	$.toast({
	                        heading: 'Warning!',
	                        text: 'Please check your internet connection and try again.',
	                        icon: 'error',
	                        afterHidden: function () {
	                            $elem.prop('disabled', false);
	                        }
	                    });
                    },
                    success: function(response){
                        if(response.status == 0){
                        	$.toast({
	                            heading: 'Warning!',
	                            text: response.msg,
	                            icon: 'warning',
	                            afterHidden: function () {
	                                $elem.prop('disabled', false);
	                            }
	                        });
                        }else{
                        	$elem.closest('.row').html('');

                        	$.toast({
	                            heading: 'Success!',
	                            text: response.msg,
	                            icon: 'success',
	                            afterHidden: function () {
	                                location.reload(true);
	                            }
	                        });
                        }
                    }
                });
            }else{
            	$elem.prop('disabled', false);
            }
		});

    $('body').on('keyup', '.numberfield', function(){
        $(this).closest('.form-group').find('.error').html('');
        if($(this).val().length > 0){
            if (!/^(\+|-)?(\d*\.?\d*)$/.test(this.value)) { // a non–digit was entered
                $(this).closest('.form-group').find('.error').html('This field contains only numbers and perfect decimals.');
            }else{
                $(this).closest('.form-group').find('.error').empty();
            }
        }
    });

		$('body').on('click', '.submitindicator_data', function(){
			$elem = $(this);
            $elem.prop('disabled', true);

            $('.error').html('');

            var recordid = $elem.data("recordid");
			var formtype = $elem.data("formtype");
            var form_id = $elem.closest("form").attr('id');

            var surveycount = 0;

            $elem.closest('.card').find('input[type=text]', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if(requiredvalue == 'required'){
                    if($.trim($(this).val()).length === 0){
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if(subtypevalue == 'number' || subtypevalue == 'desimal'){
                    switch (subtypevalue){
                        case 'number':
                            if($(this).val().length > 0){
                                if (/^\d+$/.test($(this).val())) {
                                    $(this).next('.error').empty();
                                } else {
                                    $(this).val('');
                                    $(this).next('.error').html('Please provide a valid number.');
                                    surveycount++;
                                }
                            }
                        break;

                        case 'desimal':
                            if($(this).val().length > 0){
                                if(!/^(\d*\.?\d*)$/.test($(this).val())){
                                    $(this).next('.error').html('Please! Enter only number');
                                    surveycount++;
                                }else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                    $(this).next('.error').html('Field can contain only proper decimal number.');
                                    surveycount++;
                                }
                            }
                        break;
                    }
                }

                if($.trim($(this).val()).length > maxvalue){
          			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
          			surveycount++;
        		}
            });

            $elem.closest('.card').find('textarea', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if(requiredvalue == 'required'){
                    if($.trim($(this).val()).length === 0){
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if($.trim($(this).val()).length > maxvalue){
          			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
          			surveycount++;
        		}
            });

            $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
		        var requiredvalue = $(this).data("required");
		        var subtypevalue = $(this).data("subtype");
		        if(requiredvalue == 'required'){
		          	var name = $(this).attr("name");
		          	if($("input:radio[name='"+name+"']:checked").length == 0){
		            	$(this).closest('.form-group').find('.error').html('This field is required');
		            	surveycount++;
		          	}
		        }
		   	});

		   	$elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
				var requiredvalue = $(this).data("required");
				var subtypevalue = $(this).data("subtype");
				var maxvalue = $(this).data("maxlength");

				if(requiredvalue == 'required'){
					var name = $(this).attr("name");
					if($("input:checkbox[name='"+name+"']:checked").length == 0){
	                  	$(this).closest('.form-group').find('.error').html('This field is required');
	                  	surveycount++;
	                }
				}
			});

		   	$elem.closest('.card').find('select', form_id).each(function() {
        		var requiredvalue = $(this).data("required");
        		var subtypevalue = $(this).data("subtype");
        		if(requiredvalue == 'required'){
        			var name = $(this).attr("name");
          			if($.trim($(this).val()).length == 0){
            			$(this).next('.error').html('This field is required');
            			surveycount++;
          			}
        		}
      		});

            if(surveycount == 0){
            	var indicatorform = new FormData($('#'+form_id)[0]);
                indicatorform.append('recordid', recordid);
                indicatorform.append('formtype', formtype);
                indicatorform.append('form_id', <?php echo $this->uri->segment(6); ?>);
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard/edit_formdata',
                    type: 'POST',
                    dataType : 'json',
                    data: indicatorform,
                    processData: false,
                    contentType: false,
                    error: function() {
                    	$.toast({
	                        heading: 'Warning!',
	                        text: 'Please check your internet connection and try again.',
	                        icon: 'error',
	                        afterHidden: function () {
	                            $elem.prop('disabled', false);
	                        }
	                    });
                    },
                    success: function(response){
                        if(response.status == 0){
                        	$.toast({
	                            heading: 'Warning!',
	                            text: response.msg,
	                            icon: 'warning',
	                            afterHidden: function () {
	                                $elem.prop('disabled', false);
	                            }
	                        });
                        }else{
                        	$elem.closest('.row').html('');

                        	$.toast({
	                            heading: 'Success!',
	                            text: response.msg,
	                            icon: 'success',
	                            afterHidden: function () {
	                                location.reload(true);
	                            }
	                        });
                        }
                    }
                });
            }else{
            	$elem.prop('disabled', false);
            }
		});

		$('body').on('click', '.delete_groupdata', function(){
			$elem = $(this);
			var recordid = $elem.data("recordid");
			var group_recordid = $elem.data("group_recordid");
			var group_table = $elem.data("group_table");
			var gdata_id = $elem.data("gdata_id");

			swal({
				title: "Are you sure?",
				text: "Please enter the reason for deleting of this record!",
				type: "input",
				showCancelButton: true,
				closeOnConfirm: false,
				inputPlaceholder: "Reason"
			}, function (inputValue) {
				if (inputValue === false) return false;
				if (inputValue === "") {
					swal.showInputError("You need to write something!");
					return false
				}

				$.ajax({
					url: "<?php echo base_url(); ?>dashboard/delete_groupdata",
					type: "POST",
					dataType: "json",
					data : {
						recordid : recordid,
	        			group_recordid : group_recordid,
	        			gdata_id : gdata_id,
	        			group_table : group_table,
	        			reason : inputValue
					},
					error : function(){
						swal({
	                        title: 'Some thing went wrong please try after sometime.',
	                        icon: "warning",
	                        dangerMode : true,
	                        closeOnConfirm: true
	                    });
					},
					success : function(response){
						if(response.status == 0){
							swal({
	                            title: response.msg,
	                            icon: "warning",
	                            dangerMode : true,
	                            closeOnConfirm: true
	                        });
	
						}else{
							$elem.closest('tr').remove('');

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
	                        if(response.reload == 1){
	                        location.reload(true);
	                    }
						}
					}
				});
			});
		});

		$('body').on('click', '.delete_data', function(){
			$elem = $(this);

			var recordid = $elem.data('recordid');

			swal({
				title: "Are you sure?",
				text: "Please enter the reason for deleting of this record!",
				type: "input",
				showCancelButton: true,
				closeOnConfirm: false,
				inputPlaceholder: "Reason"
			}, function (inputValue) {
				if (inputValue === false) return false;
				if (inputValue === "") {
					swal.showInputError("You need to write something!");
					return false
				}
				$.ajax({
					url: "<?php echo base_url(); ?>dashboard/delete_data",
					type: "POST",
					dataType: "json",
					data : {
						recordid : recordid,
					   	reason : inputValue
					},
					error : function(){
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
					success : function(response){
						if(response.status == 0){
							$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800" style="font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "warning",
	                            dangerMode : true,
	                            closeOnConfirm: true
	                        });
						
						}else{
							$elem.closest('.card').html('');
							/*$elem.closest('.row').find('.delete_groupdata').html('');
							$elem.closest('.actionbutton_divs').html('');	*/					

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
						}
					}
				});
			});	
		});

		$('body').on('click', '.close_modal', function(){
			$('#myModal').modal('hide');
		});

		$('body').on('keyup', '.numberfield', function(){
     		$(this).closest('.form-group').find('.error').html('');
      		if($(this).val().length > 0){
        		if (!/^(\+|-)?(\d*\.?\d*)$/.test(this.value)) { // a non–digit was entered
          			$(this).closest('.form-group').find('.error').html('This field contains only numbers and perfect decimals.');
        		}else{
          			$(this).closest('.form-group').find('.error').empty();
        		}
      		}
    	});

    	$('body').on('keyup', '.decimal', function(){
      		$(this).closest('.form-group').find('.error').html('');

      		var maxvalue = $(this).attr("data-maxvalue");
      		if($(this).val().length > 0){
        		if(!/^(\d*\.?\d*)$/.test($(this).val())){
          			$(this).closest('.form-group').find('.error').html('Please! Enter only number');
        		}else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
          			$(this).closest('.form-group').find('.error').html('Field can contain only proper decimal number.');
        		}

        		if(parseFloat($(this).val()) >  parseFloat(maxvalue)){
        			$(this).closest('.form-group').find('.error').html('Enter value cannot be greater than '+maxvalue+'');
        			$(this).val('');
        		}
      		}
    	});

    	$('body').on('keyup', '.number', function(){
      		$(this).closest('.form-group').find('.error').html('');

      		var maxvalue = $(this).attr("data-maxvalue");
      		if($(this).val().length > 0){
        		if (/^\d+$/.test($(this).val())) {
          			$(this).closest('.form-group').find('.error').empty();
        		} else {
          			$(this).closest('.form-group').find('.error').html('Please provide a valid number.');
        		}

        		if(parseInt($(this).val()) >  parseInt(maxvalue)){
        			$(this).closest('.form-group').find('.error').html('Enter value cannot be greater than '+maxvalue+'');
        			$(this).val('');
        		}
      		}
    	});

    	$('body').on('keyup', '.latlong', function(){
      		$(this).closest('.form-group').find('.error').html('');
      		if($(this).val().length > 0){
       			if (/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/.test($(this).val())) {
          			$(this).closest('.form-group').find('.error').empty();
        		} else {
          			$(this).closest('.form-group').find('.error').html('Please provide a proper value.');
        		}
      		}
    	});

    	$('body').on('change', 'input[type=radio]', function() {
			$elem = $(this);

	        var field_id = $(this).attr("data-field_id");
	        var field_value = $(this).attr("data-field_value");
	        var fieldtype = $(this).attr("data-fieldtype");
	        if(fieldtype == 'groupfield'){
	        	var groupfieldcount = $(this).attr("data-groupfieldcount");
	        }else{
	        	var groupfieldcount = "";
	        }

	        var classname = 'childof'+field_id;
	        if(fieldtype == 'groupfield'){
	        	$elem.closest('.row').find('.'+classname).html('');
	        }else{
	        	$('.'+classname).html('');
	        }

	        var calltype = 'onchange';

	        var data = {
	        	field_id : field_id,
	        	field_value : field_value,
	        	calltype : calltype,
	        	fieldtype : fieldtype,
	        	groupfieldcount : groupfieldcount
	        }
	        
	        getchild_field(data, $elem);
	    });

	    $('body').on('keyup', '.percentage', function(){
	        $elem = $(this);
	        $elem.closest('.form-group').find('.error').html('');
	        if($elem.val().length > 0){
	            if(!/^(\d*\.?\d*)$/.test($elem.val())){
	                $elem.closest('.form-group').find('.error').html('Please! Enter only number');
	            }else if (!/^[0-9]+(\.\d{1,2})?$/.test($elem.val())) {
	                $elem.closest('.form-group').find('.error').html('Field can contain only proper decimal number.');
	            }
	        }

	        var maxvalue = $elem.data("maxvalue");    
	        if(maxvalue != '' && $elem.val() > maxvalue){
	            $elem.closest('.form-group').find('.error').html('This field value can not be greater than '+maxvalue+'.');
	        }

	        var maxlength = $elem.data("maxlength");
	        if($elem.val().length > maxlength){
	            $elem.closest('.form-group').find('.error').html('Please! Enter upto '+maxlength+' character/number');
	        }

	        var field_id = $elem.attr("data-field_id");
	        var field_value = $elem.val();
	        var fieldtype = $elem.attr("data-fieldtype");

	        var classname = 'childof'+field_id;
	        if(fieldtype == 'groupfield'){
	            $elem.closest('.row').find('.'+classname).html('');
	        }else{
	            $('.'+classname).html('');
	        }

	        if($elem.val() == 100 || $elem.val() == 100.0 || $elem.val() == 100.00){                
	            if(fieldtype == 'groupfield'){
	                var groupfieldcount = $elem.attr("data-groupfieldcount");
	            }else{
	                var groupfieldcount = "";
	            }               

	            var calltype = 'onchange';
	            var data = {
	                field_id : field_id,
	                field_value : field_value,
	                calltype : calltype,
	                fieldtype : fieldtype,
	                groupfieldcount : groupfieldcount
	            }                
	            getchild_field(data, $elem);
	        }
	    });

	    $('body').on('change', 'input[type=checkbox]', function() {
	    	$elem = $(this);

	        var field_id = $(this).attr("data-field_id");
	        var fieldtype = $(this).attr("data-fieldtype");

	        if(fieldtype == 'groupfield'){
	        	var groupfieldcount = $(this).attr("data-groupfieldcount");
	        }else{
	        	var groupfieldcount = "";
	        }

	        var name = $(this).attr("name");
	        var calltype = 'onchange';

	        var classname = 'childof'+field_id;
	        if(fieldtype == 'groupfield'){
	        	$elem.closest('.row').find('.'+classname).html('');
	        }else{
	        	$('.'+classname).html('');
	        }

	        var checkedvalues = [];
            $.each($("input[name='"+name+"']:checked"), function(){
                checkedvalues.push($(this).val());
            });

            var field_value = checkedvalues;

            if(field_value != ''){
            	var data = {
		        	field_id : field_id,
		        	field_value : field_value,
		        	calltype : calltype,
		        	fieldtype : fieldtype,
		        	groupfieldcount : groupfieldcount
		        }

	            getchild_field(data, $elem);
            }
	    });

	    $('body').on('change', '.selectbox', function() {
	    	$elem = $(this);

	    	$elem.closest('.form-group').find('.error').empty();

	        var field_id = $(this).attr("data-field_id");
	        var fieldtype = $(this).attr("data-fieldtype");
	        var maxlength = $(this).attr("data-maxlength");

	        if(fieldtype == 'groupfield'){
	        	var groupfieldcount = $(this).attr("data-groupfieldcount");
	        }else{
	        	var groupfieldcount = "";
	        }

	        var name = $(this).attr("name");
	        var calltype = 'onchange';

	        var classname = 'childof'+field_id;
	        if(fieldtype == 'groupfield'){
	        	$elem.closest('.row').find('.'+classname).html('');
	        }else{
	        	$('.'+classname).html('');
	        }

	        var checkedvalues = [];
            $.each($("select[name='"+name+"'] option:selected"), function(){
            	if($(this).val() != ''){
                	checkedvalues.push($(this).val());
                }
            });

            var field_value = checkedvalues;

            if(maxlength != 'null'){
            	if(parseInt(maxlength) < parseInt(checkedvalues.length)){
            		$elem.closest('.form-group').find('.error').html('Please select only '+maxlength+' option.');

            		$elem.val('');
            	}else{
            		if(field_value != ''){
		            	var data = {
				        	field_id : field_id,
				        	field_value : field_value,
				        	calltype : calltype,
				        	fieldtype : fieldtype,
				        	groupfieldcount : groupfieldcount
				        }

			            getchild_field(data, $elem);
		            }
            	}
            }else{
            	if(field_value != ''){
	            	var data = {
			        	field_id : field_id,
			        	field_value : field_value,
			        	calltype : calltype,
			        	fieldtype : fieldtype,
			        	groupfieldcount : groupfieldcount
			        }

		            getchild_field(data, $elem);
	            }
            }            
	    });
	});

	//send back option
	$('body').on('click', '.send_back', function(event) {
		var elem = $(this),
		modal = $('#sendBackModal'),
		recordId = elem.data('recordid'),
		backToApproved = elem.data('apprby'),
		backToSubmitted = elem.data('subby');

		// Set values in modal
		modal.modal('show');
		modal.find('form')[0].reset();
		modal.find('form').data('id', recordId);
		modal.find('#backToApproved').html(backToApproved);
		modal.find('#backToSubmitted').html(backToSubmitted);
	}).on('submit', '#sendBackForm', function(event) {
		event.preventDefault();
		var form = $(this),
		formData = new FormData(form[0]);
		formData.append('id', form.data('id'));
		
		form.find('button').prop('disabled', true);
		form.find('button[type="submit"]').html('Please wait...');
		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/send_back_monitoring',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			error: function() {
				form.find('button').prop('disabled', false);
				form.find('button[type="submit"]').html('Send Back');
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success: function(data) {
				var data = JSON.parse(data);

				if(data.status == 0) {
					if(data.errors && data.errors.length > 0) {
						for(var key in data.errors) {
							var errorContainer = form.find(`.${key}.error`);
							if(errorContainer.length !== 0) {
								errorContainer.html(data.errors[key]);
							}
						}
					} else {
						$.toast({
							heading: 'Error!',
							text: data.msg,
							icon: 'error',
							afterHidden: function () {
								form.find('button').prop('disabled', false);
								form.find('button[type="submit"]').html('Send Back');
							}
						});
					}
					return false;
				}

				$.toast({
					heading: 'Success!',
					text: data.msg,
					icon: 'success',
					afterHidden: function () {
						$('#sendBackModal').modal('hide');
						form.find('button').prop('disabled', false);
						form.find('button[type="submit"]').html('Send Back');
					}
				});
			}
		});
	});
</script>
