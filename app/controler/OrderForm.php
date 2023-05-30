<?php

/**
 * OrderForm class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class OrderForm extends Order
{

    public $dataclass;
    const CLASSLINK = 'Order';

    public function getData($data = null)
    {
        $pagecurr = 1;
        if(!empty($action['page']))
        {
            $pagecurr = $action['page'];
        } else if(isset($data['page']))
        {
            $pagecurr = $data['page'];
        }

        // if from POS, rewrite class
        if (isset($data['status']) && $data['status'] == 'sale') {
            header("Location: ".DIRSYS."/app/view/front.php?class=OrderForm");
        }

        if (isset($data['prod']) && isset($data['qnt']))
        {
            $itemcart = Product::getObj($data['prod']);
            $typecart = TypeProduct::getObj($itemcart['type_id']);

            $valprod = number_format($itemcart['cost'] + (($itemcart['cost'] / 100) * $itemcart['profit']),4,'.','');
            $valtax = number_format(($valprod / 100) * $typecart['tax'],4,'.','');

            $_SESSION['pos'][$itemcart['id']] = [
                'id' => $itemcart['id'],
                'name' => $itemcart['name'],
                'img' => $itemcart['img'],
                'type_id' => $itemcart['type_id'],
                'type' => $typecart['type'],
                'valprod' => $valprod,
                'tax' => $typecart['tax'],
                'valtax' => $valtax,
                'qnt' => $data['qnt']
            ];
        }


        $cart = $_SESSION['pos'];

        // Delete obj when status == deleted
        if (!empty($data['status']) && $data['status'] == 'deleted')
        {
            $this->deleteObj($data['key']);
        }

        // clear cart
        if (isset($data['clear']) && !empty($data['clear']))
        {
            if ($data['clear'] == 'all')
            {
                $_SESSION['pos'] = [];
            }
            if ($data['clear'] == 'red' && !empty($data['prod']))
            {
                if ($_SESSION['pos'][$data['prod']]['qnt'] == 1)
                {
                    unset($_SESSION['pos'][$data['prod']]);
                } else {
                    $_SESSION['pos'][$data['prod']]['qnt'] = $_SESSION['pos'][$data['prod']]['qnt'] - 1;
                }

            }
            if ($data['clear'] == 'inc' && !empty($data['prod']))
            {
                $_SESSION['pos'][$data['prod']]['qnt'] = $_SESSION['pos'][$data['prod']]['qnt'] + 1;
            }
            header("Location: ".DIRSYS."/app/view/front.php?class=OrderForm");
        }

        $types = TypeProduct::getRegistersPaginated(4,$pagecurr);
        $pagination = $this->helper::getNavPOS(4,$pagecurr,'product_type','OrderForm');

        $type = (isset($data['type'])) ? $data['type'] : null;
        $itenstype = '';
        foreach ($types as $tp)
        {
            $type = (!empty($type)) ? $type : $tp['id'];
            $itenstype .= '<a href="front.php?class=OrderForm&type='.$tp['id'].'&page='.$pagecurr.'" onclick="$(\'#containerload\').show();" class="text-decoration-none col-6 col-lg-3 pb-3 d-flex align-items-stretch">
                                    <div class="bg-white shadow rounded-4 border border-secondary p-3" style="width: 95%;">
                                            <img class="img-fluid mx-auto d-block" style="max-height: 80px;" src="'.$tp['img'].'">
                                        <div class="text-center p-3">
                                            <div class="col-12 bg-white card border-0">
                                                <h4 class="card-title text-body">'.$tp['type'].'</h4>
                                                <p class="card-text text-black-50">'.Product::getQntObjsByType($tp['id']).' produts</p>
                                            </div>
                                        </div>
                                    </div>
                            </a>';
        }

        $products = Product::getObjsByType($type);
        $itensprod = '';
        foreach ($products as $pd)
        {
            $stock = Stock::getObjByProduct($pd['id'])['stock'];
            if ($stock==0) {
                continue;
            }
            $itensprod .= '<a href="front.php?class=OrderForm&type='.$type.'&qnt=1&prod='.$pd['id'].'&page='.$pagecurr.'" onclick="$(\'#containerload\').show();" class="text-decoration-none col-12 col-lg-4 pb-3 d-flex align-items-stretch">
                                    <div class="bg-white shadow rounded-4 border-0 p-3">
                                            <img class="img-fluid mx-auto d-block" src="'.$pd['img'].'">
                                        <div class="text-center p-3">
                                            <div class="col-12 bg-white card border-0">
                                                <h4 class="card-title text-body">'.$pd['name'].'</h4>
                                                <p class="card-text text-black-50">'.$stock.' itens</p>
                                            </div>
                                        </div>
                                    </div>
                            </a>';
        }
        if ($itensprod == '')
        {
            $itensprod = '<a class="text-decoration-none col-12 col-lg-4 pb-3 d-flex align-items-stretch">
                                <div class="bg-white rounded-4 border-0 p-3">
                                        <img class="img-fluid mx-auto d-block" src="https://media.istockphoto.com/id/1220326865/id/foto/gadis-muda-di-depan-rak-kosong-di-supermarket-panik-membeli-dan-menimbun-konsep.jpg?s=612x612&w=0&k=20&c=1p5GSekqjZus1khRBHUiUTJalRzTjJ3yiM4VyRaYEhw=">
                                    <div class="text-center p-3">
                                        <div class="col-12">
                                            <h4 class="card-title text-body">Empty Shelf</h4>
                                            <p class="card-text text-black-50">0 itens</p>
                                        </div>
                                    </div>
                                </div>
                            </a>';
        }

        $cart_item = '';
        $subtotal = 0;
        $totaltax = 0;
        $taxper = 0;
        foreach ($cart as $item_id => $item)
        {
            $vlitem = ($item['valprod'] * $item['qnt']);
            $vltaxed = ($item['valtax'] * $item['qnt']);
            $cart_item .= '<div class="col-6 align-middle border-bottom pb-2 mt-2 mb-2">
                                <div class="row align-middle">
                                    <div class="col-4 col-md-3 align-middle p-0 m-0">
                                        <img class="img p-0 mr-2 rounded-circle align-middle border" height="45px" width="45px" src="'.$item['img'].'">
                                    </div>
                                    <div class="col-8 col-md-9 align-middle p-0 m-0">
                                        <span class="col-12 align-bottom m-0 p-0" style="margin-left:0.4em !important;vertical-align: middle !important; line-height: 0.9em !important;" >'.$item['name'].'</span>
                                    </div>             
                                </div>                     
                            </div>
                            <div class="col-3 p-0 align-middle pb-2 border-bottom  mt-2 mb-2">
                                <div class="input-group mb-2 mt-2 align-middle" style="vertical-align: middle !important; text-align: center !important; line-height: 1.3em !important;">
                                  <div class="col-4 p-0 align-middle text-black-50">
                                    <a href="front.php?class=OrderForm&clear=red&prod='.$item['id'].'" onclick="$(\'#containerload\').show();" class="text-decoration-none"><i class="fa fa-minus-square fa-2x text-black-50" aria-hidden="true"></i></a>
                                    <input type="hidden" id="product_id['.$item['id'].']" name="product_id['.$item['id'].']" value="'.$item['id'].'">
                                  </div>
                                  <div class="p-0 col-4 form-control border-0 align-middle text-center"><h5 class="text-center">'.$item['qnt'].'</h5></div>
                                  <input type="hidden" id="qnt['.$item['id'].']" name="qnt['.$item['id'].']" value="'.$item['qnt'].'">
                                  <div class="col-4 p-0 align-middle text-black-50">
                                    <a href="front.php?class=OrderForm&clear=inc&prod='.$item['id'].'" onclick="$(\'#containerload\').show();" class="text-decoration-none"><i class="fa fa-plus-square fa-2x text-black-50" aria-hidden="true"></i></a>
                                  </div>
                                </div>                                        
                            </div>    
                            <div class="col-3 p-0 align-middle text-right border-bottom pb-2  mt-2 mb-2">
                                <div class="col-10 align-middle text-right">
                                    <h5 class="lh-lg align-top text-right p-0 m-0"  style="vertical-align: middle !important; text-align: right !important; line-height: 0.9em !important;">$'.number_format($vlitem,2,'.',',').'<br><small style="font-size: 0.7em; color: darkgrey;" >Tax $'.number_format($vltaxed,2,'.',',').'</small></h5>
                                    <input type="hidden" id="valprod['.$item['id'].']" name="valprod['.$item['id'].']" value="'.$item['valprod'].'">
                                    <input type="hidden" id="valtax['.$item['id'].']" name="valtax['.$item['id'].']" value="'.$item['valtax'].'">
                                </div>                                        
                            </div>';
            $subtotal = $subtotal + $vlitem;
            $totaltax = $totaltax + $vltaxed;
            $taxper = (($totaltax / $subtotal)*100);
        }

        $total = ($subtotal + $totaltax);

        // make a HTML data to return
        $this->dataclass = '<div class="row flex-between-center mb-4 g-3">
                                <form class="row" action="front.php?class='.self::CLASSLINK.'" method="post" autocomplete="off">
                                    <div class="col-12 col-md-8">
                                        <!-- Type Products  card overflow-hidden shadow -->
                                        <div class="row mb-n4">
                                            '.$pagination.'
                                            <div class="col-12">
                                                <div class="row d-flex justify-content-center p-0">
                                                    '.$itenstype.'
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Products  -->
                                        <div class="row d-flex justify-content-center">
                                            '.$itensprod.'
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <!-- Type Order  -->
                                        <div class="col-12 bg-white shadow rounded-4 sticky-top p-4" style="top: 70px">
                                            <div class="row">
                                                <div class="col-12 col-md-8">
                                                    <h3>Current Order</h3>
                                                </div>
                                                <div class="col-12 col-md-4 clearfix pb-4">
                                                    <a href="front.php?class=OrderForm&clear=all" onclick="$(\'#containerload\').show();" class="btn btn-success float-right w-100">Clear All</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                '.$cart_item.'
                                            </div>
                                            <div class="row bg-success rounded-4 p-3 pb-2 text-white mt-4 mb-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5>Subtotal</h5>
                                                    </div>
                                                    <div class="col-6 p-0 m-0">
                                                        <h5 style="text-align: right !important;">$'.number_format($subtotal,2,'.',',').'</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5>Tax ('.number_format($taxper,2,'.',',').'%)</h5>
                                                    </div>
                                                    <div class="col-6 p-0 m-0">
                                                        <h5 style="text-align: right !important;">$'.number_format($totaltax,2,'.',',').'</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    &nbsp;
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h3><b>Total</b></h3>
                                                    </div>
                                                    <div class="col-6 p-0 m-0" >
                                                        <h2 style="text-align: right !important;">$<b>'.number_format($total,2,'.',',').'</b></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center p-0">
                                                <div class="col-12 p-2">
                                                    <h3>Payment Method</h3>
                                                </div>
                                                <div class="card col-12 col-lg-4 bg-light rounded-4 m-2 p-3 text-center" style="width: 25% !important;">
                                                    <i class="fa fa-money fa-2x text-black-50" aria-hidden="false"></i>
                                                    <p class="p-0 m-0"><small>Cash</small></p>                                        
                                                </div>    
                                                <div class="card col-12 col-lg-4 bg-light rounded-4 m-2 p-3 text-center" style="width: 25% !important;">
                                                    <i class="fa fa-credit-card fa-2x text-black-50" aria-hidden="false"></i>
                                                    <p class="p-0 m-0"><small>Card</small></p>                                        
                                                </div>
                                                <div class="card col-12 col-lg-4 bg-light rounded-4 m-2 p-3 text-center" style="width: 25% !important;">
                                                    <i class="fa fa-paypal fa-2x text-black-50" aria-hidden="false"></i>
                                                    <p class="p-0 m-0"><small>E-Wallet</small></p>
                                                </div>
                                            </div>
                                            <div class="row bg-light rounded-4 p-3">
                                                <button type="submit" class="btn btn-primary p-2" onclick="$(\'#containerload\').show();"><h5>Print Bills</h5></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>';
        return $this->dataclass;
    }
}