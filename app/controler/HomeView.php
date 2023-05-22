<?php
require '../model/Market.php';

/**
 * HomeView class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class HomeView extends Market {

     public $dataclass;

     public function getData()
     {
         // get quantity of orders per day in last month
         $salastmonth = parent::getLastMonthOrders();
         $lastsells = '';
         foreach ($salastmonth as $day => $value){
             $lastsells .= '["'.$day.'",  '.$value.'],';
         }

         // get values of invoicing
         $amountCost = parent::getAmountCost();
         $amountTax = parent::getAmountTax();
         $amountProfit = parent::getAmountProfit();
         $amountCash = parent::getAmountCash();

         // convert in percent
         $perCost = ($amountCost / $amountCash) * 100;
         $perTax = ($amountTax / $amountCash) * 100;
         $perProfit = ($amountProfit / $amountCash) * 100;

         $this->dataclass = '<div class="pb-5">
          <div class="row g-4">
            <div class="col-12 col-xxl-6">
              <div class="mb-8">
                <h2 class="mb-2">Dashboard</h2>
                <h5 class="text-700 fw-semi-bold">Here’s what’s going on at your Market right now</h5>
              </div>
              <div class="row align-items-center g-4">
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/4l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountOrders().' new orders</h4>
                      <p class="text-800 fs--1 mb-0">Awating processing</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/3l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountTipeProducts().' tipes</h4>
                      <p class="text-800 fs--1 mb-0">Of Products</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-auto">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/2l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountProducts().' products</h4>
                      <p class="text-800 fs--1 mb-0">Ready for sale</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
      </div>
      <hr class="bg-200 mb-6 mt-4" />
              <div class="row flex-between-center mb-4 g-3">
                <div class="col-auto">
                  <h3>Sells in last month</h3>
                  <p class="text-700 lh-sm mb-0">Payment received across PDV</p>
                </div>
                <script type="text/javascript">
                      google.charts.load("current", {"packages":["corechart"]});
                      google.charts.setOnLoadCallback(drawChartSeller);
                      google.charts.setOnLoadCallback(drawChartInvoicingPercent);
                
                      function drawChartSeller() {
                        var datas = google.visualization.arrayToDataTable([
                          ["Day", "Sales"],
                          '.$lastsells.'
                        ]);
                
                        var optionss = {
                          vAxis: {minValue: 0}
                        };
                
                    var charts = new google.visualization.AreaChart(document.getElementById("chart_sells_month"));
                        charts.draw(datas, optionss);
                      }
                      
                      function drawChartInvoicingPercent() {
                        var datai = google.visualization.arrayToDataTable([
                          ["Tipe", "Value"],
                          ["Cost", '.$perCost.'],
                          ["Tax", '.$perTax.'],
                          ["Profit", '.$perProfit.']
                        ]);
                
                        var optionsi = {
                          pieHole: 0.4,
                        };
                
                    var charti = new google.visualization.PieChart(document.getElementById("chart_invoicings_percent"));
                        charti.draw(datai, optionsi);
                      }
                </script>
              </div>
              <div id="chart_sells_month" class="echart-total-sales-chart" style="min-height:320px;width:100%" data-echart-responsive="data-echart-responsive"></div>
              <hr class="bg-200 mb-6 mt-4" />
              <div class="row">
              <div id="chart_invoicings_values" class="echart-total-sales-chart col-6" style="min-height:320px;" data-echart-responsive="data-echart-responsive"></div>
              <div id="chart_invoicings_percent" class="echart-total-sales-chart col-6" style="min-height:320px;" data-echart-responsive="data-echart-responsive"></div>
              </div>';
         return $this->dataclass;
     }




}