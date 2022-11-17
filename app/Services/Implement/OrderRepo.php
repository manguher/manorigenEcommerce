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
        $cart = \Cart::getContent();

        $input = $order->all();
        $firstName = $input['firstName'];
        $lastname = $input['lastname'];
        $email = $input['email'];
        $phone = $input['phone'];
        $company = $input['company'];
        $state = $input['state'];
        $address1 = $input['address1'];
        $address2 = $input['address2'];
        $city = $input['cities'];
        $total = $input['total'];

        try {

            $webService = new PrestaShopWebservice($this->url, config('constants.apiKey'), false);
            $xml = $webService->get(array('url' => $this->url . '/api/customers/?schema=synopsis'));
            $customer = array();
            $product = array();

            // if (!empty(Tools::getValue('c_email')))
            //     $customer['email'] = Tools::getValue('c_email');
            // else
            //     $customer['email'] = 'admin@yoursite.com';

            $id['country'] = '165'; // chile
            $id['lang'] = '1';
            $id['currency'] = '1';
            $id['carrier'] = '2';
            $id['guest'] = '1';

            $xml->customer->id_default_group = '3';
            $xml->customer->id_lang = '1';
            //$xml->customer->newsletter_date_add = '2013-12-13 08:19:15';
            //$xml->customer->ip_registration_newsletter = '';
            //$xml->customer->last_passwd_gen = '2022-09-23 11:33:22';
            $xml->customer->deleted = '0';
            //$xml->customer->passwd = '123';
            $xml->customer->firstname = $firstName;
            $xml->customer->lastname = $lastname;
            $xml->customer->email = $email;
            // $xml->customer->id_gender = '1';
            //$xml->customer->birthday = '1980-01-15';
            //$xml->customer->newsletter = '1';
            $xml->customer->optin = '1';
            $xml->customer->website = '';
            $xml->customer->company = $company;
            $xml->customer->siret = '';
            $xml->customer->ape = '';
            $xml->customer->outstanding_allow_amount = '0';
            $xml->customer->show_public_prices = '0';
            $xml->customer->id_risk = '0';
            $xml->customer->max_payment_days = '0';
            $xml->customer->secure_key = md5(uniqid(rand(), true));
            $xml->customer->active = '1';
            $xml->customer->note = '';
            $xml->customer->is_guest = '1';
            $xml->customer->id_shop = '1';
            $xml->customer->id_shop_group = '1';
            $xml->customer->date_add = date('Y-m-d H:i:s');
            //$xml->customer->date_upd = '2022-09-28 19:33:22';
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
        $customer['id'] = $xml->customer->id;
        $customer['secure_key'] = $xml->customer->secure_key;
        $customer['firstname'] = $xml->customer->firstname;
        $customer['lastname'] = $xml->customer->lastname;

        try {
            // CREATE Address
            $xml = $webService->get(array('url' => $this->url . '/api/addresses/?schema=synopsis'));

            $xml->address->id_customer = $customer['id'];
            $xml->address->firstname = $customer['firstname'];
            $xml->address->lastname = $customer['lastname'];
            $xml->address->address1 = $address1;
            $xml->address->address2 = $address2;
            $xml->address->city = $city;
            $xml->address->phone_mobile = $phone;
            //$xml->address->postcode = '4030555';
            $xml->address->id_country = '68'; // CL
            $xml->address->alias = 'direccion usuario invitado';

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
            $xml->cart->id_customer = $customer['id'];
            $xml->cart->secure_key = $customer['secure_key'];
            $xml->cart->id_address_delivery = $id['address'];
            $xml->cart->id_address_invoice = $id['address'];
            $xml->cart->id_currency = $id['currency'];
            $xml->cart->id_lang = $id['lang'];
            $xml->cart->id_carrier = $id['carrier'];
            $xml->cart->id_guest = $id['guest'];
            $xml->cart->id_shop_group = '1';
            $xml->cart->id_shop = '1';
            $xml->cart->date_add = date('Y-m-d H:i:s');

            foreach ($cart as $key => $item) {
                $xml->cart->associations->cart_rows->cart_row->id_product = $item['id']; // $product['id'];
                $xml->cart->associations->cart_rows->cart_row->quantity = $item['quantity']; //$product['quantity'];
                // $xml->cart->associations->cart_rows->cart_row->id_product_attribute = '1'; //$product['quantity'];
            }

            // if (!empty(Tools::getValue('product_attr')))
            //     $xml->cart->associations->cart_rows->cart_row->id_product_attribute = Tools::getValue('product_attr');
            $opt = array('resource' => 'carts');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
        } catch (\Exception $e) {
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
            $xml->order->id_customer = $customer['id'];
            $xml->order->id_carrier = $id['carrier'];
            $xml->order->current_state = 10;
            $xml->order->module = 'ps_wirepayment';
            $xml->order->invoice_number = 0;
            $xml->order->invoice_date = '0000-00-00 00:00:00';
            $xml->order->delivery_number = 0;
            $xml->order->delivery_date = '0000-00-00 00:00:00';
            $xml->order->valid = 0;
            $xml->order->date_add = date('Y-m-d H:i:s');
            $xml->order->date_upd = date('Y-m-d H:i:s');
            // $xml->order->shipping_number = '';
            //$xml->order->note = 'esto es una orden de prueba';
            $xml->order->id_shop_group = 1;
            $xml->order->id_shop = 1;
            $xml->order->secure_key = md5(uniqid(rand(), true));
            $xml->order->payment = 'Bank wire';
            $xml->order->recyclable = 0;
            $xml->order->gift = 0;
            //$xml->order->gift_message = '';
            $xml->order->mobile_theme = 0;
            $xml->order->total_discounts = 0;
            $xml->order->total_discounts_tax_incl = 0;
            $xml->order->total_discounts_tax_excl = 0;
            $xml->order->total_paid = \Cart::getTotal();
            $xml->order->total_paid_tax_incl = \Cart::getTotal();
            $xml->order->total_paid_tax_excl = \Cart::getTotal();
            $xml->order->total_paid_real = 0;
            $xml->order->total_products = \Cart::getTotal();
            $xml->order->total_products_wt = \Cart::getTotal();
            $xml->order->total_shipping = 0;
            // $xml->order->total_shipping_tax_incl = 100;
            // $xml->order->total_shipping_tax_excl = 100;
            $xml->order->carrier_tax_rate = 0;
            $xml->order->total_wrapping = 0;
            $xml->order->total_wrapping_tax_incl = 0;
            $xml->order->total_wrapping_tax_excl = 0;
            $xml->order->round_mode = 0;
            $xml->order->round_type = 0;
            $xml->order->conversion_rate = 1;

            foreach ($cart as $key => $item) {
                $xml->order->associations->order_rows->order_row->product_id = $item['id'];
                $xml->order->associations->order_rows->order_row->product_quantity = $item['quantity'];
                $xml->order->associations->order_rows->order_row->product_name = $item['name'];
            }

            $opt = array('resource' => 'orders');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);

            $order = $xml->order;
            $id['order'] = $xml->order->id;
            $id['secure_key'] = $xml->order->secure_key;

            $xml = $webService->get(array('url' => $this->url . '/api/order_histories?schema=blank'));
            $xml->order_history->id_order = $id['order'];
            $xml->order_history->id_order_state = '3';

            $opt = array('resource' => 'order_histories');
            $opt['postXml'] = $xml->asXML();
            $xml = $webService->add($opt);
        } catch (PrestaShopWebserviceException $e) {
            return $e->getMessage();
        }

        return  $order;
    }

    public function updateOrderHistoriesState($idPedido, $idEstado)
    {
        $webService = new PrestaShopWebservice($this->url, config('constants.apiKey'), false);

        try {
            $opt = [
                'resource' => 'order_histories?schema=blank'
            ];

            $xml = $webService->get($opt);
            $resources = $xml->order_history->children();

            $resources->id_order = intval($idPedido);
            $resources->id_order_state = $idEstado; // pago aceptado TODO
            $resources->id_employee = 1;

            $opt = [
                'resource' => 'order_histories',
                'postXml' => $xml->asXML(),
            ];

            $createdXml = $webService->add($opt);
        } catch (PrestaShopWebserviceException $e) {
            return $e->getMessage();
        }
    }
}
