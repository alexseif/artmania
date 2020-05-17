<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <h1><?php echo $heading_title; ?></h1>
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
      <form enctype="multipart/form-data" action="" method="post" id="calculate_rate">
		<table class="table table-bordered table-hover">
			<tbody><tr>
			  <td><span class="required"></span>Enter AWB:</td>
			  <td><input type="text" value="" name="track_awb">
			  <input type="submit" class="btn btn-primary" value="Submit">
				</td>
				
			</tr>
		   </tbody>
		</table>
    </form>
      <div class="table-responsive">
	  <table class="table table-bordered table-hover">
			<tr>
				<td colspan="4" style="font-weight: bold;;">
					<?php  echo "AWB NO: ".$awb_no;?>
				</td>
			</tr>
		</table>
        <?php 
			if(isset($html) && !empty($html))
			{
					echo $html;
			}
			
			?>
      </div>
      
     
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>