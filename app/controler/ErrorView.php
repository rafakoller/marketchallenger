<?php

/**
 * ErrorView class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class ErrorView
{

    public $dataclass;

    public function getData($action = null)
    {
        $this->dataclass = '<div class="pb-5">
                                <div class="row g-4">
                                    <div class="col-12 col-xxl-6">
                                      <div class="mb-8">
                                        <h2 class="mb-2">Ooops!</h2>
                                        <h5 class="text-700 fw-semi-bold">Something wrong is not right.</h5>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-between-center mb-4 g-3 p-4 pb-0 card overflow-hidden shadow">
                                <div class="row text-center">
                                    <h2>The URL informed is not correct!</h2>
                                </div>
                                <div class="row">
                                    <img src="../../includes/img/dontknow.png" class="mx-auto d-block img-fluid col-12 col-md-4">
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <a class="btn btn-primary mx-auto d-block" href="front.php?class=HomeView">Home</a>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>';
        return $this->dataclass;
    }
}