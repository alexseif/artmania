<?php
if (!trait_exists('AcceptController', false)) {
    include_once 'Accept/AcceptController.php';
}

class ControllerExtensionPaymentAcceptAman extends Controller
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
    protected $gateway = 'Aman';
    /**
     * Gateway name for system
     * @var string
     */
    protected $gateway_file = 'accept_aman';
    /**
     * Gateway fields
     * @var array
     */
    protected $fields = [
        'payment_accept_aman_api',
        'payment_accept_aman_hmac',
        'payment_accept_aman_int',
        'payment_accept_aman_status',
        'payment_accept_aman_method_name',
        'payment_accept_aman_sort_order',
        'payment_accept_aman_allow_debug',
    ];
}
