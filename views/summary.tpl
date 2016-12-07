{extends file="./main.tpl"}



{*  --------------------------------------------------------- *}
{block name=extra_head}
    <link rel="stylesheet" href="/css/pikaday.css?t={filemtime('css/pikaday.css')}">
    <style>
        .nav-sidebar > .active > a,
        .nav-sidebar > .active > a:hover,
        .nav-sidebar > .active > a:focus {
            color: #fff;
            background-color: #428bca;
        }

        .nav-sidebar li {
            cursor: pointer;
        }

        .datas {
            float: left;
            visibility: hidden;
            position: absolute;
        }

        .datas.active {
            visibility: visible;
            position: absolute;
        }

        ul.summaryReport {
            list-style: none;
            padding: 0;
        }

        ul.summaryReport p{
            margin: 0;
        }

        .pie-legend {
            list-style-type: none;
        }

        .chart-legend {
             margin-top: 40px;
        }

        .chart-legend li span{
            display: inline-block;
            width: 12px;
            height: 12px;
        }

        .chart-legend li{
            margin-bottom: 5px;
        }

    </style>
{/block}



{*  --------------------------------------------------------- *}
{block name=content}

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <ul class="nav nav-sidebar">
                <li id="btn-pedidos-kpis" class="active"><a>Pedidos</a></li>
                <li id="btn-productos-importes-kpis"><a>Productos e Importes</a></li>
                <li id="btn-datos-resumen-kpis"><a>Datos Resumen</a></li>
                <li id="btn-informes-usuarios-kpis"><a>Informes de usuarios</a></li>
                <li id="btn-datos-top-10"><a>Top 10 Categorías y Productos</a></li>
            </ul>
        </div>
        <div class="col-sm-10">
            <div>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-2">
                        <input id="initDate" type="text"class="form-control" placeholder="Fecha Inicio: YYYY-MM-DD" style="margin-top: 25px; margin-bottom: 25px;" value="{date('Y-m-d',strtotime($initDate))}">
                    </div>
                    <div class="col-md-2">
                        <input id="endDate" type="text"class="form-control" placeholder="Fecha Fin: YYYY-MM-DD" style="margin-top: 25px; margin-bottom: 25px;" value="{date('Y-m-d',strtotime($endDate))}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="show_summary" class="btn btn-success" style="margin-top: 25px; margin-bottom: 25px;" onclick="resumen()">Mostrar informe</button>
                    </div>
                </div>
            </div>
            <div id="pedidos-kpis" class="datas active">
                <h1>KPIs - Pedidos</h1>
                <div style="float:left; width:100%; height:auto;margin-bottom: 20px;">
                    <div id="chart-callcenter" style="width: 750px; height: 400px; display: inline-block"></div>
                </div>
            </div>
            <div id="productos-importes-kpis" class="datas" style="width: 100%;" >
                <h1>KPIs - Productos e Importes</h1>
                <div id="chartline-sold_products_amount_days" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-average_shopping_basket-days" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-sold_products_amount_months" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-margin_growth_months" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-online_savingBook_month" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-online_savingBook_percent_income_month" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-online_savingBook_income_month" style="width: 100%; cursor: col-resize;"></div>
                {if $shop->getId() == $ELPAIS_SHOP_ID}
                <div id="chartline-budget-month" style="width: 100%;  cursor: col-resize;"></div>
                {/if}
                <div id="chartline-average_shopping_basket-month" style="width: 100%; cursor: col-resize;"></div>
            </div>
            <div id="datos-resumen-kpis" class="datas">
                <h1>Datos Resumen</h1>
                <div style="margin: 20px 0 0 0; width:60%; height:auto; padding: 10px;">
                    <button type="submit" class="btn btn-success" id="btn-export-resumen">Exportar tabla</button>
                    <div  class="table_resumen" style="float:left; height:auto; margin-bottom: 10px;">
                        <ul class="summaryReport" id="resumenTable" style="list-style: none">
                            <li><p>Número de pedidos PayPal</p><span id="value-n_paypal">{$summaryReport['paypal']}</span></li>
                            <li><p>Número de pedidos TPV</p><span id="value-n_sabadell">{$summaryReport['TPV']}</span></li>
                            <li><p>Número de pedidos Contrareembolso</p><span id="value-n_contrareembolso">{$summaryReport['COD']}</span></li>
                            <li><p>Número de pedidos ClickCanarias</p><span id="value-n_clickcanarias">{$summaryReport['clickcanarias']}</span></li>
                            {if $shop->getId() == $GRUPEO_SHOP_ID}
                                <li><p>Número de pedidos Aplazame</p><span id="value-n_aplazame">{$summaryReport['aplazame']}</span></li>
                            {/if}
                            <li><p>Número de pedidos CallCenter</p><span id="value-n_callcenter">{$summaryReport['callcenter']}</span></li>
                            <li><p>Promedio de productos vendidos por día</p><span>{$summaryReport['salesDayAverage']}</span></li>
                            <li><p>Promedio de productos vendidos por mes</p><span>{$summaryReportMonth['salesMonthAverage']}</span></li>
                            <li><p>Cantidad de productos</p><span id="value-n_cantidad_productos">{$summaryReport['productQuantity']}</span></li>
                            <li><p>Número total de pedidos</p><span id="value-n_total">{$summaryReport['orderQuantity']}</span></li>
                            <li><p>Número de registros nuevos</p><span id="value-n_registros_nuevos">{$summaryReport['newUsersQuantity']}</span></li>
                            <li><p>PVP Producto</p><span id="value-pvp_producto">{$summaryReport['productPrice']}</span></li>
                            <li><p>% cartilla vs total</p><span id="value-porcen_cartilla">{$summaryReport['percenOrderSavingBook']}</span></li>
                            <li><p>% online vs total</p><span id="value-porcen_online">{$summaryReport['percenOrderOnline']}</span></li>
                            <li><p>PVP Envío</p><span id="value-pvp_envio">{$summaryReport['shippingCharges']}</span></li>
                            <li><p>PVP Contrareembolso</p><span id="value-pvp_contrareembolso">{$summaryReport['extraCommission']}</span></li>
                            <li><p>Ingresos cartilla</p><span id="value-ingresos_cartilla">{$summaryReport['incomeSavingBook']}</span></li>
                            <li><p>% ingresos cartilla</p><span id="value-porcen_ingresos_cartilla">{$summaryReport['percenIncomeOrderSavingBook']}</span></li>
                            <li><p>Ingresos online</p><span id="value-ingresos_online">{$summaryReport['incomeOnline']}</span></li>
                            <li><p>% ingresos online</p><span id="value-porcen_ingresos_cartilla">{$summaryReport['percenIncomeOrderOnline']}</span></li>
                            <li><p>Total Ingresos</p><span id="value-total_ingresos">{$summaryReport['totalIncome']}</span></li>
                            <li><p>Costes TPV</p><span id="value-costes_sadabell">{$summaryReport['tpvCosts']}</span></li>
                            <li><p>Costes Paypal</p><span id="value-costes_paypal">{$summaryReport['paypalCosts']}</span></li>
                            <li><p>Costes Callcenter</p><span id="value-costes_callcenter">{$summaryReport['callcenterCosts']}</span></li>
                            <li><p>Costes Contrareembolso</p><span id="value-costes_contrareembolso">{$summaryReport['codCosts']}</span></li>
                            <li><p>Costes Producto</p><span id="value-costes_producto">{$summaryReport['productCosts']}</span></li>
                            <li><p>Costes Envio</p><span id="value-costes_envio">{$summaryReport['shippingCosts']}</span></li>
                            <li><p>Total Costes</p><span id="value-total_costes">{$summaryReport['totalCosts']}</span></li>
                            <li><p>Margen Partner Publicitario</p><span id="value-margen_partner_publicitario">{$summaryReport['advertisingPartnerMargin']}</span></li>
                            <li><p>Margen Final Grupeo</p><span id="value-margen_final_grupeo">{$summaryReport['finalGrupeoMargin']}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="informes-usuarios-kpis" class="datas" style="width: 100%;" >
                <h1>KPIs - Informes de usuarios</h1>
                <div id="chartline-growth_rate_users" style="width: 100%; cursor: col-resize;"></div>
                <div id="chartline-average_shopping-month" style="width: 100%; cursor: col-resize;"></div>
            </div>
            <div id="datos-top-10" class="datas">
                <h1>Top 10 Categorías y Productos</h1>
                <div style="margin: 20px 0 0 0; width:60%; height:auto; padding: 10px;">
                    <p style="text-align: center; font-weight: bold;margin-bottom: 20px; float:left; width:100%; ">Top 10 categorías</p>
                    {foreach from=$topCategory->getLines() key="ind" item=categoryLine}
                        <div class="col-md-6">
                            <p style="float: left; width:100%; height:auto; margin-bottom: 10px;"><span style="font-weight: bold;margin-right: 5px;">{$ind+1}.</span> {$shop->getText()->getName()} | {$categoryLine->getCategoryName()}</p>
                        </div>
                    {/foreach}
                    <br />
                    <p style="text-align: center; font-weight: bold;margin-bottom: 20px; float:left; width:100%; ">Top 10 productos</p>
                    {foreach from=$topProduct->getLines() key="ind" item=productLine}
                        <div class="col-md-6" style="height: 100px;">
                            <div style="display:inline-block; vertical-align: middle; height: 100%;margin-right:5px;width: 20px;float:left;"><span style="font-weight: bold;">{$ind+1}.</span></div>
                            <div style="display:inline-block; vertical-align: middle;margin: 0px 0px;float:left; width:calc(100% - 100px); height:100%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                <span>{$productLine->getProductName()}</span><br>
                                <span style="font-weight: bold;">Cantidad: </span><span>{$productLine->getQuantity()}</span> | <span style="font-weight: bold;">Importe: </span><span>{$productLine->getAmount()}</span>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>


{/block} {* end block content *}



{*  --------------------------------------------------------- *}
{block name=extra_bottom_scripts}
    <script src="/js/moment.js"></script>
    <script src="/js/pikaday.js"></script>
    <script src="/js/csv.js"></script>
    <!--<script src="/js/Chart.min.js"></script> <!-- Quitar Chart min js -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $('.nav-sidebar li').click(function() {
            $('.nav-sidebar li').removeClass('active');
            $(this).addClass('active');

            $('.datas').removeClass('active');
            $("#"+($(this).attr('id')).substr(4,($(this).attr('id')).length)).addClass('active'); //Corregir esto
        });

        $('#show_summary').click(function() {
            window.location = "/summary/kpis/"+$('#initDate').val()+"/"+$('#endDate').val();
        });

        moment.locale('es');

        var pickerInicio = new Pikaday(
            {
                field: document.getElementById('initDate'),
                format: 'YYYY-MM-DD',
                minDate: new Date('2012-12-01'),
                maxDate: new Date(),
                yearRange: [2012,2016]
            });

        var pickerFin = new Pikaday(
            {
                field: document.getElementById('endDate'),
                format: 'YYYY-MM-DD',
                minDate: new Date('2012-12-01'),
                maxDate: new Date(),
                yearRange: [2012,2016]
            });

        window.addEventListener("load", function() {
            $('#btn-export-resumen').on('click', function() {
                list2CSV('resumenTable','resumen');
            });
        });
    </script>

    <!----------------------- Scripts KPIS - Orders ------------------------>

    <!------------------------- 3. Callcenter Orders ------------------------->
    <script>
        function callcenterOrders() {
            var value_pedidos_total = {$summaryReport['orderQuantity']};
            var value_pedidos_callcenter = {$summaryReport['callcenter']};

            var value_pedidos = value_pedidos_total - value_pedidos_callcenter;

            {literal}
            var data = google.visualization.arrayToDataTable([
                ['Coste',            'Valor'],
                ['Pedidos Callcenter: ' + value_pedidos_callcenter, value_pedidos_callcenter],
                ['Pedidos web: ' + value_pedidos, value_pedidos]
            ]);

            var options = {
                title: 'Pedidos Callcenter vs Pedidos Totales'
            };

            var chartCallcenter = new google.visualization.PieChart(document.getElementById('chart-callcenter'));

            chartCallcenter.draw(data, options);
            {/literal}
        }

    </script>



    <!------------------------- 5. Products sold day and Income products day ------------------------->
    <script>
        function soldProductsAndIncomeDays() {

            {literal}
            var chartDiv = document.getElementById('chartline-sold_products_amount_days');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Day');
            data.addColumn('number', "Número de productos");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Importe");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
            {foreach from=$summaryReport['daysRanges'] key=key item=day}
                [new Date('{$day}'), {$summaryReport['productQuantityDays'][$key]}, '{$summaryReport['productQuantityDays'][$key]}',
                    {$summaryReport['totalAmountDays'][$key]->getValueInEuros()}, '{$summaryReport['totalAmountDays'][$key]}'],
            {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Número de productos e importes por día',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Número de productos'},
                    1: {title: 'Importe por día'}
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReport['daysRanges'] key=key item=day}
                            new Date('{$day}'),
                        {/foreach}
                        {literal}
                    ]
                }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>

    <!------------------------- 6. averageShoppingBasketDays ------------------------->
    <script>
        function  averageShoppingBasketDays() {

            {literal}
            var chartDiv = document.getElementById('chartline-average_shopping_basket-days');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'days');
            data.addColumn('number', "Importe pedidos/nº pedidos");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Cesta media rango");
            {/literal}

            data.addRows([
                {foreach from=$summaryReport['daysRangesShoppingBasket'] key=key item=day}
                [new Date('{$day}'), {$summaryReport['averageShoppingBasketDay'][$key]->getValueInEuros()}, '{$summaryReport['averageShoppingBasketDay'][$key]}', {$summaryReport['valueAverageShoppingBasket']->getValueInEuros()}],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Cesta media por día',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},

                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Importe pedidos/nº pedidos'},

                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReport['daysRanges'] key=key item=day}
                        new Date('{$day}'),
                        {/foreach}
                        {literal}
                    ]
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>

    <!------------------------- 7. Products sold month ------------------------->
    <script>
        function soldProductsAndIncomeMonths() {

            {literal}
            var chartDiv = document.getElementById('chartline-sold_products_amount_months');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "Número de productos");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Importe");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['productQuantityMonth'][$key]}, '{$summaryReportMonth['productQuantityMonth'][$key]}',
                    {$summaryReportMonth['totalAmountMonth'][$key]->getValueInEuros()}, '{$summaryReportMonth['totalAmountMonth'][$key]}'],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Número de productos e importes por mes',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Número de productos'},
                    1: {title: 'Importe por mes'}
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>


    <!------------------------- 8. Margin and Growth Month ------------------------->
    <script>
        function marginMonthAndGrowthMonth() {

            {literal}
            var chartDiv = document.getElementById('chartline-margin_growth_months');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "Margen");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Tasa de crecimiento");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['salesMarginMonth'][$key]->getValueInEuros()}, '{$summaryReportMonth['salesMarginMonth'][$key]}',
                    {$summaryReportMonth['growthRateMonth'][$key]}, '{$summaryReportMonth['growthRateMonth'][$key]} %'],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Margen (en €) y Tasa de crecimiento (en %)',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Margen'},
                    1: {title: 'Tasa de crecimiento'}
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>
    <!------------------------- 9. onlineSavingBookMonth ------------------------->

    <script>
    function onlineSavingBookMonth() {

        {literal}
        var chartDiv = document.getElementById('chartline-online_savingBook_month');

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Month');
        data.addColumn('number', 'Online');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addColumn('number', 'Cartilla');
        data.addColumn({type: 'string', role: 'annotation'});

        {/literal}


        data.addRows([
            {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                    [new Date('{$month}'), {$summaryReportMonth['percenOrderOnlineMonth'][$key]},'{$summaryReportMonth['percenOrderOnlineMonth'][$key]} %',
                    {$summaryReportMonth['percenOrderSavingBookMonth'][$key]},'{$summaryReportMonth['percenOrderSavingBookMonth'][$key]} %'],
            {/foreach}
        ]);

        {literal}
        var options = {
            title: 'Nº de pedidos online vs nº pedidos cartilla por mes (en %)',
            height: 350,
            annotations: {
                textStyle: {
                    fontSize: 12
                }
            },
            explorer: {
                maxZoomOut:8,
                keepInBounds: true,
                actions: ['dragToZoom', 'rightClickToReset']
            },
            vAxis: {
                title: 'online vs cartilla en %'
            },
            hAxis: {
                ticks: [
                    {/literal}
                    {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        {if $key gt ($summaryReportMonth['monthsRanges']|@count)-12}
                            new Date('{$month}'),
                        {/if}
                    {/foreach}
                    {literal}
                ],
                textStyle: {
                    italic: true
                }
            },
            legend: { position: 'top', alignment: 'start' }
        };

        var classicChart = new google.visualization.ColumnChart(chartDiv);
        classicChart.draw(data, options);
        {/literal}
    }
    </script>

    <!------------------------- 10. %online vs %saving book income month ------------------------->

    <script>
        function onlineSavingBookMonthPercentIncome() {

            {literal}
            var chartDiv = document.getElementById('chartline-online_savingBook_percent_income_month');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', 'Online');
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', 'Cartilla');
            data.addColumn({type: 'string', role: 'annotation'});

            {/literal}


            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['percenIncomeOrderOnlineMonth'][$key]},'{$summaryReportMonth['percenIncomeOrderOnlineMonth'][$key]} %',
                    {$summaryReportMonth['percenIncomeOrderSavingBookMonth'][$key]},'{$summaryReportMonth['percenIncomeOrderSavingBookMonth'][$key]} %'],
                {/foreach}
            ]);

            {literal}
            var options = {
                title: 'Ingresos online vs ingresos cartilla por mes (en %)',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxis: {
                    title: 'online vs cartilla en %'
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        {if $key gt ($summaryReportMonth['monthsRanges']|@count)-12}
                        new Date('{$month}'),
                        {/if}
                        {/foreach}
                        {literal}
                    ],
                    textStyle: {
                        italic: true
                    }
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.ColumnChart(chartDiv);
            classicChart.draw(data, options);
            {/literal}
        }
    </script>
    <!------------------------- 11. %income online vs %income saving book month ------------------------->

    <script>
        function onlineSavingBookMonthIncome() {

            {literal}
            var chartDiv = document.getElementById('chartline-online_savingBook_income_month');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', 'Online');
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', 'Cartilla');
            data.addColumn({type: 'string', role: 'annotation'});

            {/literal}


            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['incomeOnlineMonth'][$key]->getValueInEuros()},'{$summaryReportMonth['incomeOnlineMonth'][$key]}',
                    {$summaryReportMonth['incomeSavingBookMonth'][$key]->getValueInEuros()},'{$summaryReportMonth['incomeSavingBookMonth'][$key]}'],
                {/foreach}
            ]);

            {literal}
            var options = {
                title: 'Ingresos online vs ingresos cartilla por mes (en €)',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxis: {
                    title: 'online vs cartilla en €'
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        {if $key gt ($summaryReportMonth['monthsRanges']|@count)-12}
                        new Date('{$month}'),
                        {/if}
                        {/foreach}
                        {literal}
                    ],
                    textStyle: {
                        italic: true
                    }
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.ColumnChart(chartDiv);
            classicChart.draw(data, options);
            {/literal}
        }
    </script>

    <!------------------------- 12. Accumulated Margin VS Budget  ------------------------->
    <script>
        {if $shop->getId() == $ELPAIS_SHOP_ID}
        function  billingBudgetMonth() {

            {literal}
            var chartDiv = document.getElementById('chartline-budget-month');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "Margen acumulado");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Presupuesto");
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRangesAccumulatedMargin'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['salesMarginAccumulatedMonth'][$key]->getValueInEuros()}, '{$summaryReportMonth['salesMarginAccumulatedMonth'][$key]}', 185000],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Margen acumulado vs Presupuesto (185000 €) ',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},

                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Margen acumulado vs Presupuesto'},

                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRangesAccumulatedMargin'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
        {/if}
    </script>

    <!------------------------- 13. Growth Rate Users ------------------------->
    <script>
        function growthRateUsers() {

            {literal}
            var chartDiv = document.getElementById('chartline-growth_rate_users');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "Num. nuevos usuarios");
            data.addColumn({type: 'string', role: 'annotation'});
            data.addColumn('number', "Tasa de crecimiento");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['numUsersMonth'][$key]}, '{$summaryReportMonth['numUsersMonth'][$key]}',
                    {$summaryReportMonth['growthRateMonthUsers'][$key]}, '{$summaryReportMonth['growthRateMonthUsers'][$key]} %'],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Num. nuevos usuarios y Tasa de crecimiento (en %)',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Num. nuevos usuarios'},
                    1: {title: 'Tasa de crecimiento'}
                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>

    <!------------------------- 14. Average Shopping  ------------------------->
    <script>
        function  averageShoppingMonth() {

            {literal}
            var chartDiv = document.getElementById('chartline-average_shopping-month');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "nº pedidos/nº usuarios");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['averageShoppingMonth'][$key]}, '{$summaryReportMonth['averageShoppingMonth'][$key]}'],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Numero de compras media por comprador',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},

                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'nº pedidos/nº usuarios'},

                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>

    <!------------------------- 13. Growth Rate Users ------------------------->
    <script>
        function  averageShoppingBasketMonth() {

            {literal}
            var chartDiv = document.getElementById('chartline-average_shopping_basket-month');

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Month');
            data.addColumn('number', "Importe pedidos/nº pedidos");
            data.addColumn({type: 'string', role: 'annotation'});
            {/literal}

            data.addRows([
                {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                [new Date('{$month}'), {$summaryReportMonth['averageShoppingBasketMonth'][$key]->getValueInEuros()}, '{$summaryReportMonth['averageShoppingBasketMonth'][$key]}'],
                {/foreach}
            ]);


            {literal}
            var classicOptions = {
                title: 'Cesta media por mes',
                height: 350,
                annotations: {
                    textStyle: {
                        fontSize: 12
                    }// The transparency of the text.
                },
                explorer: {
                    maxZoomOut:8,
                    keepInBounds: true,
                    actions: ['dragToZoom', 'rightClickToReset']
                },
                // Gives each series an axis that matches the vAxes number below.
                series: {
                    0: {targetAxisIndex: 0},

                },
                vAxes: {
                    // Adds titles to each axis.
                    0: {title: 'Importe pedidos/nº pedidos'},

                },
                hAxis: {
                    ticks: [
                        {/literal}
                        {foreach from=$summaryReportMonth['monthsRanges'] key=key item=month}
                        new Date('{$month}'),
                        {/foreach}
                        {literal}
                    ]
                },
                legend: { position: 'top', alignment: 'start' }
            };

            var classicChart = new google.visualization.LineChart(chartDiv);
            classicChart.draw(data, classicOptions);
            {/literal}
        }
    </script>

    <!------------------------ Load Charts Google ----------------------------------->
    <script>
        {literal}
        google.charts.load('current', {'packages':['line','corechart','bar']});
        google.charts.setOnLoadCallback(drawCharts);
        function drawCharts() {
            callcenterOrders();
            soldProductsAndIncomeDays();
            averageShoppingBasketDays();
            soldProductsAndIncomeMonths();
            marginMonthAndGrowthMonth();
            onlineSavingBookMonth();
            onlineSavingBookMonthPercentIncome();
            onlineSavingBookMonthIncome();
            {/literal}
            {if $shop->getId() == $ELPAIS_SHOP_ID}
            billingBudgetMonth();
            {/if}
            {literal}
            growthRateUsers();
            averageShoppingMonth();
            averageShoppingBasketMonth();
        }
        {/literal}
    </script>
{/block}
