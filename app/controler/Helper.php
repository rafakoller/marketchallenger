<?php

/**
 * Helper class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Helper extends Connection
{

    public $dataclass;

    /**
     * Get a HTML modal
     * @param $id_modal
     * @param $title
     * @param $message
     * @param $msg_btn
     * @param $url
     * @param $class
     * @return string
     */
    public static function getModal($id_modal,$title,$message,$msg_btn,$url,$class = 'primary')
    {
        $dataclass = '<script>
                            $(document).ready(
                                function(){
                                    $("#'.$id_modal.'").modal("toggle");
                                }
                            );
                            function closeModal(element) {
                                $("#'.$id_modal.'").modal("toggle");
                            }
                        </script>
                        <div class="modal fade" id="'.$id_modal.'" tabindex="-1" role="dialog" aria-labelledby="'.$id_modal.'" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">'.$title.'</h5>
                                    <button onclick="closeModal(this);" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    '.$message.'
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="closeModal(this);" data-dismiss="modal">Close</button>
                                    <a href="'.$url.'" class="btn btn-'.$class.'">'.$msg_btn.'</a>
                                  </div>
                                </div>
                              </div>
                            </div>';
        return $dataclass;
    }

    /**
     * Get a html Pagination
     * @param $limite
     * @param $pagecurr
     * @param $table
     * @param $class
     * @return string|void
     */
    public static function getPagination($limite,$pagecurr,$table,$class)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $querytot = "SELECT * FROM `".$table."` ORDER BY `id`;";
        $resultstot = mysqli_query($con, $querytot) or die(mysqli_error($con));
        $count = mysqli_num_rows($resultstot);
        $pages = ceil(($count / $limite));

        $previous = (($pagecurr - 1)<=0)?" disabled":"";
        $next = (($pagecurr + 1) > $pages)?" disabled":"";
        $nenext = (($pagecurr + 2) > $pages)?" disabled":"";

        $pagination = '<nav>
                          <ul class="pagination justify-content-center">
                            <li class="page-item">
                              <a class="page-link'.$previous.'" href="front.php?class='.$class.'&page='.($pagecurr - 1).'" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="front.php?class='.$class.'&page='.$pagecurr.'">'.$pagecurr.'</a></li>
                            <li class="page-item'.$next.'"><a class="page-link" href="front.php?class='.$class.'&page='.($pagecurr + 1).'">'.($pagecurr + 1).'</a></li>
                            <li class="page-item'.$nenext.'"><a class="page-link" href="front.php?class='.$class.'&page='.($pagecurr + 2).'">'.($pagecurr + 2).'</a></li>
                            <li class="page-item">
                              <a class="page-link'.$next.'" href="front.php?class='.$class.'&page='.($pagecurr + 1).'">Next</a>
                            </li>
                          </ul>
                        </nav>';

        return $pagination;
    }

    /**
     * Get a html Pagination
     * @param $limite
     * @param $pagecurr
     * @param $table
     * @param $class
     * @return string|void
     */
    public static function getNavPOS($limite,$pagecurr,$table,$class)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $querytot = "SELECT * FROM `".$table."` ORDER BY `id`;";
        $resultstot = mysqli_query($con, $querytot) or die(mysqli_error($con));
        $count = mysqli_num_rows($resultstot);
        $pages = ceil(($count / $limite));

        $previous = (($pagecurr - 1)<=0)?'role="link" aria-disabled="true"':'href="front.php?class='.$class.'&page='.($pagecurr - 1).'"';
        $next = (($pagecurr + 1) > $pages)?'role="link" aria-disabled="true"':'href="front.php?class='.$class.'&page='.($pagecurr + 1).'"';

        $optionspage = '';
        for ($x=1;$x<=$pages;$x++)
        {
            $optionspage .= '<li class="page-item page-'.$x.'"><a class="page-link" href="front.php?class='.$class.'&page='.$x.'" onclick="$(\'#containerload\').show();">'.$x.'</a></li>';
        }

        $pagination = '<div class="row">
                            <div class="col-2 text-center text-white">
                                <a '.$previous.' onclick="$(\'#containerload\').show();"><i class="fa fa-backward fa-2x text-white" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-8 text-center">
                            <nav>
                              <ul class="pagination pagination-lg justify-content-center">
                                '.$optionspage.'
                              </ul>
                            </nav>
                            </div>
                            <div class="col-2 text-center text-white">
                                <a '.$next.' onclick="$(\'#containerload\').show();"><i class="fa fa-forward fa-2x text-white" aria-hidden="true"></i></a>
                            </div>
                        </div>';

        return $pagination;
    }
}