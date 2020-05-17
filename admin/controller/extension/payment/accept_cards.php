<?php
if (!trait_exists('AcceptController', false)) {
    include_once 'Accept/AcceptController.php';
}

class ControllerExtensionPaymentAcceptCards extends Controller
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
    protected $gateway = 'Cards';
    /**
     * Gateway name for system
     * @var string
     */
    protected $gateway_file = 'accept_cards';
    /**
     * Gateway fields
     * @var array
     */
    protected $fields = [
        'payment_accept_cards_api',
        'payment_accept_cards_hmac',
        'payment_accept_cards_int',
        'payment_accept_cards_status',
        'payment_accept_cards_method_name',
        'payment_accept_cards_sort_order',
        'payment_accept_cards_iframe',
        'payment_accept_cards_iframe_css',
        'payment_accept_cards_allow_debug',
    ];

    /**
     * Install tokens card into the database.
     *
     * @return void
     */
    public function install()
    {
        $this->db->query('
			CREATE TABLE `' . DB_PREFIX . "accept_cards_tokens` (
				`id`  INT(11) NOT NULL AUTO_INCREMENT,
				`customer_id` BIGINT(20) NOT NULL,
				`card_subtype` VARCHAR(56) DEFAULT '' NOT NULL,
				`token` VARCHAR(56) DEFAULT '' NOT NULL,
				`masked_pan` VARCHAR(19) DEFAULT '' NOT NULL,
				KEY `customer_id` (`customer_id`),
				PRIMARY KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
    }

    /**
     * Uninstall tokens card from the database.
     *
     * @return void
     */
    public function uninstall()
    {
        $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'accept_cards_tokens`;');
    }
}
