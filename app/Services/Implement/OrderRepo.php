<?php

namespace App\Services\Implement;

use App\Services\Interfaces\CartInterface;
use Darryldecode\Cart\Cart;
use GuzzleHttp\Client;
use Protechstudio\PrestashopWebService\PrestashopWebService;
use Protechstudio\PrestashopWebService\PrestaShopWebserviceException;
use App\Services\Interfaces\OrderInterface;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Http\Client\Request;

class OrderRepo implements OrderInterface
{
    protected $url;
    protected $http;
    protected $headers;
    private $prestashop;
    private ProductInterface $productInterface;

    public function __construct(Client $client, PrestashopWebService $prestashop, ProductInterface $productInterface)
    {
        $this->url = config('constants.apiUrl');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
        $this->productInterface = $productInterface;
        $this->prestashop = $prestashop;
    }

    public function createOrder($order)
    {

        // $blankXml = $webService->get(['url' => 'https://manorigen.cl/backend/api/order?schema=blank']);
        try {

            $webService = new PrestaShopWebservice($this->url, config('constants.apiKey'), true);

            $xml = $webService->get(array('url' => $this->url . '/api/customers/?schema=synopsis'));
            $customer = array();
            $product = array();

            // if (!empty(Tools::getValue('c_email')))
            //     $customer['email'] = Tools::getValue('c_email');
            // else
            //     $customer['email'] = 'admin@yoursite.com';


            $customer['id'] = 0;
            $customer['id_default_group'] = '3';
            $customer['id_lang'] = '1';
            $customer['newsletter_date_add'] = '2013-12-13 08:19:15';
            $customer['ip_registration_newsletter'] = '';
            $customer['last_passwd_gen'] = '2022-09-23 11:33:22';
            $customer['secure_key'] = md5(uniqid(rand(), true));
            $customer['deleted'] = '0';
            $customer['passwd'] = '';
            $customer['firstname'] = 'Manu';
            $customer['lastname'] = 'Guti';
            $customer['email'] = 'admin10@yoursite.com';
            $customer['id_gender'] = '1';
            $customer['birthday'] = '1980-01-15';
            $customer['newsletter'] = '1';
            $customer['optin'] = '1';
            $customer['website'] = '';
            $customer['company'] = '';
            $customer['siret'] = '';
            $customer['ape'] = '';
            $customer['outstanding_allow_amount'] = '0';
            $customer['show_public_prices'] = '0';
            $customer['id_risk'] = '0';
            $customer['max_payment_days'] = '0';
            $customer['active'] = '1';
            $customer['note'] = '';
            $customer['is_guest'] = '0';
            $customer['id_shop'] = '1';
            $customer['active'] = '1';
            $customer['id_shop_group'] = '1';
            $customer['date_add'] = '2022-09-23 16:33:22';
            $customer['reset_password_token'] = '';
            $customer['reset_password_validity'] = '0000-00-00 00:00:00';

            $id['country'] = '165';
            $id['lang'] = '1';
            $id['currency'] = '1';
            $id['carrier'] = '2';
            $id['guest'] = '1';

            $product['quantity'] = '1';
            $product['id'] = 1; // idProduct
            $product['price'] = '111'; //Product::getPriceStatic($product['id']);
            $product['name'] = 'Name test'; //Product::getProductName($product['id']);
            $product['total'] = '100'; // $product['price'] * $product['quantity'];

            $xml->customer->id_default_group = '3';
            $xml->customer->id_lang = '1';
            $xml->customer->newsletter_date_add = '2013-12-13 08:19:15';
            $xml->customer->ip_registration_newsletter = '';
            $xml->customer->last_passwd_gen = '2022-09-23 11:33:22';
            $xml->customer->deleted = '0';
            $xml->customer->passwd = '123';
            $xml->customer->firstname = 'Manu';
            $xml->customer->lastname = 'Guti';
            $xml->customer->email = 'admi71@yoursite.com';
            $xml->customer->id_gender = '1';
            $xml->customer->birthday = '1980-01-15';
            $xml->customer->newsletter = '1';
            $xml->customer->optin = '1';
            $xml->customer->website = '';
            $xml->customer->company = '';
            $xml->customer->siret = '';
            $xml->customer->ape = '';
            $xml->customer->outstanding_allow_amount = '0';
            $xml->customer->show_public_prices = '0';
            $xml->customer->id_risk = '0';
            $xml->customer->max_payment_days = '0';
            $xml->customer->secure_key = md5(uniqid(rand(), true));
            $xml->customer->active = '1';
            $xml->customer->note = '';
            $xml->customer->is_guest = '0';
            $xml->customer->id_shop = '1';
            $xml->customer->id_shop_group = '1';
            $xml->customer->date_add = date('Y-m-d H:i:s');
            $xml->customer->date_upd = '2022-09-28 19:33:22';
            $xml->customer->reset_password_token = '';
            $xml->customer->reset_password_validity = '0000-00-00 00:00:00';


            $opt = array('resource' => 'customers');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            return $e->getMessage();
        }

        // ID of created customer
        $id['customer'] = $xml->customer->id;
        $id['secure_key'] = $xml->customer->secure_key;

        try {
            // CREATE Address
            $xml = $webService->get(array('url' => $this->url . '/api/addresses/?schema=synopsis'));

            $xml->address->id_customer = $id['customer'];
            $xml->address->firstname = $customer['firstname'];
            $xml->address->lastname = $customer['lastname'];
            $xml->address->address1 = 'Calle 2';
            $xml->address->city = 'Concepcion';
            $xml->address->phone_mobile = '321321546';
            $xml->address->postcode = '4030555';
            $xml->address->id_country = '68';
            $xml->address->alias = 'Address User Admin';

            $opt = array('resource' => 'addresses');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            return $e->getMessage();
        }

        // ID of created address
        $id['address'] = $xml->address->id;

        try {
            // CREATE Cart
            $xml = $webService->get(array('url' => $this->url . '/api/carts?schema=blank'));
            $xml->cart->id_customer = $id['customer'];
            $xml->cart->secure_key = $id['secure_key'];
            $xml->cart->id_address_delivery = $id['address'];
            $xml->cart->id_address_invoice = $id['address'];
            $xml->cart->id_currency = $id['currency'];
            $xml->cart->id_lang = $id['lang'];
            $xml->cart->id_carrier = $id['carrier'];
            $xml->cart->id_guest = $id['guest'];
            $xml->cart->id_shop_group = '1';
            $xml->cart->id_shop = '1';
            $xml->cart->date_add = date('Y-m-d H:i:s');
            $xml->cart->associations->cart_rows->cart_row->id_product = '1'; // $product['id'];
            $xml->cart->associations->cart_rows->cart_row->quantity = '1'; //$product['quantity'];
            $xml->cart->associations->cart_rows->cart_row->id_product_attribute = '1'; //$product['quantity'];

            // if (!empty(Tools::getValue('product_attr')))
            //     $xml->cart->associations->cart_rows->cart_row->id_product_attribute = Tools::getValue('product_attr');

            $opt = array('resource' => 'carts');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            return $e->getMessage();
        }

        // ID of created cart
        $id['cart'] = $xml->cart->id;

        try {
            // CREATE Order
            $xml = $webService->get(array('url' => $this->url . '/api/orders?schema=blank'));
         
            $xml->order->id_address_delivery = $id['address'];
            $xml->order->id_address_invoice = $id['address'];
            $xml->order->id_cart = $id['cart'];
            $xml->order->id_currency = $id['currency'];
            $xml->order->id_lang =  $id['lang'];
            $xml->order->id_customer = $id['customer'];
            $xml->order->id_carrier = $id['carrier'];
            $xml->order->current_state = 6;
            $xml->order->module = 'ps_checkpayment';
            $xml->order->invoice_number = 0;
            $xml->order->invoice_date = '0000-00-00 00:00:00';
            $xml->order->delivery_number = 0;
            $xml->order->delivery_date = '0000-00-00 00:00:00';
            $xml->order->valid = 0;
            $xml->order->date_add = date('Y-m-d H:i:s');
            $xml->order->date_upd = date('Y-m-d H:i:s');
            // $xml->order->shipping_number = '';
            $xml->order->note = 'esto es una orden de prueba';
            $xml->order->id_shop_group = 1;
            $xml->order->id_shop = 1;
            $xml->order->secure_key = $id['secure_key'];
            $xml->order->payment = 'Payment by check';
            $xml->order->recyclable = 0;
            $xml->order->gift = 0;
            //$xml->order->gift_message = '';
            $xml->order->mobile_theme = 0;
            $xml->order->total_discounts = 0;
            $xml->order->total_discounts_tax_incl = 0;
            $xml->order->total_discounts_tax_excl = 0;
            $xml->order->total_paid = 1300;
            $xml->order->total_paid_tax_incl = 1300;
            $xml->order->total_paid_tax_excl = 1300;
            $xml->order->total_paid_real = 0;
            $xml->order->total_products = 1300;
            $xml->order->total_products_wt = 1300;
            $xml->order->total_shipping = 100;
            $xml->order->total_shipping_tax_incl = 100;
            $xml->order->total_shipping_tax_excl = 100;
            $xml->order->carrier_tax_rate = 0;
            $xml->order->total_wrapping = 0;
            $xml->order->total_wrapping_tax_incl = 0;
            $xml->order->total_wrapping_tax_excl = 0;
            $xml->order->round_mode = 0;
            $xml->order->round_type = 0;
            $xml->order->conversion_rate = 1;

            // $xml->order->associations->order_rows->order_row->id = '1';
            $xml->order->associations->order_rows->order_row->product_id = 1;
            $xml->order->associations->order_rows->order_row->product_attribute_id = 1;
            $xml->order->associations->order_rows->order_row->product_quantity = 1;
            $xml->order->associations->order_rows->order_row->product_name = 'Hummingbird printed t-shirt';
            // $xml->order->associations->order_rows->order_row->product_reference = 'demo_1';
            // $xml->order->associations->order_rows->order_row->product_ean13 = '';
            // $xml->order->associations->order_rows->order_row->product_isbn = '';
            // $xml->order->associations->order_rows->order_row->product_upc = '';
            // $xml->order->associations->order_rows->order_row->product_price = '23.900000';
            // $xml->order->associations->order_rows->order_row->id_customization = '0';
            // $xml->order->associations->order_rows->order_row->unit_price_tax_incl = '23.900000';
            // $xml->order->associations->order_rows->order_row->unit_price_tax_excl = '23.900000';

            $opt = array('resource' => 'orders');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);

            $id['order'] = $xml->order->id;
            $id['secure_key'] = $xml->order->secure_key;

            $xml = $webService->get(array('url' => $this->url . '/api/order_histories?schema=blank'));
            $xml->order_history->id_order = $id['order'];
            $xml->order_history->id_order_state = '3';

            $opt = array('resource' => 'order_histories');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
            }catch (PrestaShopWebserviceException $e) {
                // Here we are dealing with errors
                 
                $trace = $e->getTrace();
                 
                if ($trace[0]['args'][0] == 404) echo 'Bad ID';
                 
                else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
                 
                else echo 'Other error<br />'.$e->getMessage();
                 
            }



        // $full_path = $this->url . 'products?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        // $response = $this->http->get($full_path, [
        //     'headers'         => $this->headers,
        //     'timeout'         => 30,
        //     'connect_timeout' => 30,
        //     'http_errors'     => true,
        // ]);
        // return json_decode($response->getBody(), true);
    }

    public function updateOrder($order)
    {
        $full_path = $this->url . 'products?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => 30,
            'http_errors'     => true,
        ]);
        return json_decode($response->getBody(), true);
    }
}