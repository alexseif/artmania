<?php
if (!trait_exists('AcceptModel', false)) {
    include_once 'Accept/AcceptModel.php';
}

class ModelExtensionPaymentAcceptValu extends Model
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
            'code'       => 'accept_valu',
            'title'      => ($this->config->get('payment_accept_valu_method_name')) ? $this->config->get('payment_accept_valu_method_name') : 'valU',
            'terms'      => '',
            'sort_order' => $this->config->get('payment_accept_valu_sort_order'),
        ];

        return $method_data;
    }
}
