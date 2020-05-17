<?php
class ControllerExtensionPaymentAcceptValu extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        // store order ; 1 = pending
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 1);

        // Load helpers
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/accept_valu');
        $helper = $this->model_extension_payment_accept_valu;

        $debug              = $this->config->get('payment_accept_valu_allow_debug');
        $order              = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $acceptToken        = $helper->requestToken($this->config->get('payment_accept_valu_api'));
        $integration_id     = $this->config->get('payment_accept_valu_int');
        $merchant_id        = $this->config->get('payment_accept_valu_merchant');
        $iframe_id          = $this->config->get('payment_accept_valu_iframe');
        $data['iframe_css'] = $this->config->get('payment_accept_valu_iframe_css');
        $order_data         = $helper->parseOrder($order);

        if (!isset($acceptToken['token'])) {
            $helper->parseDeath('Failed to obtain a login token, is your API KEY correct?', $acceptToken);
        }

        $items            = $this->model_checkout_order->getOrderProducts($order['order_id']);
        $acceptOrderItems = [];
        $orderPrice       = 0;

        foreach ($items as $item) {
            $acceptOrderItems[] = [
                'name'         => $item['name'],
                'quantity'     => $item['quantity'],
                'amount_cents' => $item['total'],
            ];

            $orderPrice += $item['total'] + $item['tax'];
        }

        $acceptOrderPayload = [
            'merchant_id'         => $merchant_id,
            'order_amount_cents'  => $order['total'],
            'order_currency'      => $order['currency_code'],
            'merchant_order_id'   => $order['order_id'] . '_' . time(),
            'order_shipping_data' => $order_data['shipping_data'],
            'items'               => $acceptOrderItems,
        ];

        $acceptOrder = $helper->createOrder(
            $acceptToken['token'],
            false,
            $merchant_id,
            $order['total'],
            $order['currency_code'],
            $order['order_id'] . '_' . time(),
            $acceptOrderItems, // Items
            $order_data['shipping_data']
        );

        if (!isset($acceptOrder['id'])) {
            $helper->parseDeath('Failed to create an order', $acceptOrder, $debug, $acceptOrderPayload);
        }

        $acceptPaymentPayload = [
            'order_amount_cents' => $order['total'],
            'accept_order_id'    => $acceptOrder['id'],
            'order_billing_data' => $order_data['billing_data'],
            'order_currency'     => $order['currency_code'],
            'integration_id'     => $integration_id,
        ];

        $acceptPayment = $helper->createPaymentKey(
            $acceptToken['token'],
            $order['total'],
            $acceptOrder['id'],
            $order_data['billing_data'],
            $order['currency_code'],
            $integration_id
        );

        if (!isset($acceptPayment['token'])) {
            $helper->parseDeath('Failed to create a payment token', $acceptPayment, $debug, $acceptPaymentPayload);
        }

        $data['url'] = 'https://accept.paymobsolutions.com/api/acceptance/iframes/' . $iframe_id . '?payment_token=' . $acceptPayment['token'];

        return $this->load->view('extension/payment/accept_valu', $data);
    }

    /**
     * @return mixed
     */
    public function callback()
    {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/accept_valu');
        $helper = $this->model_extension_payment_accept_valu;

        $hmac = $this->config->get('payment_accept_valu_hmac');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = json_decode(file_get_contents('php://input'), true);
            $type = $json['type'];
            $data = $json['obj'];
            $obj  = $json['obj'];
            if ($type === 'TRANSACTION') {
                $data['order']                  = $data['order']['id'];
                $data['is_3d_secure']           = ($data['is_3d_secure'] === true) ? 'true' : 'false';
                $data['is_auth']                = ($data['is_auth'] === true) ? 'true' : 'false';
                $data['is_capture']             = ($data['is_capture'] === true) ? 'true' : 'false';
                $data['is_refunded']            = ($data['is_refunded'] === true) ? 'true' : 'false';
                $data['is_standalone_payment']  = ($data['is_standalone_payment'] === true) ? 'true' : 'false';
                $data['is_voided']              = ($data['is_voided'] === true) ? 'true' : 'false';
                $data['success']                = ($data['success'] === true) ? 'true' : 'false';
                $data['error_occured']          = ($data['error_occured'] === true) ? 'true' : 'false';
                $data['has_parent_transaction'] = ($data['has_parent_transaction'] === true) ? 'true' : 'false';
                $data['pending']                = ($data['pending'] === true) ? 'true' : 'false';
                $data['source_data_pan']        = $data['source_data']['pan'];
                $data['source_data_type']       = $data['source_data']['type'];
                $data['source_data_sub_type']   = $data['source_data']['sub_type'];
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $obj  = $_REQUEST;
            $data = $_GET;
            $type = 'TRANSACTION';
        } else {
            die('METHOD "' . $_SERVER['REQUEST_METHOD'] . '" NOT ALLOWED');
        }

        $hash        = $helper->calculateHash($hmac, $data, $type);
        $orderHelper = $this->model_checkout_order;

        // auth?
        if ($hash === $_REQUEST['hmac']) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($type == 'TRANSACTION') {
                    $order_id = substr($obj['order']['merchant_order_id'], 0, -11);
                    if (
                        $obj['success'] === true &&
                        $obj['is_voided'] === false &&
                        $obj['is_refunded'] === false &&
                        $obj['pending'] === false &&
                        $obj['is_void'] === false &&
                        $obj['is_refund'] === false &&
                        $obj['error_occured'] === false
                    ) {
                        foreach ($helper->getOrderHistories($order_id, 0, 100) as $history) {
                            if ($history['comment'] === 'Payment Sucessfull.') {
                                die("Order already updated: $order_id");
                            }
                        }

                        $orderHelper->addOrderHistory($order_id, 5, 'Payment Sucessfull.');

                        if (isset($obj['data']['receipt_url'])) {
                            $orderHelper->addOrderHistory($order_id, 5, '<a href="' . $obj['data']['receipt_url'] . '" target="_blank">Receipt Link</a>');
                        }

                        if (isset($obj['data']['down_payment']) && isset($obj['data']['currency'])) {
                            $orderHelper->addOrderHistory($order_id, 5, 'Down payment: ' . $obj['data']['down_payment'] . ' ' . $obj['data']['currency']);
                        }
                    } elseif (
                        $obj['success'] === true &&
                        $obj['is_refunded'] === true &&
                        $obj['is_voided'] === false &&
                        $obj['pending'] === false &&
                        $obj['is_void'] === false &&
                        $obj['is_refund'] === false
                    ) {
                        foreach ($helper->getOrderHistories($order_id, 0, 100) as $history) {
                            if ($history['comment'] === 'Payment Refunded.') {
                                die("Order already updated: $order_id");
                            }
                        }

                        $orderHelper->addOrderHistory($order_id, 11, 'Payment Refunded.');
                    } elseif (
                        $obj['success'] === true &&
                        $obj['is_voided'] === true &&
                        $obj['is_refunded'] === false &&
                        $obj['pending'] === false &&
                        $obj['is_void'] === false &&
                        $obj['is_refund'] === false
                    ) {
                        foreach ($helper->getOrderHistories($order_id, 0, 100) as $history) {
                            if ($history['comment'] === 'Payment Voided.') {
                                die("Order already updated: $order_id");
                            }
                        }

                        $orderHelper->addOrderHistory($order_id, 16, 'Payment Voided.');
                    } elseif (
                        $obj['success'] === false &&
                        $obj['is_voided'] === false &&
                        $obj['is_refunded'] === false &&
                        $obj['is_void'] === false &&
                        $obj['is_refund'] === false
                    ) {
                        $orderHelper->addOrderHistory($order_id, 1, 'Payment Pending.');
                    }

                    die("Order updated: $order_id");

                }
            } else {
                if (
                    $obj['success'] === 'true' &&
                    $obj['is_voided'] === 'false' &&
                    $obj['is_refunded'] === 'false' &&
                    $obj['pending'] === 'false' &&
                    $obj['is_void'] === 'false' &&
                    $obj['is_refund'] === 'false' &&
                    $obj['error_occured'] === 'false'
                ) {
                    return $helper->loadView('success', $obj['data_message']);
                } else {
                    return $helper->loadView('error', $obj['data_message']);
                }
            }
        } else {
            die('HMAC Failed to validate.');
        }

        // leave.
        exit();
    }
}
