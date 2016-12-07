<!DOCTYPE html>
<html lang='es'>
    <!-- tc {$smarty.now} -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link type="image/x-icon" rel="shortcut icon" href="/application/assets/img/favicon.ico" >

        <title>Grupeo Tool</title>

        <link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="/css/reset.css">-->

        {* extra_head block. style... *}
        {block name=extra_head}{/block}
        {* extra_head block *}

</head>
<body>

    {* ---------------------- head ----------------------- *}
    {include file="./header.tpl" allowedShops=$allowedShops|default:false adminShop=$adminShop|default:false}
    {* ---------------------- head end ------------------- *}


    {* ---------------------- content block ----------------------*}
    {block name=content}{/block}
    {* ---------------------- content block ----------------------*}


    {* ---------------------- footer ---------------------- *}
    {include file="./footer.tpl"}
    {* ---------------------- footer ---------------------- *}
    
    
    <!-- Admin Ops  -->

    <script src='/js/admin.js'></script>

    {* scripts. TODO: mirar que es de la home o de otras paginas  *}

    <!-- Latest compiled and minified JavaScript -->

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    {* ---------------------- extra_bottom_scripts ---------------------- *}
    {block name=extra_bottom_scripts}{/block}
    {* ---------------------- extra_bottom_scripts ---------------------- *}


</body>
</html>
