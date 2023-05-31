<?php
require 'Connection.php';
require 'Cript.php';

/**
 * User system class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class User extends Connection {

    public $helper = Helper::class;

    /*
     *
     */
    public function getData($data)
    {
        if (isset($data['mode'])) {
            if ($data['mode'] == 'inactive') {
                $status = 1;
            } else if ($data['mode'] == 'active') {
                $status = 0;
            }
            if ($data['key'] != $_SESSION['id']) {
                $db = new Connection();
                $con = $db->getConnection();
                $query = "UPDATE user SET `status` = {$status} WHERE id = {$data['key']};";
                mysqli_query($con, $query) or die(mysqli_error($con));
                header("Location: ".DIRSYS."/app/view/front.php?class=UserList&status=defined&mode=" . $status . "&user=" . $data['key']);
            } else {
                header("Location: ".DIRSYS."/app/view/front.php?class=UserList&status=yourself&user=" . $data['key']);
            }
        }

        // Delete obj when status == deleted
        if (!empty($data['status']) && $data['status'] == 'deleted')
        {
            $this->deleteObj($data['key']);
        }

        $alert = '';
        $error = '';
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
        } else if (isset($data['status']) && ($data['status'] == 10 || $data['status'] == 100)) {
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
            if ($data['status'] == 10)
            {
                $error = '<div id="error" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                                <div>This user already exists!</div>
                                            </div>';
            } else if ($data['status'] == 100)
            {
                $error = '<div id="error" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                                <div>The password need be equals!</div>
                                            </div>';
            }
        }

        if (isset($data['key']) && $data['key'] != null)
        {
            $data['obj'] = User::getObj($data['key']);
            $inputid = '<div class="mb-3">
                        <input class="form-control" type="hidden" name="id" id="id" value="'.$data['key'].'" readonly>
                    </div>';
            $name = $data['obj']['name'];
            $username = $data['obj']['username'];
            $email = $data['obj']['email'];
            $status = $data['obj']['status'];
        } else {
            $inputid = '';
            $name = '';
            $username = '';
            $email = '';
            $status = '';
        }

        // load modal and show up if necessaryy
        $modal = (empty($data['status']) || $data['status'] != 'del')?'':$this->helper::getModal('confirmDelete','Do you want Delete?','<h2>Attention!</h2>This product wil be deleted.<br><b>Do you confirm this?</b>','Confirm','front.php?class='.self::CLASSLINK.'&status=deleted&key='.$data['key'],'danger');

        // make a HTML data to return
        $dataclass = $alert.$modal.
            '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">User Edit</h2>
                                        <h5 class="text-700 fw-semi-bold">Form of user</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">    
                                <form class="p-3" action="front.php?class=User" method="post" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                         &nbsp;
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
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
                                                <input class="form-control" type="password" name="password" id="password" value="" onkeydown="restrictpass(this);" onkeyup="restrictpass(this);" title="Your password must be 4-6 characters long, contain letters and numbers, and must not contain spaces or special characters.">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="confirmpassword">Confirm Password: </label>
                                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="">
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
                                            '.$error.'
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
                                            <a class="btn btn-secondary col-12" href="front.php?class=UserList">Cancel</a>
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
                            </script>';
        return $dataclass;
    }

    /**
     * Register User on DB
     * @return integer
     */
    public function onPost($data){

        $db = new Connection();
        $con = $db->getConnection();

        $query = "SELECT * FROM user WHERE username = '{$data['username']}' AND id <> {$data['id']} OR email = '{$data['email']}' AND id <> {$data['id']};";
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));

        $data['key'] = $data['id'];

        if (mysqli_num_rows($duplicate) > 0){
            $data['status'] = 10;
            return $data;
            // Username or email has already in use
        } else {
            if ($data['password'] == $data['confirmpassword']) {

                $password = '';
                if (isset($data['password']) && !empty($data['password']))
                {
                    $hash = Cript::hash($data['password']);
                    $password = ", password = '".$hash."'";
                }

                $query = "UPDATE `user` SET `name` = '{$data['name']}', `username` = '{$data['username']}', `email` = '{$data['email']}'{$password} WHERE `id` = {$data['id']};";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $data['status'] = 1;
                return $data;
                // Successful registration
            } else {
                $data['status'] = 100;
                return $data;
                // Password does not equals
            }
        }
    }

    /**
     * Register User on DB
     * @return integer
     */
    public function registration($name,$username,$email,$password,$confirmpassword){

        $db = new Connection();
        $con = $db->getConnection();

        $hash = Cript::hash($password);

        $query = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));

        if (mysqli_num_rows($duplicate) > 0){
            return 10;
            // Username or email has already in use
        } else {
            if ($password == $confirmpassword) {
                $query = "INSERT INTO user VALUES('','$name','$username','$email','$hash',0)";
                mysqli_query($con, $query) or die(mysqli_error($con));
                return 1;
                // Successful registration
            } else {
                return 100;
                // Password does not equals
            }
        }
    }

    /**
     * Get a Object
     * @param $id
     * @return array
     */
    public static function getObj($id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `user` WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /**
     * Get a html table of Paginated Registers
     * @param $limite
     * @param $pagecurr
     * @return void
     */
    public function getRegisters($limite,$pagecurr)
    {
        $offset = ($pagecurr == 1 || $pagecurr == 0)?0:($pagecurr - 1)*$limite;
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `user` ORDER BY `name` ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        foreach ($results as $res)
        {
            $status = ($res['status'] == 0) ? '<a href="front.php?class=User&status=hownow&mode=inactive&key='.$res['id'].'" class="btn btn-danger" title="Inactive">Inactive</a>' : '<a href="front.php?class=User&status=hownow&mode=active&key='.$res['id'].'" class="btn btn-success" title="Active">Active</a>';

            $listyps .= '<tr>
                          <td>'.$res['username'].'</td>
                          <td>'.$res['name'].'</td>
                          <td>'.$res['email'].'</td>
                          <td>
                            <div class="row d-flex justify-content-center">
                                <div class="col-6 text-center" style="text-align: center !important;">
                                    '.$status.'
                                </div>
                            </div>
                          </td>
                          <td>
                            <div class="row d-flex justify-content-center">
                                <div class="col-6 text-center">
                                    <a href="front.php?class=User&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-6 text-center"> 
                                    <a href="front.php?class=User&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
                                </div>
                            </div>
                          </td>
                        </tr>';
        }
        $registers = '<table class="table table-bordered mw-100">
                          <thead>
                            <tr>
                              <th scope="col"><div class="text-center">Username</div></th>
                              <th scope="col"><div class="text-center">Name</div></th>
                              <th scope="col"><div class="text-center">Email</div></th>
                              <th scope="col"><div class="text-center">Status</div></th>
                              <th scope="col"><div class="text-center">Action</div></th>
                            </tr>
                          </thead>
                          <tbody>
                            '.$listyps.'
                          </tbody>
                        </table> ';

        return $registers;
    }
}