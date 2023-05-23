<?php

/**
 * TypeProductList class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class TypeProductList extends Market
{

    const LIMITE = 10;
    public $dataclass;

    public function getData($action = null)
    {
        $pagecurr = 1;
        if(!empty($action['page']))
        {
            $pagecurr = $action['page'];
        }

        $offset = ($pagecurr == 1 || $pagecurr == 0)?0:($pagecurr - 1)*self::LIMITE;

        $db = new Connection();
        $con = $db->getConnection();

        $query = "SELECT * FROM product_type ORDER BY `type` ASC  LIMIT ".self::LIMITE."  OFFSET ".$offset.";";
        $querytot = "SELECT * FROM product_type ORDER BY `type`;";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $resultstot = mysqli_query($con, $querytot) or die(mysqli_error($con));

        $count = mysqli_num_rows($resultstot);
        $pages = ceil(($count / self::LIMITE));

        $listyps = '';
        foreach ($results as $res)
        {
            $listyps .= '<tr>
                          <th scope="row"><div class="text-center">'.$res['id'].'</div></th>
                          <td>'.$res['type'].'</td>
                          <td><div class="text-center">'.$res['tax'].'%</div></td>
                          <td>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <a href="front.php?class=TypeProduct&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-6 text-center"> 
                                    <a href="front.php?class=TypeProduct&action=0&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
                                </div>
                            </div>
                          </td>
                        </tr>';
        }

        $previous = (($pagecurr - 1)<=0)?" disabled":"";
        $next = (($pagecurr + 1) > $pages)?" disabled":"";
        $nenext = (($pagecurr + 2) > $pages)?" disabled":"";

        $this->dataclass = '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">List of type products</h2>
                                        <h5 class="text-700 fw-semi-bold">Type products list</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                                <div class="row p-5">
                                    <table class="table table-bordered mw-100">
                                      <thead>
                                        <tr>
                                          <th scope="col"><div class="text-center">Id</div></th>
                                          <th scope="col"><div class="text-center">Type</div></th>
                                          <th scope="col"><div class="text-center">Tax</div></th>
                                          <th scope="col"><div class="text-center">Action</div></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        '.$listyps.'
                                      </tbody>
                                    </table> 
                                    <nav aria-label="Page navigation example">
                                      <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                          <a class="page-link'.$previous.'" href="front.php?class=TypeProductList&page='.($pagecurr - 1).'" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="front.php?class=TypeProductList&page='.$pagecurr.'">'.$pagecurr.'</a></li>
                                        <li class="page-item'.$next.'"><a class="page-link" href="front.php?class=TypeProductList&page='.($pagecurr + 1).'">'.($pagecurr + 1).'</a></li>
                                        <li class="page-item'.$nenext.'"><a class="page-link" href="front.php?class=TypeProductList&page='.($pagecurr + 2).'">'.($pagecurr + 2).'</a></li>
                                        <li class="page-item">
                                          <a class="page-link'.$next.'" href="front.php?class=TypeProductList&page='.($pagecurr + 1).'">Next</a>
                                        </li>
                                      </ul>
                                    </nav>                       
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <a class="btn btn-primary" href="front.php?class=TypeProductForm">Add Product</a>
                                    </div>
                                </div>
                                <br>
                            </div>';
        return $this->dataclass;
    }
}