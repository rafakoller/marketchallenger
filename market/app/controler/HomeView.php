<?php
require '../model/Market.php';

/**
 * HomeView class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class HomeView extends Market {

     public $dataclass;

     public function getData($action = null)
     {
         // get quantity of orders per day in last month
         $salastmonth = parent::getLastMonthOrders();
         $lastsells = '';
         foreach ($salastmonth as $day){
             $lastsells .= '["'.$day['day'].'",  '.$day['qnt'].', '.$day['invoicing'].'],';
         }

         // get products top sellers of month
         $topsellsMont = parent::getTopSelMonthProducts();
         $topsells = '';
         foreach ($topsellsMont as $prods){
             $topsells .= '["'.$prods['Product'].'", "'.$prods['Price/Tax'].'", "'.$prods['Profit'].'", "'.$prods['Quantity'].' products"],';
         }

         // get values of invoicing
         $amountCost = parent::getPriceCompose()['costed'] / parent::getPriceCompose()['count'];
         $amountTax = parent::getPriceCompose()['taxed'] / parent::getPriceCompose()['count'];
         $amountProfit = parent::getPriceCompose()['profited'] / parent::getPriceCompose()['count'];
         $amountCash = (parent::getPriceCompose()['costed'] + parent::getPriceCompose()['profited'] + parent::getPriceCompose()['taxed'])  / parent::getPriceCompose()['count'];

         // convert in percent
         $perCost = ($amountCost / $amountCash) * 100;
         $perTax = ($amountTax / $amountCash) * 100;
         $perProfit = ($amountProfit / $amountCash) * 100;

         $this->dataclass = '<div class="pb-5">
          <div class="row g-4">
            <div class="col-12">
              <div class="mb-8">
                <h2 class="mb-2">Dashboard</h2>
                <h5 class="text-700 fw-semi-bold">Here’s what’s going on at your Market right now</h5>
              </div>
              <div class="row align-items-center g-4">
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/4l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountProducts().' Products</h4>
                      <p class="text-800 fs--1 mb-0">Ready for sale</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/4l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountTypeProducts().' Types</h4>
                      <p class="text-800 fs--1 mb-0">Of Products</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/2l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">'.parent::getAmountOutOffProducts().' Products</h4>
                      <p class="text-800 fs--1 mb-0">Out off stock</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="d-flex align-items-center"><img src="https://prium.github.io/phoenix/v1.12.0/assets/img/icons/illustrations/3l.png" alt="" height="46" width="46" />
                    <div class="ms-3">
                      <h4 class="mb-0">$'.parent::getStockValue().'</h4>
                      <p class="text-800 fs--1 mb-0">Value of Stock</p>
                    </div>
                  </div>
                </div>
                
                
              </div>
          </div>
      </div>
      </div>
              <div class="row flex-between-center mb-4 g-3 card overflow-hidden shadow">
                <div class="col-auto p-3 pt-0 pb-0">
                  <h3>Sells in last month</h3>
                  <p class="text-700 lh-sm mb-0 p-3 pt-0 pb-0">Payment received across PDV</p>
                </div>
                <script type="text/javascript">
                      google.charts.load("current", {"packages":["corechart","table", "bar"]});
                      google.charts.setOnLoadCallback(drawChartSeller);
                      google.charts.setOnLoadCallback(drawTableTopSellers);
                      google.charts.setOnLoadCallback(drawChartInvoicingPercent);
                
                      function drawChartSeller() {
                        var datas = new google.visualization.DataTable();
                        datas.addColumn("string", "Day");
                        datas.addColumn("number", "Sales");
                        datas.addColumn("number", "Invoicing");
                        datas.addRows([
                            '.$lastsells.'
                        ]);
                
                        var optionss = {
                          series:{
                              0:{targetAxisIndex:0},
                              1:{targetAxisIndex:1}
                            },
                          vAxis:  {precision:0, baseline:0, minValue:0, format:"0"},
                          vAxes:  {
                              0: {title:"Sales"},
                              1: {title:"Invoicing"}
                            },
                          colors: ["#1cc88a", "#e74a3b"],
                        };
                
                    var charts = new google.visualization.AreaChart(document.getElementById("chart_sells_month"));
                        charts.draw(datas, optionss);
                      }
                      
                      function drawTableTopSellers() {
                            var datat = new google.visualization.DataTable();
                             datat.addColumn("string", "Product");
                             datat.addColumn("string", "Price/Tax");
                             datat.addColumn("string", "Profit");
                             datat.addColumn("string", "Quantity");
                             datat.addRows([
                              '.$topsells.'
                             ]);
                  
                            var optionst = {
                              showRowNumber: true, 
                              width: "100%", 
                              height: "100%"
                            };
                    
                        var table = new google.visualization.Table(document.getElementById("chart_top_sellers"));
                            table.draw(datat, optionst);
                          }
                      
                      function drawChartInvoicingPercent() {
                        var datai = google.visualization.arrayToDataTable([
                          ["Type", "Value"],
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
              <div id="chart_sells_month" class="echart-total-sales-chart" style="min-height:320px;width:100%" data-echart-responsive="data-echart-responsive"></div>
              </div>
              <div class="row pb-5">
                  <div class="col-sm-12 col-md-6">
                    <div class="card shadow p-3 pb-0 pt-1">
                        <div class="col-auto p-3 pb-4">
                          <h3>Top 10 best products</h3>
                          <p class="text-700 lh-sm mb-0 p-3 pt-0 pb-0">Best selling products in last 30 days</p>
                        </div>
                        <div id="chart_top_sellers" class="echart-total-sales-chart" style="min-height:320px;" ></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="card shadow">
                        <div class="col-auto p-3 pb-0">
                          <h3>Price Composition</h3>
                          <p class="text-700 lh-sm mb-0 p-3 pt-0 pb-0">Average price composition</p>
                        </div>
                        <div id="chart_invoicings_percent" class="echart-total-sales-chart" style="min-height:320px;" ></div>
                    </div>
                  </div> 
              </div><br>';
         return $this->dataclass;
     }




}