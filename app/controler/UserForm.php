<?php

/**
 * UserForm class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class UserForm extends User
{

    public $dataclass;
    const CLASSLINK = 'User';

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
            $name = $data['obj']['name'];
            $type_id = $data['obj']['type_id'];
            $cost = $data['obj']['cost'];
            $profit = $data['obj']['profit'];
            $img = $data['obj']['img'];
        } else {
            $inputid = '';
            $name = '';
            $type_id = '';
            $cost = '';
            $profit = '';
            $img = '';
        }

        // load modal and show up if necessaryy
        $modal = (empty($data['status']) || $data['status'] != 'del')?'':$this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>This product wil be deleted.<br><b>Do you confirm this?</b>','Confirm','front.php?class='.self::CLASSLINK.'&status=deleted&key='.$data['key'],'danger');

        // load options of product types to select input
        $types = User::getObjs();
        $options_type = '';
        foreach ($types as $tp)
        {
            $selected = ($type_id == $tp['id'])?' selected':'';
            $options_type .= '<option value="'.$tp['id'].'"'.$selected.'>'.$tp['type'].'</option>';
        }

        // load image
        $showimg = '';
        if ($img != '')
        {
            $showimg = '<div class="mb-3">
                            <img class="img-thumbnail rounded mx-auto d-block" src="'.$img.'">
                        </div>';
        }

        if ($result == 1){
            $alerts = '$(document).ready(function(){setTimeout(() => {$("#successful").slideToggle("slow");window.location.replace("'.DIRSYS.'/app/view/login.php");}, 6000);});';
        } else if ($result == 10){
            $alerts = '$(document).ready(function(){setTimeout(() => {$("#usermail").slideToggle("slow");}, 6000);});';
        } else if ($result == 100){
            $alerts = '$(document).ready(function(){setTimeout(() => {$("#passmatch").slideToggle("slow");}, 6000);});';
        }

        // make a HTML data to return
        $this->dataclass = $alert.$modal.
                            '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">User Form</h2>
                                        <h5 class="text-700 fw-semi-bold">Form of user</h5>
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
                                                <label class="form-label" for="name">Name: </label>
                                                <input class="form-control" type="text" name="name" id="name" required value="'. $name.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="username">Username: </label>
                                                <input class="form-control" type="text" name="username" id="username" required value="'. $username.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Email: </label>
                                                <input class="form-control" type="email" name="email" id="email" required value="'. $email.'">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="password">Password: </label>
                                                <input class="form-control" type="password" name="password" id="password" required value="" onkeydown="restrictpass(this);" onkeyup="restrictpass(this);" title="Your password must be 4-6 characters long, contain letters and numbers, and must not contain spaces or special characters.">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="confirmpassword">Confirm Password: </label>
                                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" required value="">
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
                                                <div>User Saved!</div>
                                            </div>
                                            <div id="error" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                                <div>This user already exists!</div>
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
                            </div>
                            <script type="application/javascript">
                                function restrictpass(element)
                                {
                                    var max_chars = 6;
                        
                                    if(element.value.length > max_chars) {
                                        element.value = element.value.substr(0, max_chars);
                                    }
                                    var letters = /^[0-9a-zA-Z]+$/;
                                    if(!element.value.match(letters))
                                    {
                                        element.value = element.value.substr(0, element.value.length - 1);
                                    }
                                };
                                '.$alerts.'
                            </script>';
        return $this->dataclass;
    }
}