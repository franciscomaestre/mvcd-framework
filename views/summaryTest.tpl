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
            display: none;
        }

        .datas.active {
            display: block !important;
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
        <h1>Top 10</h1>
        <p style="text-align: center; font-weight: bold;margin-bottom: 20px; float:left; width:100%; ">Top 10 categorías</p>
        {foreach from=$topCategory->getLines() key="ind" item=categoryLine}
            <div class="col-md-6">
                <p style="float: left; width:100%; height:auto; margin-bottom: 10px;"><span style="font-weight: bold;margin-right: 5px;">{$ind+1}.</span> {$shop->getText()->getName()} | {$categoryLine->getCategoryName()}</p>
            </div>
        {/foreach}
        <p style="text-align: center; font-weight: bold;margin-bottom: 20px; float:left; width:100%; ">Top 10 productos</p>
        {foreach from=$topProduct->getLines() key="ind" item=productLine}
            <div class="col-md-6" style="height: 100px;">
                <div style="display:inline-block; vertical-align: middle; height: 100%;margin-right:5px;width: 20px;float:left;"><span style="font-weight: bold;">{$ind+1}.</span></div>
                <div style="display:inline-block; width:100px;float:left; margin:0px 10px 0px 0px;"><img src="{$productLine->getImage()}" class="img-thumbnail" style="max-height: 100px;float:left;"></div>
                <div style="display:inline-block; vertical-align: middle;margin: 24px 0px;float:left; width:calc(100% - 150px); height:100%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                    <span>{$productLine->getProductName()}</span><br>
                    <span style="font-weight: bold;">Cantidad: </span><span>{$productLine->getQuantity()}</span> | <span style="font-weight: bold;">Importe: </span><span>{$productLine->getAmount()}</span>
                </div>
            </div>
        {/foreach}
    </div>
</div>


{/block} {* end block content *}



{*  --------------------------------------------------------- *}
{block name=extra_bottom_scripts}
    <script src="/js/moment.js"></script>
    <script src="/js/pikaday.js"></script>
    <script src="/js/Chart.min.js"></script>
{/block}
