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

        // Delete obj when status == deleted
        if (!empty($data['status']) && $data['status'] == 'deleted')
        {
            $this->deleteObj($data['key']);
        }

        $alert = '';
        if ($data['status'] == 1) {
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
        } else if ($data['status'] == 10) {
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

        if ($data['key'] != null) {
            $inputid = '<div class="mb-3">
                        <label class="form-label" for="id">Id: </label>
                        <input class="form-control" type="text" name="id" id="id" value="'.$data['key'].'" readonly>
                    </div>';
            $name = $data['obj']['name'];
            $type_id = $data['obj']['type_id'];
            $cost = $data['obj']['cost'];
            $profit = $data['obj']['profit'];
        } else {
            $inputid = '';
            $name = '';
            $type_id = '';
            $cost = '';
            $profit = '';
        }

        // load modal and show up if necessaryy
        $modal = (empty($data['status']) || $data['status'] != 'del')?'':$this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>This Order wil be deleted.<br><b>Do you confirm this?</b>','Confirm','front.php?class='.self::CLASSLINK.'&status=deleted&key='.$data['key'],'danger');

        // load options of Order types to select input
        $types = TypeProduct::getObjs();
        $options_type = '';
        foreach ($types as $tp)
        {
            $selected = ($type_id == $tp['id'])?' selected':'';
            $options_type .= '<option value="'.$tp['id'].'"'.$selected.'>'.$tp['type'].'</option>';
        }

        // make a HTML data to return
        $this->dataclass = $alert.$modal.
                            '<div class="row flex-between-center mb-4 g-3">
                                <form class="p-3 row" action="front.php?class='.self::CLASSLINK.'" method="post" autocomplete="off">
                                    <div class="col-8 bg-light rounded-4 border border-secondary">
                                        <!-- Type Products  card overflow-hidden shadow -->
                                        <div class="col-12 bg-light rounded-4 border border-secondary">
                                            &nbsp;
                                        </div>
                                        <!-- Products  -->
                                        <div class="col-12 bg-light rounded-4 border border-secondary">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="col-4 bg-light rounded-4 border border-secondary">
                                        <!-- Type Order  -->
                                        <div class="col-12 bg-light rounded-4 border border-secondary">
                                            <div class="row bg-light rounded-4 border border-secondary">
                                                &nbsp;
                                            </div>
                                            <div class="row bg-light rounded-4 border border-secondary">
                                                <div class="col-6 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>
                                                <div class="col-3 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>    
                                                <div class="col-3 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>
                                            </div>
                                            <div class="row bg-success rounded-4">
                                                &nbsp;
                                            </div>
                                            <div class="row bg-light rounded-4 border border-secondary">
                                                <div class="col-12 bg-light rounded-4 border border-secondary">
                                                    <h3>Payment Method</h3>
                                                </div>
                                                <div class="col-4 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>    
                                                <div class="col-4 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>
                                                <div class="col-4 bg-light rounded-4 border border-secondary">
                                                    &nbsp;                                        
                                                </div>
                                            </div>
                                            <div class="row bg-light rounded-4 p-3">
                                                <a class="btn btn-success">Print Bills</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>';
        return $this->dataclass;
    }
}