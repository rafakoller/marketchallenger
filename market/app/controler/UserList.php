<?php

/**
 * TypeProductList class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class UserList extends User
{

    const LIMITE = 10;
    public $dataclass;

    public function getData($data = null)
    {
        $pagecurr = 1;
        if(!empty($data['page']))
        {
            $pagecurr = $data['page'];
        }

        $registers = $this->getRegisters(self::LIMITE,$pagecurr);
        $pagination = Helper::getPagination(self::LIMITE,$pagecurr,'user','UserList');

        $status = (!empty($data['mode']) && $data['mode'] == 1) ? 'actived ' : 'inactived ';
        $modal = '';
        if (!empty($data['status']) && $data['status'] == 'defined') {
            $modal = Helper::getModal('confirmChangStatus','User status '.$status.'','This user has '.$status.'.','Ok','front.php?class=UserList','info');
        } else if (!empty($data['status']) && $data['status'] == 'yourself') {
            $modal = Helper::getModal('confirmYourself','Your status not change!','It`s not possible change your own state.','Ok','front.php?class=UserList','info');
        }

        $this->dataclass = $modal.'<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">List of Users</h2>
                                        <h5 class="text-700 fw-semi-bold">Users registered in system</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                                <div class="row p-5">
                                    '.$registers.'
                                    '.$pagination.'                       
                                </div>
                                <br>
                            </div>';
        return $this->dataclass;
    }
}