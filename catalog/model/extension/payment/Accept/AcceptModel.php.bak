<?php

trait AcceptModel
{
    /**
     * @param  $order_id
     * @param  $start
     * @param  $limit
     * @return mixed
     */
    public function getOrderHistories($order_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int) $order_id . "' AND os.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC LIMIT " . (int) $start . "," . (int) $limit);

        return $query->rows;
    }

    /**
     * @param $view
     * @param $success
     * @param $message
     */
    public function loadView($view, $message)
    {
        $data['message'] = $message;

        if ($view == 'success') {
            $data['success'] = true;

            $this->load->language('checkout/success');

            if (isset($this->session->data['order_id'])) {
                $this->cart->clear();

                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['guest']);
                unset($this->session->data['comment']);
                unset($this->session->data['order_id']);
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);
                unset($this->session->data['totals']);
            }

            $this->document->setTitle($this->language->get('heading_title'));

            $data['breadcrumbs'] = [];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home'),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_basket'),
                'href' => $this->url->link('checkout/cart'),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_checkout'),
                'href' => $this->url->link('checkout/checkout', '', true),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_success'),
                'href' => $this->url->link('checkout/success'),
            ];

            if ($this->customer->isLogged()) {
                $data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));
            } else {
                $data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
            }

            $data['continue'] = $this->url->link('common/home');

            $data['column_left']    = $this->load->controller('common/column_left');
            $data['column_right']   = $this->load->controller('common/column_right');
            $data['content_top']    = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer']         = $this->load->controller('common/footer');
            $data['header']         = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('extension/payment/accept_checkout', $data));
        }

        if ($view == 'error') {
            $data['error'] = true;

            $this->load->language('checkout/failure');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['breadcrumbs'] = [];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home'),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_basket'),
                'href' => $this->url->link('checkout/cart'),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_checkout'),
                'href' => $this->url->link('checkout/checkout', '', true),
            ];

            $data['breadcrumbs'][] = [
                'text' => $this->language->get('text_failure'),
                'href' => $this->url->link('checkout/failure'),
            ];

            $data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));

            $data['continue'] = $this->url->link('common/home');

            $data['column_left']    = $this->load->controller('common/column_left');
            $data['column_right']   = $this->load->controller('common/column_right');
            $data['content_top']    = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer']         = $this->load->controller('common/footer');
            $data['header']         = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('extension/payment/accept_checkout', $data));
        }

        return $this->response->getOutput();
    }

    /**
     * @param $cause
     * @param $object
     * @param $canDebug
     * @param $payload
     */
    public function parseDeath($cause, $object, $canDebug = '0', $payload = null)
    {
        echo '<br><hr>';
        echo $cause;
        echo '<br><hr>';
        echo '<code>' . json_encode($object) . '</code>';
        if ($canDebug == '1' && $payload) {
            foreach ($payload as $key => $value) {
                echo '<br><hr>' . $key;
                var_dump($value);

            }
        }
        die();
    }

    /**
     * @param $order
     */
    public function parseOrder($order)
    {
        $data = [];

        $data['shipping_data'] = [
            'first_name'      => $order['shipping_firstname'],
            'last_name'       => $order['shipping_lastname'],
            'email'           => $order['email'],
            'street'          => $order['shipping_address_1'] . ' - ' . $order['shipping_address_2'],
            'phone_number'    => $order['telephone'],
            'city'            => $order['shipping_city'],
            'country'         => $order['shipping_country'],
            'state'           => $order['shipping_zone'],
            'postal_code'     => ($order['shipping_postcode']) ? $order['shipping_postcode'] : 'NA',
            'apartment'       => 'NA',
            'floor'           => 'NA',
            'building'        => 'NA',
            'shipping_method' => 'UNK',
        ];

        $data['billing_data'] = [
            'first_name'      => $order['payment_firstname'],
            'last_name'       => $order['payment_lastname'],
            'email'           => $order['email'],
            'street'          => $order['payment_address_1'] . ' - ' . $order['payment_address_2'],
            'phone_number'    => $order['telephone'],
            'city'            => $order['payment_city'],
            'country'         => $order['payment_country'],
            'state'           => $order['payment_zone'],
            'postal_code'     => ($order['payment_postcode']) ? $order['payment_postcode'] : 'NA',
            'apartment'       => 'NA',
            'floor'           => 'NA',
            'building'        => 'NA',
            'shipping_method' => 'PKG',
        ];

        return $data;
    }

    /**
     * @param  $api_key
     * @return mixed
     */
    public function requestToken($api_key)
    {
        $data = [
            'api_key' => $api_key,
        ];

        $request = $this->HttpPost('auth/tokens', $data);

        return $request;
    }

    /**
     * @param  $delivery_needed
     * @param  $merchant_id
     * @param  $amount_cents
     * @param  $currency
     * @param  $merchant_order_id
     * @param  $items
     * @param  $shipping_data
     * @return mixed
     */
    public function createOrder($auth, $delivery_needed, $merchant_id, $amount_cents, $currency, $merchant_order_id, $items, $shipping_data)
    {
        $data = [
            'delivery_needed'   => $delivery_needed,
            'merchant_id'       => $merchant_id,
            'amount_cents'      => $amount_cents * 100,
            'currency'          => $currency,
            'merchant_order_id' => $merchant_order_id,
            'items'             => $items,
            'shipping_data'     => $shipping_data,
        ];

        $order = $this->HttpPost('ecommerce/orders', $data, $auth);

        return $order;
    }

    /**
     * @param  $order_id
     * @return mixed
     */
    public function createPaymentKey($auth, $amount_cents, $order_id, $billing_data, $currency, $integration_id, $token = null)
    {
        $data = [
            'amount_cents'   => $amount_cents * 100,
            'expiration'     => 36000,
            'order_id'       => $order_id,
            'billing_data'   => $billing_data,
            'currency'       => $currency,
            'integration_id' => $integration_id,
        ];

        if ($token) {
            $data['token'] = $token;
        }

        $payment = $this->HttpPost('acceptance/payment_keys', $data, $auth);

        return $payment;
    }

    /**
     * @param  $billing
     * @param  $payment_token
     * @return mixed
     */
    public function requestKioskId($auth, $billing, $payment_token)
    {
        $data = ['source' => ['identifier' => 'AGGREGATOR', 'subtype' => 'AGGREGATOR'],
            'billing'         => $billing,
            'payment_token'   => $payment_token,
        ];

        $kiosk = $this->HttpPost('acceptance/payments/pay', $data, $auth);

        return $kiosk;
    }

    /**
     * @param  $url_path
     * @param  array       $data
     * @return mixed
     */
    private function HttpPost($url_path, $data = [], $auth = null)
    {
        $ch      = curl_init();
        $target  = 'https://accept.paymobsolutions.com/api/' . $url_path;
        $options = [
            CURLOPT_URL            => $target,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', "Authorization: Bearer $auth"],
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
        ];

        curl_setopt_array($ch, $options);
        $response           = curl_exec($ch);
        $response_json_data = json_decode($response, true);
        $errors             = curl_error($ch);
        curl_close($ch);

        if ($response_json_data) {
            return $response_json_data;
        }

        return $errors;
    }

    /**
     * @param  $key
     * @param  $data
     * @param  $type
     * @return mixed
     */
    public static function calculateHash($key, $data, $type)
    {
        $str = '';
        switch ($type) {
            case 'TRANSACTION':
                $str =
                    $data['amount_cents'] .
                    $data['created_at'] .
                    $data['currency'] .
                    $data['error_occured'] .
                    $data['has_parent_transaction'] .
                    $data['id'] .
                    $data['integration_id'] .
                    $data['is_3d_secure'] .
                    $data['is_auth'] .
                    $data['is_capture'] .
                    $data['is_refunded'] .
                    $data['is_standalone_payment'] .
                    $data['is_voided'] .
                    $data['order'] .
                    $data['owner'] .
                    $data['pending'] .
                    $data['source_data_pan'] .
                    $data['source_data_sub_type'] .
                    $data['source_data_type'] .
                    $data['success'];
                break;
            case 'TOKEN':
                $str =
                    $data['card_subtype'] .
                    $data['created_at'] .
                    $data['email'] .
                    $data['id'] .
                    $data['masked_pan'] .
                    $data['merchant_id'] .
                    $data['order_id'] .
                    $data['token'];
                break;
            case 'DELIVERY_STATUS':
                $str =
                    $data['created_at'] .
                    $data['extra_description'] .
                    $data['gps_lat'] .
                    $data['gps_long'] .
                    $data['id'] .
                    $data['merchant'] .
                    $data['order'] .
                    $data['status'];
                break;
        }
        $hash = hash_hmac('sha512', $str, $key);

        return $hash;
    }
}
