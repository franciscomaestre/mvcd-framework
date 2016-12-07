{extends file="./main.tpl"}



{*  --------------------------------------------------------- *}
{block name=extra_head}
    <link rel="stylesheet" href="/css/pikaday.css?t={filemtime('css/pikaday.css')}">
    <link rel="stylesheet" href="/css/header.css?t={filemtime('css/header.css')}">

{/block}



{*  --------------------------------------------------------- *}
{block name=content}
    <section class="contenedor">
        <h1 class="titulo_seccion">Ventas desde {$date->getInitialDate()|date_format:"%Y-%m-%d"} hasta {$date->getEndDate()|date_format:"%Y-%m-%d"}</h1></br>
        <div class="row">
            <div class="col-md-3">
                <select id="estado_contrareembolso" class="form-control" style="margin-top: 25px; margin-bottom: 25px;">
                    <option value='0' {if $codStatus == 0}selected{/if}>Contrareembolso Pagados y No Pagados</option>
                    <option value='1' {if $codStatus == 1}selected{/if}>Contrareembolso Pagados</option>
                </select>
            </div>
            <div class="col-md-2">
                <input id="initialDate" type="text"class="form-control" placeholder="Fecha Inicio: YYYY-MM-DD" style="margin-top: 25px; margin-bottom: 25px;" value="{$date->getInitialDate()|date_format:"%Y-%m-%d"}">
            </div>
            <div class="col-md-2">
                <input id="endDate" type="text"class="form-control" placeholder="Fecha Fin: YYYY-MM-DD" style="margin-top: 25px; margin-bottom: 25px;" value="{$date->getEndDate()|date_format:"%Y-%m-%d"}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success" onclick="reporte()">Mostrar informe</button>&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-success" onclick="export_to_excel()">Exportar a Excel</button>
            </div>
        </div>
        <table class="table" style="text-align: center;">
            <thead class="header_tabla">
            <tr>
                <th>Tienda</th>
                <th>Dia</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Pedido ref</th>
                <th>Producto id</th>
                <th>Producto Nombre</th>
                <th>IVA</th>
                <th>Merchant</th>
                <th>PVP producto Unitario(sin IVA)</th>
                <th>Cantidad producto</th>
                <th>PVP producto Total(sin iva)</th>
                <th>PVP Gastos Envío (sin iva)</th>
                <th>PVP Extra Contrareembolso (sin iva)</th>
                <th>Venta Total (sin iva)</th>
                <th>Coste producto unitario(sin iva)</th>
                <th>Coste Total producto(sin iva)</th>
                <th>Margen % unitario de producto</th>
                <th>Coste envio(sin iva)</th>
                <th>Forma de pago</th>
                <th>Coste Otros TPV</th>
                <th>Coste Otros PayPal</th>
                <th>Coste Otros Callcenter(sin iva)</th>
                <th>Coste Contrareembolso(sin iva)</th>
                <th>Coste Total(sin iva)</th>
                <th>Margen Venta (sin iva)</th>
                <th>Reparto Partner (sin iva)</th>
                <th>Reparto Grupeo(sin iva)</th>
                <th>Pagado</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$order->getLines() item=orderLine}
                    <tr>
                        <td>{$shop->getText()->getName()}</td>
                        <td>{$orderLine->getDate()|date_format:"%d"}</td>
                        <td>{$orderLine->getDate()|date_format:"%m"}</td>
                        <td>{$orderLine->getDate()|date_format:"%Y"}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    {*
                    {if (!$pedidoLinea->getCartilla() || !$pedido->getTienda()->isCartillaSeparada())}
                        <tr>
                            <td>{$pedido->getNombreTienda()}</td><!-- Nombre tienda -->
                            <td>{strtotime($pedido->getFecha())|date_format:"%d"}</td><!-- Día -->
                            <td>{strtotime($pedido->getFecha())|date_format:"%m"}</td><!-- Mes -->
                            <td>{strtotime($pedido->getFecha())|date_format:"%Y"}</td><!-- Año -->
                            <td>{$pedido->getReferencia()}</td><!-- Pedido ref -->
                            <td>{$pedidoLinea->getProducto()->getId()}</td><!-- Id Producto -->
                            <td>{$pedidoLinea->getNombreFactura()}</td><!-- Nombre Producto -->
                            <td>{$pedidoLinea->getIVA()}</td><!-- Iva del producto -->
                            <td>{$pedidoLinea->getProducto()->getMerchant()->getNombre()}</td><!-- Merchant -->
                            <td>{$pedidoLinea->getPrecioFacturaSinIVAShow()}</td><!-- Precio Venta Unitario Sin IVA -->
                            <td>{$pedidoLinea->getCantidad()}</td><!-- Cantidad -->
                            <td>{$pedidoLinea->getSubTotalSinIVAShow()}</td><!-- Subtotal Sin Iva -->
                            <td>{$pedidoLinea->getGastosEnvioSinIVAShow()}</td><!-- Gastos Envio Sin Iva -->
                            <td>{$pedidoLinea->getComisionExtraSinIVAShow()}</td><!-- Extra Contrareembolso Sin Iva -->
                            <td>{$pedidoLinea->getImporteVentaSinIVAShow()}</td><!-- Venta Total Sin Iva -->
                            <td>{$pedidoLinea->getCosteFacturaSinIVAShow()}</td><!-- Coste Unitario sin Iva -->
                            <td>{$pedidoLinea->getSubTotalCosteSinIVAShow()}</td><!-- Subtotal Coste sin iva -->
                            <td>{$pedidoLinea->getPorcentajeMargenUnitarioShow()}</td><!-- % Margen Unitario Producto -->
                            <td>{$pedidoLinea->getCosteEnvioSinIVAShow()}</td><!--  -->
                            <td>{$pedido->getMetodoPago()}</td><!--  -->
                            {if $pedido->getMetodoPago() == 'sabadell'}
                                <td>{$pedidoLinea->getComisionesPasarelaShow()}</td><!--  -->
                                <td>0,00</td>
                            {else}
                                <td>0,00</td>
                                <td>{$pedidoLinea->getComisionesPasarelaShow()}</td><!--  -->
                            {/if}
                            <td>{$pedidoLinea->getComisionesCallcenterSinIVAShow()}</td>
                            <td>{$pedidoLinea->getCosteContrareembolsoSinIVAShow()}</td><!--  -->
                            <td>{$pedidoLinea->getCosteVentaSinIVAShow()}</td><!--  -->
                            <td>{$pedidoLinea->getMargenVentaSinIVAShow()}</td><!-- Margen Productos -->
                            <td>{$pedidoLinea->getRepartoVentaMedioSinIVAShow()}</td><!--  -->
                            <td>{$pedidoLinea->getRepartoVentaGrupeoSinIVAShow()}</td><!--  -->
                            <td>{if $pedido->getPagado() == 1}Si{else}No{/if}</td>
                        </tr>
                    {/if}
                    *}
            {/foreach}

            </tbody>
        </table>
    </section>
{/block} {* end block content *}



{*  --------------------------------------------------------- *}
{block name=extra_bottom_scripts}
    <script src="/js/moment.js?t={filemtime('js/moment.js')}"></script>
    <script src="/js/pikaday.js?t={filemtime('js/pikaday.js')}"></script>
    <script src="/js/report.js?t={filemtime('js/report.js')}"></script>

    <script type="text/javascript">
        var pickerStart = new Pikaday(
                {
                    field: document.getElementById('initialDate'),
                    format: 'YYYY-MM-DD',
                    minDate: new Date('2012-12-01'),
                    maxDate: new Date(),
                    yearRange: [2012,2016]
                });

        var pickerEnd = new Pikaday(
                {
                    field: document.getElementById('endDate'),
                    format: 'YYYY-MM-DD',
                    minDate: new Date('2012-12-01'),
                    maxDate: new Date(),
                    yearRange: [2012,2016]
                });

        pickerEnd.gotoToday();
    </script>

{/block}
