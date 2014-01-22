<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Configuration options
$config['stripe_key_test_public']         = 'pk_test_MNh0esQ9dTBTuDgrTofTtFI1';
$config['stripe_key_test_secret']         = 'sk_test_0p5CpeHmb5kdgsZhLlDdyWcy';
$config['stripe_key_live_public']         = 'pk_live_0J6G6xt5w5Lb3TOigI88WMO5';
$config['stripe_key_live_secret']         = 'sk_live_xrO0g9KmeIVyntD1kNBn1EvK';
$config['stripe_test_mode']               = TRUE;
$config['stripe_verify_ssl']              = FALSE;

// Create the library object
$stripe = new Stripe( $config );

/* End of file stripe.php */
/* Location: ./application/config/stripe.php */