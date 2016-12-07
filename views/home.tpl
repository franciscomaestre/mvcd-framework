{extends file="./main.tpl"}

{block name=content}
    <div style="float:left; width:100%; height:auto;">
        <div style="margin:0px auto; width:90%; height:auto;">
            <div class="content_home">
                <div class="content_home_center">
                    <section class='destacados'>
                        <div class='ofertas'>

                            {if $destacados}

                                {foreach from=$destacados item=destacado}
                                    <div class='col-md-3 col-sm-6 col-xs-12' style="padding:0px 2px;">
                                        <article class='ofertaDestacado'>
                                            {if $offerHomePage}
                                                <div class='info-des-producto'>
                                                    {if $destacado->isEnvioGratis()}
                                                        <div class="promoGratisHomeD">Envío gratis</div>
                                                    {else}
                                                        <div class='destacadoD'>Destacados</div>
                                                    {/if}

                                                    {if $destacado->hasDiscount()}
                                                        <div class="discoRojoD"><span>{$destacado->getPorcentajeDescuentoShow()}</span></div>
                                                            {/if}

                                                </div>
                                                <div class="imagenD">
                                                    <div class="centerimagenD">
                                                        <a href='{$destacado->getUrl()}' 
                                                           onclick="productClick('{$destacado->getTextos()->getName()|escape:"quotes"}',
                                                                                 '{$destacado->getId()}',
                                                                                 '{$destacado->getPrecio()}',
                                                                                 '{$destacado->getUrl()}')">
                                                            <img  src='{$destacado->getGaleria()->getImagenPrincipal()->getUrl('grid')}'  alt='{$destacado->getGaleria()->getImagenPrincipal()->getAlt()}'/>
                                                        </a>
                                                    </div>
                                                </div>

                                            {/if}

                                            <h2 class='nombre_publicitarioD'>
                                                <a href='{$destacado->getUrl()}'
                                                   onclick="productClick('{$destacado->getTextos()->getName()|escape:"quotes"}',
                                                                         '{$destacado->getId()}',
                                                                         '{$destacado->getPrecio()}',
                                                                         '{$destacado->getUrl()}')">
                                                   {$destacado->getTextos()->getName()}</a>
                                            </h2>

                                            <section class='infoProductoD'>
                                                <div class="descripDestacado">

                                                    {if $destacado->hasDiscount()}
                                                        <div class='ahorroD'>
                                                            <img src="/img/as/ficha.png"><span>{__t('Te ahorras')}: <span>{$destacado->getPrecioAhorroShow()}</span></span>
                                                        </div>
                                                    {/if}
                                                </div>
                                                <div class='preciosD'>
                                                    <div class='ahoraD'>
                                                        <span>{$destacado->getPrecioShow()}</span>
                                                    </div>
                                                    {if $destacado->hasDiscount()}

                                                        <div class='antesD'>
                                                            <span>
                                                                <span>{$destacado->getPrecioRecomendadoShow()}</span>
                                                            </span>
                                                        </div>

                                                    {/if}
                                                </div>
                                            </section>

                                        </article>
                                    </div>
                                {/foreach}
                            {/if}

                        </div>

                    </section>
                    <section class='vendidosHome'>
                        <div class='vendidosOfertas'>
                            {foreach from=$vendidos key=ind item=vendido}
                                <div class='col-md-3 col-sm-6 col-xs-12' style="padding:0px 2px;">
                                    <article class='ofertaVendidos'>
                                        <div class='info-des-producto'>
                                            {if $vendido->isEnvioGratis()}
                                                <div class="promoGratisHomeV">ENVÍO GRATIS</div>
                                            {/if}

                                            {if $vendido->hasDiscount()}
                                                <div class="discoRojoV"><span>{$vendido->getPorcentajeDescuentoShow()}</span></div>
                                                    {/if}
                                        </div>
                                        <div class='imagenV'>
                                            <a href='{$vendido->getUrl()}'  
                                               onclick="productClick('{$vendido->getTextos()->getName()|escape:"quotes"}',
                                                                     '{$vendido->getId()}',
                                                                     '{$vendido->getPrecio()}',
                                                                     '{$vendido->getUrl()}')">
                                                <img src='{$vendido->getGaleria()->getImagenPrincipal()->getUrl('grid')}' alt='{$vendido->getGaleria()->getImagenPrincipal()->getAlt()}'>
                                            </a>
                                        </div>



                                        <h2 class='nombre_publicitarioV'>
                                            <a href='{$vendido->getUrl()}'
                                               onclick="productClick('{$vendido->getTextos()->getName()|escape:"quotes"}',
                                                                     '{$vendido->getId()}',
                                                                     '{$vendido->getPrecio()}',
                                                                     '{$vendido->getUrl()}')">                                           
                                               {$vendido->getTextos()->getName()}</a>
                                        </h2>

                                        <section class='infoProductoV'>
                                            <div class="descripDestacadoV">

                                                {if $vendido->hasDiscount()}
                                                    <div class='ahorroV'>
                                                        <img src="/img/as/ficha.png"><span>{__t('Te ahorras')}: <span>{$vendido->getPrecioAhorroShow()}</span></span>
                                                    </div>
                                                {/if}
                                            </div>
                                            <div class='preciosV'>
                                                <div class='ahoraV'>
                                                    <span>{$vendido->getPrecioShow()}</span>
                                                </div>
                                                {if $vendido->hasDiscount()}

                                                    <div class='antesV'>
                                                        <span>
                                                            <span>{$vendido->getPrecioRecomendadoShow()}</span>
                                                        </span>
                                                    </div>

                                                {/if}
                                            </div>
                                        </section>
                                    </article>
                                </div>
                            {/foreach}

                        </div>

                    </section>
                </div>
            </div>
            <div class="lateral_home">
                {if $seccionesDestacadas}

                    <div class="secciones">

                        <div class=" rowmobile">

                            {foreach from=$seccionesDestacadas item=seccion}
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="{$seccion->getUrl()}">
                                        <div class="seccionesLateral">
                                            <span>{$seccion->getTitulo()}</span>
                                            <img src="{$seccion->getImagen()}" alt="{$seccion->getAlt()}">
                                        </div>
                                    </a>
                                </div>
                            {/foreach}

                        </div>
                    </div>
                {/if}
            </div>

        </div>
    </div>

{/block} {* end block content *}    
        
        
{*  --------------------------------------------------------- *}        
{block name=extra_bottom_scripts}
    <!-- BrainSINS Code Starts -->
    <script type="text/javascript">
        var BrainSINSData = {
           pageType: "home"
        };
    </script>
    <!-- BrainSINS Code Ends -->

    {* CRITEO Code Starts *}
    {include file='../../common/criteo_new/criteo_home.tpl'}
    {* CRITEO Code Ends *}


    <!-- Tag Manager Analytics -->
    {include file='../../common/analytics/product.tpl'}
    <!-- Tag Manager Analytics Ends -->
    
    <script>
        var section="home";
        var subsection="";
    </script>    
    
{/block}




