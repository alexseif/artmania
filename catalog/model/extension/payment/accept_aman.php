<?php
if (!trait_exists('AcceptModel', false)) {
    include_once 'Accept/AcceptModel.php';
}

class ModelExtensionPaymentAcceptAman extends Model
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
            'code'       => 'accept_aman',
            'title'      => ($this->config->get('payment_accept_aman_method_name')) ? $this->config->get('payment_accept_aman_method_name') : 'Aman',
            'terms'      => '',
            'sort_order' => $this->config->get('payment_accept_aman_sort_order'),
        ];

        return $method_data;
    }
}
