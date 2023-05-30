<?php

/**
 * TypeProductForm class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class TypeProductForm extends TypeProduct
{

    public $dataclass;
    const CLASSLINK = 'TypeProduct';

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

        if (isset($data['key']) && $data['key'] != null) {
            $inputid = '<div class="mb-3">
                        <label class="form-label" for="id">Id: </label>
                        <input class="form-control" type="text" name="id" id="id" value="'.$data['key'].'" readonly>
                    </div>';
            $type = $data['obj']['type'];
            $tax = $data['obj']['tax'];
            $img = $data['obj']['img'];
        } else {
            $inputid = '';
            $type = '';
            $tax = '';
            $img = '';
        }

        // load image
        $showimg = '';
        if ($img != '')
        {
            $showimg = '<div class="mb-3">
                            <img class="img-thumbnail rounded mx-auto d-block" onerror="this.onerror=null; this.src=\'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png\'" src="'.$img.'">
                        </div>';
        }

        $modal = '';

        // Modal alert deleting
        if (!empty($data['status']) && $data['status'] == 'del')
        {
            $modal = $this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>This type of product wil be deleted.<br><b>Do you confirm this?</b>','Confirm','front.php?class='.self::CLASSLINK.'&status=deleted&key='.$data['key'],'danger');
        }

        // Modal alert do dependency
        if (!empty($data['status']) && $data['status'] == 'havchi')
        {
            $modal = $this->helper::getModal('alertDependency','Type of product not removed!','This type of product have products associated.<br><b>Remove association before deleting.</b>','Ok','front.php?class='.self::CLASSLINK.'&key='.$data['key'],'info');
        }

        $this->dataclass = $alert.$modal.
                            '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">Type of Product Form</h2>
                                        <h5 class="text-700 fw-semi-bold">Form of type product</h5>
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
                                               '.$showimg.'
                                               '.$inputid.'
                                            <div class="mb-3">
                                                <label class="form-label" for="type">Type: </label>
                                                <input class="form-control" type="text" name="type" id="type" required value="'.$type.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="tax">Tax: </label>
                                                <input class="form-control" type="number" step="0.01" name="tax" id="tax" required value="'.$tax.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="img">Image URL: </label>
                                                <input class="form-control" type="text" name="img" id="img" required value="'.$img.'">
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
                                                <div>Type of Product Saved!</div>
                                            </div>
                                            <div id="error" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                                <div>The type already exists!</div>
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
                                            <a class="btn btn-secondary col-12" href="front.php?class='.self::CLASSLINK.'List">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>';
        return $this->dataclass;
    }
}