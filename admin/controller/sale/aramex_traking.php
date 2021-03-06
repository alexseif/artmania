<?php
class ControllerSaleAramexTraking extends Controller {
	
	private $error = array();

	public function index() {

		$this->language->load('sale/aramex');
		$this->document->setTitle($this->language->get('heading_tracking'));
		$this->load->model('sale/order');
		
		$this->getForm();
	}
	
	public function getForm() {
		
		$this->load->model('sale/order');
		$this->load->model('sale/aramex');
		$this->load->model('shipping/aramex');
		$this->document->addScript('view/javascript/jquery.chained.js');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		
		$order_info = $this->model_sale_order->getOrder($order_id);
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
			
			
			$data['heading_title'] = $this->language->get('heading_tracking');
			
			
			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title_rate'),
				'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
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
		$clientInfo = $this->model_sale_aramex->getClientInfo();	
		if(isset($this->request->post['track_awb']))
		{
			$awb_no = $this->request->post['track_awb'];
		}else{
			$awb_no = $this->model_sale_aramex->getAWB($order_id);
		}
		
		$this->data['awb_no'] = $awb_no;
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


	$baseUrl = $this->model_sale_aramex->getWsdlPath();
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
		
		
			$data['is_shipment'] = $this->model_sale_aramex->checkAWB($this->request->get['order_id']);
		
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('sale/aramex_tracking.tpl', $data));

		} else {
			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));

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