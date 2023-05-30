<?php

/**
 * OrderList class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class OrderList extends Order
{

    const LIMITE = 10;
    public $dataclass;

    public function getData($data = null)
    {

        // Load View Order
        if (!empty($data['status']) && $data['status'] == 'sale')
        {
            $data = $this->showOrder($data['key']);
            return $data;
        }

        $pagecurr = 1;
        if(!empty($data['page']))
        {
            $pagecurr = $data['page'];
        }

        $registers = $this->getRegisters(self::LIMITE,$pagecurr);
        $pagination = $this->helper::getPagination(self::LIMITE,$pagecurr,'order','OrderList');

        $modal = '';

        // Modal alert deleting
        if (!empty($data['status']) && $data['status'] == 'del')
        {
            $modal = $this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>Order id '.str_pad($data['key'], 4 , '0' , STR_PAD_LEFT).' will be deleted.<br><b>Do you confirm that?</b>','Confirm','front.php?class=Order&status=deleted&key='.$data['key'],'danger');
        }

        $this->dataclass = $modal.
                            '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">List of orders</h2>
                                        <h5 class="text-700 fw-semi-bold">Orders list</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                                <div class="row p-5">
                                    '.$registers.'
                                    '.$pagination.'                       
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <a class="btn btn-primary" href="front.php?class=OrderForm">POS</a>
                                    </div>
                                </div>
                                <br>
                            </div>';
        return $this->dataclass;
    }

    public function showOrder($key)
    {
        $order = Order::getObj($key);
        $user = User::getObj($order['user_id']);
        $prods = OrderProduct::getObjsByOrder($key);
        $valprod = 0;

        $totprice = 0;
        $totptax = 0;
        $totvtax = 0;
        $totorder = 0;


        $products = '';
        foreach ($prods as $prod)
        {
            $totprod = ($prod['valprod'] + $prod['valtax']) * $prod['qnt'];
            $pertax = ($prod['valtax']  / $prod['valprod']) * 100;

            $product = Product::getObj($prod['product_id']);

            $products .= '<tr>
                              <th>'.$product['name'].'</th>
                              <td><div class="text-center">'.$prod['qnt'].'</div></td>
                              <td><div class="text-center">$'.number_format($prod['valprod'],2,'.',',').'</div></td>
                              <td><div class="text-center">'.number_format($pertax,2,'.',',').'% <small>($'.number_format($prod['valtax'],2,'.',',').')</small></div></td>
                              <td><div class="text-right" style="text-align: right !important;">$'.number_format($totprod,2,'.',',').'</div></td>
                            </tr>';

            $totprice = $totprice + ($prod['valprod'] * $prod['qnt']);
            $totvtax = $totvtax + ($prod['valtax'] * $prod['qnt']);

        }
        $totorder = $totprice + $totvtax;
        $totptax = ($totvtax / $totprice) * 100;

        $this->dataclass = '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">Order '.str_pad($key, 4 , '0' , STR_PAD_LEFT).'</h2>
                                        <h5 class="text-700 fw-semi-bold">User: '.$user['name'].'</h5>
                                        <h5 class="text-700 fw-semi-bold">Date/Time: '.$order['created_at'].'</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                                <div class="row p-5">
                                    <table class="table table-bordered mw-100">
                                      <thead>
                                        <tr>
                                          <th scope="col"><div class="text-center">Product</div></th>
                                          <th scope="col"><div class="text-center">Quantity</div></th>
                                          <th scope="col"><div class="text-center">Price</div></th>
                                          <th scope="col"><div class="text-center">Tax Type</div></th>
                                          <th scope="col"><div class="text-center">Sub Total</div></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      '.$products.'
                                      </tbody>
                                    </table>                                                        
                                </div>
                                <br>
                            </div>
                            <div class="row text-right mt-5 mb-3">
                                <div class="col-6">&nbsp;</div>
                                <h6 class="col-3 border-bottom " style="text-align: left !important;">Total Products</h6>
                                <h5 class="col-3 border-bottom " style="text-align: right !important;">$'.number_format($totprice,2,'.',',').'</h5>
                                
                                <div class="col-6">&nbsp;</div>
                                <h6 class="col-3 border-bottom " style="text-align: left !important;">Total Tax <small>('.number_format($totptax,2,'.',',').'%)</small></h6>
                                <h5 class="col-3 border-bottom " style="text-align: right !important;">$'.number_format($totvtax,2,'.',',').'</h5>
                                
                                <div class="col-6">&nbsp;</div>
                                <h3 class="col-3 border-bottom " style="text-align: left !important;">Total Order</h3>
                                <h3 class="col-3 border-bottom " style="text-align: right !important;">$<b>'.number_format($totorder,2,'.',',').'</b></h3>
                            </div>
                            <div class="row noPrint mt-5 d-flex justify-content-center">
                                <div class="col-12 col-sm-3">
                                    <a class="noPrint btn btn-primary col-12" href="front.php?class=OrderForm">POS</a>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <a class="noPrint btn btn-primary col-12" href="front.php?class=OrderList">Order List</a>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <button onclick="window.print();" class="noPrint btn btn-info col-12"><i class="fa fa-print" aria-hidden="false"></i> Print</button>
                                </div>
                            </div>
                            <script>
                                    $(window).on("load", function(){
                                        $("#containerload").hide();
                                        window.print();
                                    });
                            </script>';
        return $this->dataclass;
    }
}