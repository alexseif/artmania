<?php
class ControllerShippingAramex extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('shipping/aramex');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('shipping/aramex');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('aramex', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');		
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		
		
		############ Personal Information Label ############ 
		
		$data['entry_client_information'] = $this->language->get('entry_client_information');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_account_pin'] = $this->language->get('entry_account_pin');
		$data['entry_account_number'] = $this->language->get('entry_account_number');
		$data['entry_account_entity'] = $this->language->get('entry_account_entity');
		$data['entry_account_country_code'] = $this->language->get('entry_account_country_code');
		
		############ Shipper Details Label ############ 
		$data['entry_shipper_details'] = $this->language->get('entry_shipper_details');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_country_code'] = $this->language->get('entry_country_code');
		$data['entry_city'] = $this->language->get('entry_city');			
		$data['entry_postal_code'] = $this->language->get('entry_postal_code');
		$data['entry_state'] = $this->language->get('entry_state');
		$data['entry_phone'] = $this->language->get('entry_phone');
		
		
		############ Service Configuration Label ############ 
		$data['entry_service_configuration'] = $this->language->get('entry_service_configuration');
		$data['entry_test_mode'] = $this->language->get('entry_test_mode');
		$data['entry_report_id'] = $this->language->get('entry_report_id');
		$data['entry_allowed_domestic_methods'] = $this->language->get('entry_allowed_domestic_methods');
		$data['entry_allowed_domestic_additional_services'] = $this->language->get('entry_allowed_domestic_additional_services');
		$data['entry_allowed_international_methods'] = $this->language->get('entry_allowed_international_methods');
		$data['entry_allowed_international_additional_services'] = $this->language->get('entry_allowed_international_additional_services');	
						
		############ Default Service Configuration Label ############ 
$data['entry_default_service_configuration'] = $this->language->get('entry_default_service_configuration');
$data['entry_auto_create_shipment'] = $this->language->get('entry_auto_create_shipment');
$data['entry_live_rate_calculation'] = $this->language->get('entry_live_rate_calculation');
$data['entry_default_rate'] = $this->language->get('entry_default_rate');


		############ Shipment Email Label ############ 
		
		$data['entry_shipment_email_copy_to'] = $this->language->get('entry_shipment_email_copy_to');
		$data['entry_shipment_email_copy_method'] = $this->language->get('entry_shipment_email_copy_method');
		
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_email'])) {
			$data['error_email'] = $this->error['error_email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['error_password'])) {
			$data['error_password'] = $this->error['error_password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['error_account_pin'])) {
			$data['error_account_pin'] = $this->error['error_account_pin'];
		} else {
			$data['error_account_pin'] = '';
		}

		if (isset($this->error['error_account_number'])) {
			$data['error_account_number'] = $this->error['error_account_number'];
		} else {
			$data['error_account_number'] = '';
		}

		if (isset($this->error['error_account_entity'])) {
			$data['error_account_entity'] = $this->error['error_account_entity'];
		} else {
			$data['error_account_entity'] = '';
		}
		
		if (isset($this->error['error_account_country_code'])) {
			$data['error_account_country_code'] = $this->error['error_account_country_code'];
		} else {
			$data['error_account_country_code'] = '';
		}

		############# shipper error ###############
		if (isset($this->error['error_shipper_name'])) {
			$data['error_shipper_name'] = $this->error['error_shipper_name'];
		} else {
			$data['error_shipper_name'] = '';
		}
		if (isset($this->error['error_shipper_email'])) {
			$data['error_shipper_email'] = $this->error['error_shipper_email'];
		} else {
			$data['error_shipper_email'] = '';
		}
		if (isset($this->error['error_shipper_company'])) {
			$data['error_shipper_company'] = $this->error['error_shipper_company'];
		} else {
			$data['error_shipper_company'] = '';
		}
		if (isset($this->error['error_shipper_address'])) {
			$data['error_shipper_address'] = $this->error['error_shipper_address'];
		} else {
			$data['error_shipper_address'] = '';
		}
		if (isset($this->error['error_shipper_country_code'])) {
			$data['error_shipper_country_code'] = $this->error['error_shipper_country_code'];
		} else {
			$data['error_shipper_country_code'] = '';
		}
		if (isset($this->error['error_shipper_city'])) {
			$data['error_shipper_city'] = $this->error['error_shipper_city'];
		} else {
			$data['error_shipper_city'] = '';
		}
		if (isset($this->error['error_shipper_postal_code'])) {
			$data['error_shipper_postal_code'] = $this->error['error_shipper_postal_code'];
		} else {
			$data['error_shipper_postal_code'] = '';
		}
		if (isset($this->error['error_shipper_state'])) {
			$data['error_shipper_state'] = $this->error['error_shipper_state'];
		} else {
			$data['error_shipper_state'] = '';
		}
		if (isset($this->error['error_shipper_phone'])) {
			$data['error_shipper_phone'] = $this->error['error_shipper_phone'];
		} else {
			$data['error_shipper_phone'] = '';
		}
		
		############## Auto create Error #################
		if (isset($this->error['error_default_allowed_domestic_methods'])) {
			$data['error_default_allowed_domestic_methods'] = $this->error['error_default_allowed_domestic_methods'];
		} else {
			$data['error_default_allowed_domestic_methods'] = '';
		}
		
		if (isset($this->error['error_default_allowed_domestic_additional_services'])) {
			$data['error_default_allowed_domestic_additional_services'] = $this->error['error_default_allowed_domestic_additional_services'];
		} else {
			$data['error_default_allowed_domestic_additional_services'] = '';
		}
		
		if (isset($this->error['error_default_allowed_international_methods'])) {
			$data['error_default_allowed_international_methods'] = $this->error['error_default_allowed_international_methods'];
		} else {
			$data['error_default_allowed_international_methods'] = '';
		}
		
		if (isset($this->error['error_default_allowed_international_additional_services'])) {
			$data['error_default_allowed_international_additional_services'] = $this->error['error_default_allowed_international_additional_services'];
		} else {
			$data['error_default_allowed_international_additional_services'] = '';
		}
		
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/aramex', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('shipping/aramex', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		
		
		if (isset($this->request->post['aramex_email'])) {
			$data['aramex_email'] = $this->request->post['aramex_email'];
		} else {
			$data['aramex_email'] = $this->config->get('aramex_email');
		}

		if (isset($this->request->post['aramex_password'])) {
			$data['aramex_password'] = $this->request->post['aramex_password'];
		} else {
			$data['aramex_password'] = $this->config->get('aramex_password');
		}

		if (isset($this->request->post['aramex_account_pin'])) {
			$data['aramex_account_pin'] = $this->request->post['aramex_account_pin'];
		} else {
			$data['aramex_account_pin'] = $this->config->get('aramex_account_pin');
		}

		if (isset($this->request->post['aramex_account_number'])) {
			$data['aramex_account_number'] = $this->request->post['aramex_account_number'];
		} else {
			$data['aramex_account_number'] = $this->config->get('aramex_account_number');
		}

		if (isset($this->request->post['aramex_account_entity'])) {
			$data['aramex_account_entity'] = $this->request->post['aramex_account_entity'];
		} else {
			$data['aramex_account_entity'] = $this->config->get('aramex_account_entity');
		}
		
		if (isset($this->request->post['aramex_account_country_code'])) {
			$data['aramex_account_country_code'] = $this->request->post['aramex_account_country_code'];
		} else {
			$data['aramex_account_country_code'] = $this->config->get('aramex_account_country_code');
		}

		if (isset($this->request->post['aramex_test '])) {
			$data['aramex_test'] = $this->request->post['aramex_test'];
		} else {
			$data['aramex_test'] = $this->config->get('aramex_test');
		}

		if (isset($this->request->post['aramex_report_id '])) {
			$data['aramex_report_id'] = $this->request->post['aramex_report_id'];
		} else {
			$data['aramex_report_id'] = '9729';
		}
		
		if (isset($this->request->post['aramex_allowed_domestic_methods'])) {
			$data['aramex_allowed_domestic_methods'] = $this->request->post['aramex_allowed_domestic_methods'];
		} elseif ($this->config->has('aramex_allowed_domestic_methods')) {
			$data['aramex_allowed_domestic_methods'] = $this->config->get('aramex_allowed_domestic_methods');
		} else {
			$data['aramex_allowed_domestic_methods'] = array();	
		}

		$data['allowed_domestic_methods'] = $this->model_shipping_aramex->domesticmethods();
		
		

		if (isset($this->request->post['aramex_allowed_domestic_additional_services'])) {
			$data['aramex_allowed_domestic_additional_services'] = $this->request->post['aramex_allowed_domestic_additional_services'];
		} elseif ($this->config->has('aramex_allowed_domestic_additional_services')) {
			$data['aramex_allowed_domestic_additional_services'] = $this->config->get('aramex_allowed_domestic_additional_services');
		} else {
			$data['aramex_allowed_domestic_additional_services'] = array();	
		}

		$data['allowed_domestic_additional_services'] = $this->model_shipping_aramex->domesticAdditionalServices();
		
		
		
		if (isset($this->request->post['aramex_allowed_international_methods'])) {
			$data['aramex_allowed_international_methods'] = $this->request->post['aramex_allowed_international_methods'];
		} elseif ($this->config->has('aramex_allowed_international_methods')) {
			$data['aramex_allowed_international_methods'] = $this->config->get('aramex_allowed_international_methods');
		} else {
			$data['aramex_allowed_international_methods'] = array();	
		}

		$data['allowed_international_methods'] = $this->model_shipping_aramex->internationalmethods();
		
		
		if (isset($this->request->post['aramex_allowed_international_additional_services'])) {
			$data['aramex_allowed_international_additional_services'] = $this->request->post['aramex_allowed_international_additional_services'];
		} elseif ($this->config->has('aramex_allowed_international_additional_services')) {
			$data['aramex_allowed_international_additional_services'] = $this->config->get('aramex_allowed_international_additional_services');
		} else {
			$data['aramex_allowed_international_additional_services'] = array();	
		}

		$data['allowed_international_additional_services'] = $this->model_shipping_aramex->internationalAdditionalServices();

		if (isset($this->request->post['aramex_weight_class_id'])) {
			$data['aramex_weight_class_id'] = $this->request->post['aramex_weight_class_id'];
		} else {
			$data['aramex_weight_class_id'] = $this->config->get('aramex_weight_class_id');
		}
		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['aramex_tax_class_id'])) {
			$data['aramex_tax_class_id'] = $this->request->post['aramex_tax_class_id'];
		} else {
			$data['aramex_tax_class_id'] = $this->config->get('aramex_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['aramex_geo_zone_id'])) {
			$data['aramex_geo_zone_id'] = $this->request->post['aramex_geo_zone_id'];
		} else {
			$data['aramex_geo_zone_id'] = $this->config->get('aramex_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['aramex_status'])) {
			$data['aramex_status'] = $this->request->post['aramex_status'];
		} else {
			$data['aramex_status'] = $this->config->get('aramex_status');
		}	

		if (isset($this->request->post['aramex_sort_order'])) {
			$data['aramex_sort_order'] = $this->request->post['aramex_sort_order'];
		} else {
			$data['aramex_sort_order'] = $this->config->get('aramex_sort_order');
		}

		if (isset($this->request->post['aramex_default_allowed_domestic_methods'])) {
			$data['aramex_default_allowed_domestic_methods'] = $this->request->post['aramex_default_allowed_domestic_methods'];
		} else {
			$data['aramex_default_allowed_domestic_methods'] = $this->config->get('aramex_default_allowed_domestic_methods');
		}
		
		if (isset($this->request->post['aramex_default_allowed_domestic_additional_services'])) {
			$data['aramex_default_allowed_domestic_additional_services'] = $this->request->post['aramex_default_allowed_domestic_additional_services'];
		} else {
			$data['aramex_default_allowed_domestic_additional_services'] = $this->config->get('aramex_default_allowed_domestic_additional_services');
		}
		
		
		if (isset($this->request->post['aramex_default_allowed_international_methods'])) {
			$data['aramex_default_allowed_international_methods'] = $this->request->post['aramex_default_allowed_international_methods'];
		} else {
			$data['aramex_default_allowed_international_methods'] = $this->config->get('aramex_default_allowed_international_methods');
		}
		
		if (isset($this->request->post['aramex_default_allowed_international_additional_services'])) {
			$data['aramex_default_allowed_international_additional_services'] = $this->request->post['aramex_default_allowed_international_additional_services'];
		} else {
			$data['aramex_default_allowed_international_additional_services'] = $this->config->get('aramex_default_allowed_international_additional_services');
		}
		
		if (isset($this->request->post['aramex_shipper_name'])) {
			$data['aramex_shipper_name'] = $this->request->post['aramex_shipper_name'];
		} else {
			$data['aramex_shipper_name'] = $this->config->get('aramex_shipper_name');
		}
		
		if (isset($this->request->post['aramex_shipper_email'])) {
			$data['aramex_shipper_email'] = $this->request->post['aramex_shipper_email'];
		} else {
			$data['aramex_shipper_email'] = $this->config->get('aramex_shipper_email');
		}
		
		if (isset($this->request->post['aramex_shipper_company'])) {
			$data['aramex_shipper_company'] = $this->request->post['aramex_shipper_company'];
		} else {
			$data['aramex_shipper_company'] = $this->config->get('aramex_shipper_company');
		}
		
		if (isset($this->request->post['aramex_shipper_address'])) {
			$data['aramex_shipper_address'] = $this->request->post['aramex_shipper_address'];
		} else {
			$data['aramex_shipper_address'] = $this->config->get('aramex_shipper_address');
		}
		
		if (isset($this->request->post['aramex_shipper_country_code'])) {
			$data['aramex_shipper_country_code'] = $this->request->post['aramex_shipper_country_code'];
		} else {
			$data['aramex_shipper_country_code'] = $this->config->get('aramex_shipper_country_code');
		}
		
		if (isset($this->request->post['aramex_shipper_city'])) {
			$data['aramex_shipper_city'] = $this->request->post['aramex_shipper_city'];
		} else {
			$data['aramex_shipper_city'] = $this->config->get('aramex_shipper_city');
		}
		
		if (isset($this->request->post['aramex_shipper_postal_code'])) {
			$data['aramex_shipper_postal_code'] = $this->request->post['aramex_shipper_postal_code'];
		} else {
			$data['aramex_shipper_postal_code'] = $this->config->get('aramex_shipper_postal_code');
		}
		
		if (isset($this->request->post['aramex_shipper_state'])) {
			$data['aramex_shipper_state'] = $this->request->post['aramex_shipper_state'];
		} else {
			$data['aramex_shipper_state'] = $this->config->get('aramex_shipper_state');
		}
		
		if (isset($this->request->post['aramex_shipper_phone'])) {
			$data['aramex_shipper_phone'] = $this->request->post['aramex_shipper_phone'];
		} else {
			$data['aramex_shipper_phone'] = $this->config->get('aramex_shipper_phone');
		}
		
		if (isset($this->request->post['aramex_auto_create_shipment'])) {
			$data['aramex_auto_create_shipment'] = $this->request->post['aramex_auto_create_shipment'];
		} else {
			$data['aramex_auto_create_shipment'] = $this->config->get('aramex_auto_create_shipment');
		}
		
		if (isset($this->request->post['aramex_live_rate_calculation'])) {
			$data['aramex_live_rate_calculation'] = $this->request->post['aramex_live_rate_calculation'];
		} else {
			$data['aramex_live_rate_calculation'] = $this->config->get('aramex_live_rate_calculation');
		}
		
		if (isset($this->request->post['aramex_default_rate'])) {
			$data['aramex_default_rate'] = $this->request->post['aramex_default_rate'];
		} else {
			$data['aramex_default_rate'] = $this->config->get('aramex_default_rate');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/aramex.tpl', $data));

		
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'shipping/aramex')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['aramex_email']) {
			$this->error['error_email'] = $this->language->get('error_email');
		}

		if (!$this->request->post['aramex_password']) {
			$this->error['error_password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['aramex_account_pin']) {
			$this->error['error_account_pin'] = $this->language->get('error_account_pin');
		}

		if (!$this->request->post['aramex_account_number']) {
			$this->error['error_account_number'] = $this->language->get('error_account_number');
		}

		if (!$this->request->post['aramex_account_entity']) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}
		
		if (!$this->request->post['aramex_account_entity']) {
			$this->error['error_account_entity'] = $this->language->get('error_account_entity');
		}
		
		if (!$this->request->post['aramex_account_entity']) {
			$this->error['error_account_entity'] = $this->language->get('error_account_entity');
		}
		
		if (!$this->request->post['aramex_account_country_code']) {
			$this->error['error_account_country_code'] = $this->language->get('error_account_country_code');
		}
		
		
		#########   Shipper validation #############
		
		if (!$this->request->post['aramex_shipper_name']) {
			$this->error['error_shipper_name'] = $this->language->get('error_shipper_name');
		}
		if (!$this->request->post['aramex_shipper_email']) {
			$this->error['error_shipper_email'] = $this->language->get('error_shipper_email');
		}
		if (!$this->request->post['aramex_shipper_company']) {
			$this->error['error_shipper_company'] = $this->language->get('error_shipper_company');
		}
		if (!$this->request->post['aramex_shipper_address']) {
			$this->error['error_shipper_address'] = $this->language->get('error_shipper_address');
		}
		if (!$this->request->post['aramex_shipper_country_code']) {
			$this->error['error_shipper_country_code'] = $this->language->get('error_shipper_country_code');
		}
		if (!$this->request->post['aramex_shipper_city']) {
			$this->error['error_shipper_city'] = $this->language->get('error_shipper_city');
		}
		if (!$this->request->post['aramex_shipper_postal_code']) {
			$this->error['error_shipper_postal_code'] = $this->language->get('error_shipper_postal_code');
		}
		if (!$this->request->post['aramex_shipper_state']) {
			$this->error['error_shipper_state'] = $this->language->get('error_shipper_state');
		}
		if (!$this->request->post['aramex_shipper_phone']) {
			$this->error['error_shipper_phone'] = $this->language->get('error_shipper_phone');
		}
		
		if ($this->request->post['aramex_auto_create_shipment']) {
				
				
				if (!$this->request->post['aramex_default_allowed_domestic_methods']) {
					$this->error['error_default_allowed_domestic_methods'] = $this->language->get('error_default_allowed_domestic_methods');
				}
				
				if (!$this->request->post['aramex_default_allowed_domestic_additional_services']) {
					$this->error['error_default_allowed_domestic_additional_services'] = $this->language->get('error_default_allowed_domestic_additional_services');
				}
				
				
				if (!$this->request->post['aramex_default_allowed_international_methods']) {
					$this->error['error_default_allowed_international_methods'] = $this->language->get('error_default_allowed_international_methods');
				}
				
				
				if (!$this->request->post['aramex_default_allowed_international_additional_services']) {
					$this->error['error_default_allowed_international_additional_services'] = $this->language->get('error_default_allowed_international_additional_services');
				}
			
		}
		
		


		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>