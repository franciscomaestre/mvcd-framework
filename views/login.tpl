{extends file="./main.tpl"}



{*  --------------------------------------------------------- *}
{block name=extra_head}
    <link rel="stylesheet" href="/css/login_bootstrap.css?t={filemtime('css/login_bootstrap.css')}">
{/block}



{*  --------------------------------------------------------- *}
{block name=content}

<div class="container">
    <form class="form-signin" action="/login/post" role="form" method="post">
        <h2 class="form-signin-heading">Inicia sesión para continuar</h2>
        <input id="email" name="email" type="email" class="form-control" placeholder="Email" required autofocus>
        <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
    </form>
</div>

{/block} {* end block content *}



{*  --------------------------------------------------------- *}
{block name=extra_bottom_scripts}

{/block}
