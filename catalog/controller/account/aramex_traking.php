<?php
class ControllerAccountAramexTraking extends Controller {
	
	private $error = array();

	public function index() {

		$this->document->setTitle('Aramex Traking');
		$this->load->model('checkout/order');
		
		$this->getForm();
	}
	
	public function getForm() {
		$this->language->load('account/order');
		$this->load->model('checkout/order');
		$this->load->model('aramex/aramex');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		//echo "<pre>";
		//print_r($order_info);
		//echo "</pre>";
		if ($order_info) {
			
			
			$this->document->setTitle($this->language->get('heading_tracking'));
			
			############### label #############
			$data['text_back_to_order'] = $this->language->get('text_back_to_order');
			$data['text_create_sipment'] = $this->language->get('text_create_sipment');
			$data['text_rate_calculator'] = $this->language->get('text_rate_calculator');
			$data['text_schedule_pickup'] = $this->language->get('text_schedule_pickup');
			$data['text_print_label'] = $this->language->get('text_print_label');
			$data['text_track'] = $this->language->get('text_track');
			
			
			$data['heading_title'] = $this->language->get('Armex Tracking');
			
			
			$data['breadcrumbs'] = array();

		$this->document->setTitle($this->language->get('text_order'));

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),        	
				'separator' => false
			); 

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),        	
				'separator' => $this->language->get('text_separator')
			);

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', $url, 'SSL'),      	
				'separator' => $this->language->get('text_separator')
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$data['order_id'] = $this->request->get['order_id'];

	############ button ########## 
	$data['back_to_order'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
	$data['aramex_create_sipment'] = $this->url->link('sale/aramex_create_shipment', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
	$data['aramex_rate_calculator'] = $this->url->link('sale/aramex_rate_calculator', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
	$data['aramex_schedule_pickup'] = $this->url->link('sale/aramex_schedule_pickup', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
	$data['aramex_print_label'] = $this->url->link('sale/aramex_create_shipment/lable', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
	$data['aramex_traking'] = $this->url->link('sale/aramex_traking', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id , 'SSL');
						
	
	################## track shipment ###########
	
		$account=($this->config->get('aramex_account_number'))?$this->config->get('aramex_account_number'):'';	
		$response=array();
		$clientInfo = $this->model_aramex_aramex->getClientInfo();	
		if(isset($this->request->post['track_awb']))
		{
			$awb_no = $this->request->post['track_awb'];
		}else{
			$awb_no = $this->model_aramex_aramex->getAWB($order_id);
		}
		$data['awb_no'] = $awb_no;
		try {
				
		$params = array(
		'ClientInfo'  			=> $clientInfo,
								
		'Transaction' 			=> array(
									'Reference1'			=> '001' 
								),
		'Shipments'				=> array(
									$awb_no
								)
	);


	$baseUrl = $this->model_aramex_aramex->getWsdlPath();
	$soapClient = new SoapClient($baseUrl.'/Tracking.wsdl', array('trace' => 1));
	
	try{
	$results = $soapClient->TrackShipments($params);	

	if($results->HasErrors){
		if(count($results->Notifications->Notification) > 1){
			$error="";
			foreach($results->Notifications->Notification as $notify_error){
				$data['eRRORS'][] = 'Aramex: ' . $notify_error->Code .' - '. $notify_error->Message."<br>";				
			}
		}else{
				$data['eRRORS'][] = 'Aramex: ' . $results->Notifications->Notification->Code . ' - '. $results->Notifications->Notification->Message;
		}
		
	}else{

		$HAWBHistory = $results->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
		$data['html'] = $this->getTrackingInfoTable($HAWBHistory);	
		
	}
	} catch (Exception $e) {
			$response['type']='error';
			$response['error']=$e->getMessage();			
	}
	}
	catch (Exception $e) {
			$response['type']='error';
			$response['error']=$e->getMessage();			
	}
				
	
		################## create shipment end ###########
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/aramex_tracking.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/aramex_tracking.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/aramex_tracking.tpl', $data));
		}
		
		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$data['continue'] = $this->url->link('account/order', '', 'SSL');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('/template/error/not_found.tpl', $data));
		}
		
						
		}
	}
	
	function getTrackingInfoTable($HAWBHistory) {

        $_resultTable = '<table summary="Item Tracking"  class="table table-bordered table-hover">';
        $_resultTable .= '<thead><tr>
                          <td>Location</td>
                          <td>Action Date/Time</td>
                          <td class="a-right">Tracking Description</td>
                          <td class="a-center">Comments</td>
                          </tr>
                          </thead>';

        foreach ($HAWBHistory as $HAWBUpdate) {

            $_resultTable .= '<tbody><tr>
                <td>' . $HAWBUpdate->UpdateLocation . '</td>
                <td>' . $HAWBUpdate->UpdateDateTime . '</td>
                <td>' . $HAWBUpdate->UpdateDescription . '</td>
                <td>' . $HAWBUpdate->Comments . '</td>
                </tr></tbody>';
        }
        $_resultTable .= '</table>';

        return $_resultTable;
    }
	
	
}
?>