<?php
if (!trait_exists('AcceptModel', false)) {
    include_once 'Accept/AcceptModel.php';
}

class ModelExtensionPaymentAcceptWallets extends Model
{

    use AcceptModel;

    /**
     * @param  $address
     * @param  $total
     * @return mixed
     */
    public function getMethod($address, $total)
    {
        $method_data = [
            'code'       => 'accept_wallets',
            'title'      => ($this->config->get('payment_accept_wallets_method_name')) ? $this->config->get('payment_accept_wallets_method_name') : 'Mobile Wallets',
            'terms'      => '',
            'sort_order' => $this->config->get('payment_accept_wallets_sort_order'),
        ];

        return $method_data;
    }
}
