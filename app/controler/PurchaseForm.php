<?php

/**
 * PurchaseForm class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class PurchaseForm extends Purchase
{

    public $dataclass;
    const CLASSLINK = 'Purchase';

    public function getData($data = null)
    {

        // Delete obj when status == deleted
        if (!empty($data['status']) && $data['status'] == 'deleted')
        {
            $this->deleteObj($data['key']);
        }

        $alert = '';
        if (isset($data['status']) && $data['status'] == 1) {
            $alert = "<script> 
                            $(document).ready(
                                function(){ 
                                    $('#successful').slideDown('slow');
                                    setTimeout(
                                        () => {
                                            $('#successful').slideToggle('slow');
                                        }, 
                                        6000
                                    );
                                }
                            );
                        </script>";
        } else if (isset($data['status']) && $data['status'] == 10) {
            $alert = "<script> 
                            $(document).ready(
                                function(){ 
                                    $('#error').slideDown('slow');
                                    setTimeout(
                                        () => {
                                            $('#error').slideToggle('slow');
                                        }, 
                                        6000
                                    );
                                }
                            );
                       </script>";
        }

        $inputid = '';
        if (isset($data['key']) && $data['key'] != null && $data['status'] != 5) {
            $inputid = '<div class="mb-3">
                        <label class="form-label" for="id">Id: </label>
                        <input class="form-control" typ     e="text" name="id" id="id" value="'.$data['obj']['id'].'" readonly>
                    </div>';
            $product_id = $data['obj']['product_id'];
            $qnt = $data['obj']['qnt'];
            $supplier = $data['obj']['supplier'];
        } else if ($data['key'] != null && $data['status'] == 5) {
            $product_id = $data['key'];
            $qnt = '';
            $supplier = '';
        } else {
        $product_id = '';
        $qnt = '';
        $supplier = '';
    }

        // load modal and show up if necessaryy
        $modal = (empty($data['status']) || $data['status'] != 'del')?'':$this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>This purchase wil be deleted.<br><b>Do you confirm this?</b>','Confirm','front.php?class='.self::CLASSLINK.'&status=deleted&key='.$data['key'],'danger');

        // load options of purchase types to select input
        $products = Product::getObjs();
        $options_product = '';
        foreach ($products as $prod)
        {
            $selected = ($product_id == $prod['id'])?' selected':'';
            $options_product .= '<option value="'.$prod['id'].'"'.$selected.'>'.$prod['name'].'</option>';
        }

        $classcancel = ($data['status'] == 5) ? 'Stock' : self::CLASSLINK;

        // Modal alert for Out Off Stock
        if (!empty($data['status']) && $data['status'] == 'oos')
        {
            $modal = $this->helper::getModal('alertOOStock','Not enough stock!','Cannot remove more than it has.<br><b>Purchase more balance in stock to remove this amount.</b>','Ok','front.php?class='.self::CLASSLINK.'&key='.$data['key'],'info');
        }

        // make a HTML data to return
        $this->dataclass = $alert.$modal.
                            '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">Purchase Form</h2>
                                        <h5 class="text-700 fw-semi-bold">Form of purchase</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">    
                                <form class="p-3" action="front.php?class='.self::CLASSLINK.'" method="post" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                         &nbsp;
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                           '.$inputid.'
                                            <div class="mb-3">
                                                <label class="form-label" for="product_id">Product: </label>
                                                <select class="form-control" name="product_id" id="product_id" required>
                                                    '.$options_product.'
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="qnt">Qnt: </label>
                                                <input class="form-control" type="number" name="qnt" id="qnt" required value="'.$qnt.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="supplier">Supplier: </label>
                                                <input class="form-control" type="text" name="supplier" id="supplier" required value="'.$supplier.'">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                         &nbsp;
                                        </div>
                                        <div class="col-12 col-md-3">
                                         &nbsp;
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <div id="successful" class="alert alert-success mb-6" role="alert" style="display: none;">
                                                <div>Purchase Saved!</div>
                                            </div>
                                            <div id="error" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                                <div>The purchase already exists!</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                         &nbsp;
                                        </div>
                                    </div>
                                    <div class="row p-3">    
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: right;">
                                            <button class="btn btn-primary col-12" type="submit" name="submit" id="btnsubmint">Save</button>
                                        </div>
                                        <div class="d-none d-md-block col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                            &nbsp;
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: left">
                                            <a class="btn btn-secondary col-12" href="front.php?class='.$classcancel.'List">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>';
        return $this->dataclass;
    }
}