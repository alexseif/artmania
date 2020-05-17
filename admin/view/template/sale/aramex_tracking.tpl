<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
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
<div class="container-fluid">
<div class="panel-heading">
	
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
		
</div>
<div class="panel panel-default">
 <div class="panel-body">
  <!--  code --->
  <form enctype="multipart/form-data" action="" method="post" id="calculate_rate" novalidate="novalidate">
	 <table summary="Item Tracking"  class="table table-bordered table-hover">
	<tr class="filter" align="center">
		 
		<td colspan="2" style="font-weight: bold;;">
			<input type="text" name="track_awb" value="<?php  echo $awb_no;?>" class="form-control">
			<a class="btn btn-primary" onclick="$('#calculate_rate').submit();;">Track</a>
		 </td>
	 </tr>
	 <tr class="filter">
			<td colspan="2" style="font-weight: bold;;">
				<?php  echo "AWB NO: ".$awb_no;?>
		    </td>
	 </tr>
	</table>
	</form>
      <?php 
			if(isset($html) && !empty($html))
			{
					echo $html;
			}
			
			?>
	  
    
	
 
 
  <!-- code --->
  </div>
</div>
</div>		
<?php echo $footer; ?>