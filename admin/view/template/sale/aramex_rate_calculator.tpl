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
			if(isset($rate_html) && !empty($rate_html))
			{
					echo $rate_html;
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
  <!--  code --->
  <form enctype="multipart/form-data" action="" method="post" id="calculate_rate" novalidate="novalidate">
    <table width="100%" class="table  table-bordered table-hover">
	 
      <tr>
        <td>
		  <fieldset id="aramex_shipment_creation_general_info">
          <legend>Calculate Rates</legend>
		  <h3>Shipment Origin</h3>
          <table class="form">
            <tr>
              <td><span class="required">*</span>Country</td>
              <td>
			  
			    <select name="origin_country" id="origin_country" class="aramex_countries validate-select ">
                 
				  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['iso_code_2'] == $origin_country) { ?>
                  <option value="<?php echo $country['iso_code_2']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['iso_code_2']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
				  
                  </select>
                </td>
				<td>City</td>
                <td>
					<input type="text" value="<?php echo $origin_city;?>" name="origin_city" id="origin_city" class="">
                </td>
            
			</tr>
            <tr>
           	  <td>Postal Code</td>
              <td><input type="text" value="<?php echo $origin_zipcode;?>" name="origin_zipcode" id="origin_zipcode" class="">
              </td>
			  <td>State</td>
              <td><input type="text" value="<?php echo $origin_state;?>" name="origin_state" id="origin_state" class="">
              </td>
			  
            </tr>
    
		    <tr>
              <td colspan="4"> <h3>Shipment Destination</h3></td>
		    </tr>
    
            <tr>
              <td><span class="required">*</span>Country</td>
              <td>
			  
			    <select name="destination_country" id="destination_country" class="aramex_countries validate-select ">
                 
				  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['iso_code_2'] == $destination_country) { ?>
                  <option value="<?php echo $country['iso_code_2']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['iso_code_2']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
				  
                  </select>
                </td>
				<td>City</td>
                <td>
					<input type="text" value="<?php echo $destination_city;?>" name="destination_city" id="destination_city" class="">
                </td>
            
			</tr>
            <tr>
           	  <td>Postal Code</td>
              <td><input type="text" value="<?php echo $destination_zipcode;?>" name="destination_zipcode" id="destination_zipcode" class="">
              </td>
			  <td>State</td>
              <td><input type="text" value="<?php echo $destination_state;?>" name="destination_state" id="destination_state" class="">
              </td>
			  
            </tr>
			<tr>
				<td><span class="required">*</span>Payment Type:</td>
                <td><select name="payment_type" id="payment_type" class="aramex_all_options ">
                        <option value="P" <?php if($pay_type=='P'){ echo 'selected="selected"'; } ?>>Prepaid</option>
						<option value="C" <?php if($pay_type=='C'){ echo 'selected="selected"'; } ?>>Collect</option>
						<option value="3" <?php if($pay_type=='3'){ echo 'selected="selected"'; } ?>>Third Party</option>

                      </select>
				</td>
				 <td><span class="required">*</span>Product Group:</td>
                    <td>
					
		
					<?php
					$checkCountry=false;
					if($group==''){
						$checkCountry=($origin_country == $destination_country)?true:false;
					}
					?>
					<select class="aramex_all_options " id="product_group" name="product_group"  >

						<option <?php echo ($group =='DOM' or $checkCountry) ? 'selected="selected"' : ''; ?> value="DOM">Domestic</option>
						<option <?php echo ($group =='EXP' or ($group=='' and !$checkCountry)) ? 'selected="selected"' : ''; ?> value="EXP">International Express</option>

					</select>
					<div id="aramex_shipment_info_product_group_div" style="display: none;"></div>
					</td>
			</tr>
			<tr>		
					<td><span class="required">*</span>Service Type:</td>
                    <td>
			
					<?php 
						
						$notHide='';
						if($origin_country == $destination_country and $type=='')
						{  
							$notHide='display: none'; 
						}
						$checkCountry=false;
						if($type==''){
							$checkCountry=($origin_country == $destination_country)?true:false;
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
					<select class="aramex_all_options  " id="service_type" name="service_type">
					
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
					<td><span class="required">*</span>Total weight:</td>
                    <td><div style="display:none" class="text_short">Total weight: <span id="order-total-weight">210.00</span> KG</div>
                      <input type="text" class="" value="<?php echo $weighttot;?>" name="text_weight">
                      <select class="" name="weight_unit">
                        <option value="KG" <?php echo (strtoupper($weight_unit)=='KG')?'selected="selected"':'';?>>KG</option>
                        <option value="LB" <?php echo (strtoupper($weight_unit)=='LB')?'selected="selected"':'';?>>LB</option>
                      </select>
                    </td>
			</tr>
			<tr>
				<tr>
                    <td><span class="required">*</span>Number of Pieces:</td>
                    <td>
						<input type="text" value="<?php echo $no_of_item;?>" name="total_count" class="" />
					</td>
                  </tr>
			</tr>
          </table>
          </fieldset>
		  </td>
      </tr>
      <tr>
        <td colspan="4" align="center">
   		    <div class="buttons">
        	    <a class="btn btn-info" onclick="$('#calculate_rate').submit();" id="aramex_shipment_creation_submit_id">Calculate</a>
 				
			<div>
          </td>
      </tr>
	  
    </table>
	<input type="hidden" value="<?php echo $reference;?>" name="reference" />
  </form>
  </div>
</div>
  <script type="text/javascript">
			$(document).ready(function(){
					$("#service_type").chained("#product_group");
			});
  </script>
  <!-- code --->
</div>
</div>		
<?php echo $footer; ?>