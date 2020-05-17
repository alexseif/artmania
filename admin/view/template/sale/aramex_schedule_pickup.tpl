<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<style>
td{
padding:8px;
}
</style>
<div class="page-header">
	<div class="container-fluid">
		<h1><?php echo $heading_title; ?></h1>
		<ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
	  <div class="pull-right"> 
  <a href="<?php echo $back_to_order; ?>" target="_blank" class="btn btn-info"><?php echo $text_back_to_order; ?></a> 
  <?php
  if($is_shipment)
  {
  ?>
  <a href="<?php echo $aramex_create_sipment; ?>" class="button">Return Shipment</a> 
  <?php
  }else{
  ?>
   <a href="<?php echo $aramex_create_sipment; ?>" class="button"><?php echo $text_create_sipment; ?></a> 
  <?php } ?>
  <a href="<?php echo $aramex_rate_calculator; ?>"  class="btn btn-info"><?php echo $text_rate_calculator; ?></a>
  <?php
  if($is_shipment)
  {
  ?>
	<a href="<?php echo $aramex_print_label; ?>" target="_blank" class="btn btn-info"><?php echo $text_print_label; ?></a>     
	<a href="<?php echo $aramex_schedule_pickup; ?>"  class="btn btn-info"><?php echo $text_schedule_pickup; ?></a> 
	<a href="<?php echo $aramex_traking; ?>"  class="btn btn-info"><?php echo $text_track; ?></a>
  <?php
  }
  ?>
  </div>
	</div>
</div>
<div class="box">
<div class="container-fluid">
<div class="panel-heading">
			<h3 class="panel-title">
				<?php 
						if(isset($success_html) && !empty($success_html))
						{
								echo $success_html;
						}
				?>
			</h3>
			<h3 class="panel-title" style="color:red;"> 
				<?php
					if(isset($eRRORS) && !empty($eRRORS))
					{
						foreach($eRRORS as $val)
						{
								echo $val;
								echo "<br>";
						}
					}
				?>
		   </h3>
</div>
  <!--  code --->
<div class="panel panel-default">
	<div class="panel-body">
  <form enctype="multipart/form-data" action="" method="post" id="schedule_pickup" novalidate="novalidate">
    <table width="100%">
	 
      <tr>
        <td>
		  <fieldset id="aramex_shipment_creation_general_info">
          <legend>Schedule Pickup</legend>
		  <h3>Pickup Details</h3>
          <table class="form">
		   <tr>
           	  <td>Location:</td>
              <td>
			  <input type="text" readonly="readonly" name="location" id="pickup_location" value="Reception" />
			  </td>
			  <td>Vehicle Type:</td>
              <td>
							<select name="vehicle" id="pickup_vehicle" >
								<option value="Bike">Small (no specific vehicle required)</option>
								<option value="Car">Medium (regular car or small van)</option>
								<option value="Truck">Large (large van or truck required)</option>
							</select>
              </td>
			  
            </tr>
			  <tr>
           	  <td><span class="required">*</span>Date:</td>
              <td>
			  <input type="text" readonly="readonly" name="date" id="pickup_date" value="<?php echo $date;?>" class="date" data-date-format="YYYY-MM-DD" />
			  </td>
              <td colspan="2">
							<span class="required">*</span>Ready Time:
							<select name="ready_hour" class="width-60 fl" id="ready_hour">	
								<?php $time=date("H",time());?>
								<?php for($i=7;$i<20;$i++):?>
								<?php $val=($i<10)?"0{$i}":$i;?>
								<option value="<?php echo $val;?>" <?php echo ($time==$i)?'selected="selected"':'';?>><?php echo $val;?></option>
								<?php endfor;?>
							</select>
							<select name="ready_minute" class="width-60 fl mar-lf-10" id="ready_minute">	
								<?php $time=date("i",time());?>
								<?php for($i=0;$i<=55;$i=$i+5):?>
								<?php $val=($i<10)?"0{$i}":$i;?>
								<option value="<?php echo $val;?>" <?php echo ($time==$val)?'selected="selected"':'';?>><?php echo $val;?></option>
								<?php endfor;?>
							</select>
							<span class="required">*</span>Closing Time:
							<select name="latest_hour" class="width-60 fl" id="latest_hour">	
								<?php $time=date("H",time());?>
								<?php $time=$time+1;?>
								<?php for($i=7;$i<20;$i++):?>
								<?php $val=($i<10)?"0{$i}":$i;?>
								<option value="<?php echo $val?>" <?php echo ($time==$val)?'selected="selected"':'';?>><?php echo $val;?></option>
								<?php endfor;?>
							</select>
							<select name="latest_minute" class="width-60 fl mar-lf-10" id="latest_minute">	
								<?php $time=date("i",time());?>								
								<?php for($i=0;$i<=55;$i=$i+5):?>
								<?php $val=($i<10)?"0{$i}":$i;?>
								<option value="<?php echo $val;?>" <?php echo ($time==$val)?'selected="selected"':'';?>><?php echo $val;?></option>
								<?php endfor;?>
							</select>
              </td>
			  
            </tr>
			 <tr>
           	  <td>Reference 1:</td>
              <td>
			  <input type="text" name="reference" id="pickup_reference" value="<?php echo $reference;?>" />
			  </td>
			  <td><span class="required">*</span>Status:</td>
              <td>
							<select name="status" id="pickup_status" >
								<option value="Ready">Ready</option>
								<option value="Pending">Pending</option>								
							</select>
              </td>
			  
            </tr>
            
			<tr>
				
				 <td><span class="required">*</span>Product Group:</td>
                    <td>
					
		
					<?php
					$checkCountry=false;
					if($group==''){
						$checkCountry=($country == $destination_country)?true:false;
					}
					?>
					<select class="aramex_all_options" id="product_group" name="product_group"  >

						<option <?php echo ($group =='DOM' or $checkCountry) ? 'selected="selected"' : ''; ?> value="DOM">Domestic</option>
						<option <?php echo ($group =='EXP' or ($group=='' and !$checkCountry)) ? 'selected="selected"' : ''; ?> value="EXP">International Express</option>

					</select>
					<div id="aramex_shipment_info_product_group_div" style="display: none;"></div>
					</td>
					<td><span class="required">*</span>Product Type:</td>
                    <td>
			
					<?php 
						
						$notHide='';
						if($country == $destination_country and $type=='')
						{  
							$notHide='display: none'; 
						}
						$checkCountry=false;
						if($type==''){
							$checkCountry=($country == $destination_country)?true:false;
						}
					?>
					<?php 
					
					
						$allowed_domestic_methods =   $aramex_allowed_domestic_methods;
						$allowed_international_methods =  $aramex_allowed_international_methods;
						$domestic_methods = $all_allowed_domestic_methods;
						$international_methods = $all_allowed_international_methods;
						$allowed_domestic_methods_apply = array();
						$allowed_international_methods_apply = array();
						//print_r($domestic_methods);
						
					?>
					<select class="aramex_all_options" id="product_type" name="product_type">
					
					        <?php if(count($allowed_domestic_methods)>0){ 
							         $i=1;
									 foreach($domestic_methods as $key=>$val){
									   if(in_array($val['value'],$allowed_domestic_methods)){
                                        $selected_str='';
										if($i==1){ 
												$selected_str =($type ==$val['value'] or $checkCountry) ? 'selected="selected"' : '';}
										else {
												$selected_str =($type ==$val['value']) ? 'selected="selected"' : '';
											}
											$allowed_domestic_methods_apply[$val['value']] = $val['label'];
											/* style="<?php echo ($group!='DOM')?'display: none':''; ?>"*/
											
 									   ?>
									    
									   <option <?php echo $selected_str; ?> value="<?php echo $val['value']; ?>" id="<?php echo $val['value'];?>"  class="DOM"><?php echo $val['label']; ?></option>
							<?php $i++;
							      } 
                                 }								
								}
							?>
							
							
							
							 <?php if(count($allowed_international_methods)>0){ 
							         $i=1;
												
									 foreach($international_methods as $key=>$val){
									   if(in_array($val['value'],$allowed_international_methods)){						    
                                        $selected_str='';
										if($i==1){ 
										          
												if($type ==$val['value'] or (!$checkCountry and $type=='')){
													$selected_str = 'selected="selected"';
												}
											}
										else {
										        if($type ==$val['value']){
													$selected_str = 'selected="selected"';
												}												
											}
											$allowed_international_methods_apply[$val['value']] = $val['label'];  
											/* style="<?php echo ($checkCountry or $group=='DOM')?'display: none':''; ?>" */
											
 									   ?>									    
									   <option <?php echo $selected_str; ?> value="<?php echo $val['value']; ?>" id="<?php echo $val['value'];?>" class="EXP"><?php echo $val['label']; ?></option>
							<?php  $i++;
							     }							    
                                 }								 
								}
							?>
							
					</select>
					
					
					</td>
			</tr>
			<tr>		
					
					<td><span class="required">*</span>Payment Type:</td>
					<td>
						<select name="payment_type" id="payment_type" class="aramex_all_options">
							<option value="P" <?php if($pay_type=='P'){ echo 'selected="selected"'; } ?>>Prepaid</option>
							<option value="C" <?php if($pay_type=='C'){ echo 'selected="selected"'; } ?>>Collect</option>
							<option value="3" <?php if($pay_type=='3'){ echo 'selected="selected"'; } ?>>Third Party</option>

						</select>
					</td>
					<td><span class="required">*</span>Total weight:</td>
                    <td>
					  <div style="display:none" class="text_short">Total weight: <span id="order-total-weight">210.00</span> KG</div>
                      <input type="text" class="fl width-60 mar-right-10" value="<?php echo $weighttot;?>" name="text_weight">
                      <select class="fl width-60" name="weight_unit">
                        <option value="KG" <?php echo (strtoupper($weight_unit)=='KG')?'selected="selected"':'';?>>KG</option>
                        <option value="LB" <?php echo (strtoupper($weight_unit)=='LB')?'selected="selected"':'';?>>LB</option>
                      </select>
                    </td>
			</tr>
			<tr>
				<tr>
                    <td><span class="required">*</span>Number of Pieces:</td>
                    <td>
						<input type="text" value="<?php echo $no_of_item;?>" name="total_count" class="fl" />
					</td>
					<td>Number of Shipments:</td>
                    <td>
						<input type="text" value="1" name="no_shipments" class="fl" />
					</td>
                  </tr>
			</tr>
			<tr>
              <td colspan="4"> <h3>Shipment Destination</h3></td>
		    </tr>
			<tr>
			<tr>
                    <td><span class="required">*</span>Company:</td>
                    <td>
						<input type="text" name="company" id="pickup_company" value="<?php echo $company; ?>" />
					</td>
					<td><span class="required">*</span>Contact:</td>
                    <td>
						<input type="text" name="contact" id="pickup_contact" value="<?php echo $contact; ?>" /> 
					</td>
         
			</tr>
			<tr>
                    <td><span class="required">*</span>Phone:</td>
                    <td>
						<input type="text" name="ext" id="pickup_ext" value="" size="4"/>
						<input type="text" name="phone" id="pickup_phone" value="<?php echo $phone; ?>" />
					</td>
					<td><span class="required">*</span>Mobile:</td>
                    <td>
						
						<input type="text" name="mobile" id="pickup_mobile" value="<?php echo $mobile; ?>" class="width-full required-entry" />						
					</td>
         
			</tr>
			<tr>
                    <td><span class="required">*</span>Address:</td>
                    <td colspan="4">
						<input type="text" name="address" id="pickup_address" value="<?php echo $address; ?>" style="width:100%"/>
					</td>
					
         
			</tr>
			<tr>
              <td><span class="required">*</span>Country:</td>
              <td>
			  
			    <select name="country" id="pickup_country" class="aramex_countries validate-select valid">
                 
				  <?php foreach ($countries as $ctry) { ?>
                  <?php if ($ctry['iso_code_2'] == $country) { ?>
                  <option value="<?php echo $ctry['iso_code_2']; ?>" selected="selected"><?php echo $ctry['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $ctry['iso_code_2']; ?>"><?php echo $ctry['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
				  
                  </select>
                </td>
				<td>State:</td>
              <td><input type="text" value="<?php echo $state;?>" name="state" id="pickup_state">
              </td>
				
            
			</tr>
            <tr>
				<td>City:</td>
                <td>
					<input type="text" value="<?php echo $city;?>" name="city" id="pickup_city">
                </td>
           	  <td>Postal Code:</td>
              <td><input type="text" value="<?php echo $zip;?>" name="zip" id="pickup_zip">
              </td>
			  
			  
            </tr>
			<tr>
                    <td><span class="required">*</span>Email:</td>
                    <td colspan="4">
						<input type="text" name="email" id="pickup_email" value="<?php echo $email; ?>" style="width:100%"/>
					</td>
			</tr>
			<tr>
                    <td>Comments:</td>
                    <td colspan="4">
						<input type="text" name="comments" id="pickup_comments" value="<?php echo $comments; ?>" style="width:100%"/>
					</td>
			</tr>
         
          </table>
          </fieldset>
		  </td>
      </tr>
	    <?php
		  if(!$is_pickup_created)
		  {
		?>
      <tr>
        <td colspan="4" align="center">
   		    <div class="buttons">
        	    <a class="btn btn-info" onclick="return submit();" id="aramex_shipment_creation_submit_id">Submit</a>
 				
			<div>
          </td>
      </tr>
	   <?php
		  }
		?>
	  
    </table>
	<input type="hidden" value="<?php echo $reference;?>" name="reference" />
  </form>
  </div>
  </div>
  <!-- code --->
  <script type="text/javascript">
			 $(document).ready(function(){
					$("#product_type").chained("#product_group");
					
					$('.date').datetimepicker({
						pickTime: false
					});
					/*$('.date').datepicker({dateFormat: 'yy-mm-dd'});
					
						$('.datetime').datetimepicker({
									dateFormat: 'yy-mm-dd',
									timeFormat: 'h:m'
						});	
									
						$('.time').timepicker({timeFormat: 'h:m'});
					*/
			});
			
			function submit()
			{
					var H='<?php echo date("H",time());?>';
					var M='<?php echo date("i",time());?>';
					var D='<?php echo date("Y-m-d",time());?>';
			
						var rH=$('#ready_hour').val();
						var lH=$('#latest_hour').val();
						var rM=$('#ready_minute').val();
						var lM=$('#latest_minute').val();				
						var error=false;
						var rDate=$('#pickup_date').val();
				
						if(rDate=='' || rDate==null){ alert("Pickup Date should not empty"); return; }
						rDate=rDate.split("-");				
						cDate=D.split("-");				
						var isCheckTime=false;
						// m/d/Y
						// Y-m-d
						if(rDate[0]<cDate[0]){ // year
							error=true;					
						}else if(rDate[0]==cDate[0]){
							if(rDate[1]<cDate[1]){ //month
								error=true;
							}else if(rDate[1]==cDate[1]){
								if(rDate[2]<cDate[2]){ //day
									error=true;
								}else if(rDate[2]==cDate[2]){
									if(rH<H){
										alert("Ready Time should be greater than Current Time");
										return;
									}else if(rH==H && rM<M){
										alert("Ready Time should be greater than Current Time");
										return;
									}
									isCheckTime=true;
								}
							}
						}
						if(error){
							alert("Pickup Date should be greater than Current Date");
							return;
						}
						
						if(isCheckTime){					
							if(lH<rH ){					
								error=true;					
							}else if(lH<=rH && lM<=rM){
								error=true;		
							}					
							if(error){
								alert("Closing Time always greater than Ready Time");
								return;
							}
						}
						$('#schedule_pickup').submit();
							
			}
  </script>
  
</div>
</div>		
<?php echo $footer; ?>