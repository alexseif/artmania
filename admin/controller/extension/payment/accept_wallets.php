<?php
if (!trait_exists('AcceptController', false)) {
    include_once 'Accept/AcceptController.php';
}

class ControllerExtensionPaymentAcceptWallets extends Controller
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
    protected $gateway = 'Wallets';
    /**
     * Gateway name for system
     * @var string
     */
    protected $gateway_file = 'accept_wallets';
    /**
     * Gateway fields
     * @var array
     */
    protected $fields = [
        'payment_accept_wallets_api',
        'payment_accept_wallets_hmac',
        'payment_accept_wallets_int',
        'payment_accept_wallets_status',
        'payment_accept_wallets_method_name',
        'payment_accept_wallets_sort_order',
        'payment_accept_wallets_allow_debug',
    ];
}
