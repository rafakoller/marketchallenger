<?php

/**
 * TypeProductList class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class TypeProductList extends TypeProduct
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

        $registers = $this->getRegisters(self::LIMITE,$pagecurr);
        $pagination = $this->helper::getPagination(self::LIMITE,$pagecurr,'product_type');

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
                                    '.$registers.'
                                    '.$pagination.'                       
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