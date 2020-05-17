<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-fedex" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-fedex" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_email" value="<?php echo $aramex_email; ?>" id="input-key" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_password" value="<?php echo $aramex_password; ?>"  id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
		  
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-account"><?php echo $entry_account_pin; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_account_pin" value="<?php echo $aramex_account_pin; ?>" id="input-account" class="form-control" />
              <?php if ($error_account_pin) { ?>
              <div class="text-danger"><?php echo $error_account_pin; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-meter"><?php echo $entry_account_number; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_account_number" value="<?php echo $aramex_account_number; ?>" id="input-meter" class="form-control" />
              <?php if ($error_account_number) { ?>
              <div class="text-danger"><?php echo $error_account_number; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_account_entity; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_account_entity" value="<?php echo $aramex_account_entity; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_account_entity) { ?>
              <div class="text-danger"><?php echo $error_account_entity; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_account_country_code; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_account_country_code" value="<?php echo $aramex_account_country_code; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_account_country_code) { ?>
              <div class="text-danger"><?php echo $error_account_country_code; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $entry_service_configuration; ?></h3>
		  </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_test_mode; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($aramex_test) { ?>
                <input type="radio" name="aramex_test" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_test" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$aramex_test) { ?>
                <input type="radio" name="aramex_test" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_test" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_report_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_report_id" value="<?php echo $aramex_report_id; ?>" id="input-postcode" class="form-control" />
        
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_domestic_methods; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($allowed_domestic_methods as $key=>$dservice) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($dservice['value'], $aramex_allowed_domestic_methods)) { ?>
                    <input type="checkbox" name="aramex_allowed_domestic_methods[]" value="<?php echo $dservice['value']; ?>" checked="checked" />
                    <?php echo $dservice['label']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="aramex_allowed_domestic_methods[]" value="<?php echo $dservice['value']; ?>" />
                    <?php echo $dservice['label']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_domestic_additional_services; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($allowed_domestic_additional_services as $key=>$daservice) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($daservice['value'], $aramex_allowed_domestic_additional_services)) { ?>
                    <input type="checkbox" name="aramex_allowed_domestic_additional_services[]" value="<?php echo $daservice['value']; ?>" checked="checked" />
                    <?php echo $daservice['label']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="aramex_allowed_domestic_additional_services[]" value="<?php echo $daservice['value']; ?>" />
                    <?php echo $daservice['label']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
		  
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_international_methods; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($allowed_international_methods as $key=>$iservice) { ?>
                <div class="checkbox">
                  <label>
                      <?php if (in_array($iservice['value'], $aramex_allowed_international_methods)) { ?>
					  <input type="checkbox" name="aramex_allowed_international_methods[]" value="<?php echo $iservice['value']; ?>" checked="checked" />
					  <?php echo $iservice['label']; ?>
					  <?php } else { ?>
					  <input type="checkbox" name="aramex_allowed_international_methods[]" value="<?php echo $iservice['value']; ?>" />
					  <?php echo $iservice['label']; ?>
					  <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_international_additional_services; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($allowed_international_additional_services as $key=>$iaservice) { ?>
                <div class="checkbox">
                  <label>
                  <?php if (in_array($iaservice['value'], $aramex_allowed_international_additional_services)) { ?>
                  <input type="checkbox" name="aramex_allowed_international_additional_services[]" value="<?php echo $iaservice['value']; ?>" checked="checked" />
                  <?php echo $iaservice['label']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="aramex_allowed_international_additional_services[]" value="<?php echo $iaservice['value']; ?>" />
                  <?php echo $iaservice['label']; ?>
                  <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
		  
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-weight-class"><span data-toggle="tooltip" title="<?php echo $help_weight_class; ?>"><?php echo $entry_weight_class; ?></span></label>
            <div class="col-sm-10">
              <select name="aramex_weight_class_id" id="input-weight-class" class="form-control">
                <?php foreach ($weight_classes as $weight_class) { ?>
                <?php if ($weight_class['weight_class_id'] == $aramex_weight_class_id) { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-10">
              <select name="aramex_tax_class_id" id="input-tax-class" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $aramex_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="aramex_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $aramex_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="aramex_status" id="input-status" class="form-control">
                <?php if ($aramex_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_sort_order" value="<?php echo $aramex_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $entry_shipper_details; ?></h3>
		  </div>
		  
		   <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-aramex_shipper_name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_name" value="<?php echo $aramex_shipper_name; ?>"  id="input-aramex_shipper_name" class="form-control" />
              <?php if ($error_shipper_name) { ?>
              <div class="text-danger"><?php echo $error_shipper_name; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_email" value="<?php echo $aramex_shipper_email; ?>"  id="input-entry_email" class="form-control" />
              <?php if ($error_shipper_email) { ?>
              <div class="text-danger"><?php echo $error_shipper_email; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_company"><?php echo $entry_company; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_company" value="<?php echo $aramex_shipper_company; ?>"  id="input-entry_company" class="form-control" />
              <?php if ($error_shipper_company) { ?>
              <div class="text-danger"><?php echo $error_shipper_company; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_address"><?php echo $entry_address; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_address" value="<?php echo $aramex_shipper_address; ?>"  id="input-entry_address" class="form-control" />
              <?php if ($error_shipper_address) { ?>
              <div class="text-danger"><?php echo $error_shipper_address; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_country_code"><?php echo $entry_country_code; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_country_code" value="<?php echo $aramex_shipper_country_code; ?>"  id="input-entry_country_code" class="form-control" />
              <?php if ($error_shipper_country_code) { ?>
              <div class="text-danger"><?php echo $error_shipper_country_code; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_city" value="<?php echo $aramex_shipper_city; ?>"  id="input-entry_city" class="form-control" />
              <?php if ($error_shipper_city) { ?>
              <div class="text-danger"><?php echo $error_shipper_city; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_postal_code"><?php echo $entry_postal_code; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_postal_code" value="<?php echo $aramex_shipper_postal_code; ?>"  id="input-entry_postal_code" class="form-control" />
              <?php if ($error_shipper_postal_code) { ?>
              <div class="text-danger"><?php echo $error_shipper_postal_code; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_state"><?php echo $entry_state; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_state" value="<?php echo $aramex_shipper_state; ?>"  id="input-entry_state" class="form-control" />
              <?php if ($error_shipper_state) { ?>
              <div class="text-danger"><?php echo $error_shipper_state; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_phone"><?php echo $entry_phone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_shipper_phone" value="<?php echo $aramex_shipper_phone; ?>"  id="input-entry_phone" class="form-control" />
              <?php if ($error_shipper_phone) { ?>
              <div class="text-danger"><?php echo $error_shipper_phone; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $entry_default_service_configuration; ?></h3>
		  </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_auto_create_shipment; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($aramex_auto_create_shipment) { ?>
                <input type="radio" name="aramex_auto_create_shipment" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_auto_create_shipment" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$aramex_auto_create_shipment) { ?>
                <input type="radio" name="aramex_auto_create_shipment" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_auto_create_shipment" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
		  
		  <div class="form-group required" >
            <label class="col-sm-2 control-label"><?php echo $entry_live_rate_calculation; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($aramex_live_rate_calculation) { ?>
                <input type="radio" name="aramex_live_rate_calculation" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_live_rate_calculation" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$aramex_live_rate_calculation) { ?>
                <input type="radio" name="aramex_live_rate_calculation" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="aramex_live_rate_calculation" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-entry_default_rate"><?php echo $entry_default_rate; ?></label>
            <div class="col-sm-10">
              <input type="text" name="aramex_default_rate" value="<?php echo $aramex_default_rate; ?>"  id="input-entry_default_rate" class="form-control" />
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_domestic_methods; ?></label>
            <div class="col-sm-10">
              <select name="aramex_default_allowed_domestic_methods" id="input-tax-class" class="form-control">
					<option value=""/>Select Domestic Methods</option>
					<?php foreach ($allowed_domestic_methods as $key=>$dservice) { ?>
					<?php if ($dservice['value']==$aramex_default_allowed_domestic_methods) { ?>
					<option value="<?php echo $dservice['value']; ?>" selected/><?php echo $dservice['label']; ?></option>
					 <?php } else { ?>
					 <option value="<?php echo $dservice['value']; ?>"/><?php echo $dservice['label']; ?></option>
					<?php }
					} ?>
				</select>
              <?php if ($error_default_allowed_domestic_methods) { ?>
              <div class="text-danger"><?php echo $error_default_allowed_domestic_methods; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_domestic_additional_services; ?></label>
            <div class="col-sm-10">
              <select name="aramex_default_allowed_domestic_additional_services" class="form-control">
					<option value=""/>Select Domestic Additional Services</option>
					<?php foreach ($allowed_domestic_additional_services as $key=>$daservice) { ?>
					<?php if ($daservice['value']==$aramex_default_allowed_domestic_additional_services) { ?>
					<option value="<?php echo $daservice['value']; ?>" selected/><?php echo $daservice['label']; ?></option>
					 <?php } else { ?>
					 <option value="<?php echo $daservice['value']; ?>"/><?php echo $daservice['label']; ?></option>
					 
					<?php }
					} ?>
				</select>
              <?php if ($error_default_allowed_domestic_additional_services) { ?>
              <div class="text-danger"><?php echo $error_default_allowed_domestic_additional_services; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_international_methods; ?></label>
            <div class="col-sm-10">
              <select name="aramex_default_allowed_international_methods" class="form-control">
					<option value=""/>Select International Methods</option>
					<?php foreach ($allowed_international_methods as $key=>$iservice) { ?>
					<?php if ($iservice['value']==$aramex_default_allowed_international_methods) { ?>
					<option value="<?php echo $iservice['value']; ?>" selected/><?php echo $iservice['label']; ?></option>
					 <?php } else { ?>
					 <option value="<?php echo $iservice['value']; ?>"/><?php echo $iservice['label']; ?></option>
					 
					<?php }
					} ?>
				</select>
              <?php if ($error_default_allowed_international_methods) { ?>
              <div class="text-danger"><?php echo $error_default_allowed_international_methods; ?></div>
              <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_allowed_international_additional_services; ?></label>
            <div class="col-sm-10">
              <select name="aramex_default_allowed_international_additional_services" class="form-control">
					<option value=""/>Select International Additional Services</option>
					<?php foreach ($allowed_international_additional_services as $key=>$iaservice) { ?>
					<?php if ($iaservice['value']==$aramex_default_allowed_international_additional_services) { ?>
					<option value="<?php echo $iaservice['value']; ?>" selected/><?php echo $iaservice['label']; ?></option>
					 <?php } else { ?>
					 <option value="<?php echo $iaservice['value']; ?>"/><?php echo $iaservice['label']; ?></option>
					 
					<?php }
					} ?>
				</select>
              <?php if ($error_default_allowed_international_additional_services) { ?>
              <div class="text-danger"><?php echo $error_default_allowed_international_additional_services; ?></div>
              <?php } ?>
            </div>
          </div>
		  
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>