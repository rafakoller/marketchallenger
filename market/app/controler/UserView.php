<?php

/**
 * UserView class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class UserView extends Market
{

    public $dataclass;

    public function getData($action = null)
    {
        $user = User::getObj($_SESSION['id']);
        $status = ($user['status'] == 0)? "<div class='btn btn-danger'>Inactive</div>" : "<div class='btn btn-success'>Active</div>";
        $this->dataclass = '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">User View</h2>
                                        <h5 class="text-700 fw-semi-bold">User data dectails</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center p-4 mb-4 g-3 card overflow-hidden shadow">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-4" style="text-align: right !important;">
                                        <h5>Nome:</h5>
                                    </div>
                                    <div class="col-8">
                                        <h3><b>'.$_SESSION['name'].'</b></h3>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-4" style="text-align: right !important;">
                                        <h5>Username:</h5>
                                    </div>
                                    <div class="col-8">
                                        <h5><b>'.$user['username'].'</b></h5>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-4" style="text-align: right !important;">
                                        <h5>Email:</h5>
                                    </div>
                                    <div class="col-8">
                                        <h5><b>'.$_SESSION['email'].'</b></h5>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-4" style="text-align: right !important;">
                                        <h5>Status:</h5>
                                    </div>
                                    <div class="col-8">
                                        <div>'.$status.'</div>
                                    </div>
                                </div>
                                <div class="row p-3">    
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 col-xxl-2" style="float: left">
                                        <a class="btn btn-primary col-12" href="front.php?class=User&key='.$_SESSION['id'].'">Edit Profile</a>
                                    </div>
                                </div>
                            </div>';
        return $this->dataclass;
    }
}