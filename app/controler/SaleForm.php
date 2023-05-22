<?php

/**
 * SaleForm class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class SaleForm extends Market
{

    public $dataclass;

    public function getData()
    {
        $this->dataclass = '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">Sale Form</h2>
                                        <h5 class="text-700 fw-semi-bold">Form of sale</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                            --------
                            </div>';
        return $this->dataclass;
    }
}