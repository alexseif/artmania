<?php
/**
 * Shared functions, fields between all gateways
 */
trait AcceptController
{
    public function index()
    {
        $this->document->setTitle("Accept Payments ($this->gateway)");
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', "extension/payment/$this->gateway_file")) {
            $this->model_setting_setting->editSetting("payment_$this->gateway_file", $this->request->post);

            $this->session->data['success'] = "Success: you updated your Accept Payments ($this->gateway) settings.";

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        foreach ($this->fields as $field) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } else {
                $data[$field] = $this->config->get($field);
            }
        }

        $this->load->model('localisation/order_status');
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        $data['action']      = $this->url->link(
            "extension/payment/$this->gateway_file",
            'user_token=' . $this->session->data['user_token'],
            true
        );
        $data['cancel'] = $this->url->link(
            'marketplace/extension',
            'user_token=' . $this->session->data['user_token'] . '&type=payment',
            true);
        $data['callback'] = HTTP_CATALOG . "index.php?route=extension/payment/$this->gateway_file/callback";

        $this->response->setOutput($this->load->view("extension/payment/$this->gateway_file", $data));
    }
}
