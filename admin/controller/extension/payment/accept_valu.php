<?php
if (!trait_exists('AcceptController', false)) {
    include_once 'Accept/AcceptController.php';
}

class ControllerExtensionPaymentAcceptValu extends Controller
{
    /**
     * @var array
     */
    private $error = [];

    use AcceptController;

    /**
     * Gateway name for humans
     * @var string
     */
    protected $gateway = 'valU';
    /**
     * Gateway name for system
     * @var string
     */
    protected $gateway_file = 'accept_valu';
    /**
     * Gateway fields
     * @var array
     */
    protected $fields = [
        'payment_accept_valu_api',
        'payment_accept_valu_hmac',
        'payment_accept_valu_int',
        'payment_accept_valu_status',
        'payment_accept_valu_method_name',
        'payment_accept_valu_sort_order',
        'payment_accept_valu_iframe',
        'payment_accept_valu_iframe_css',
        'payment_accept_valu_allow_debug',
    ];
}
