<?php

//Configuración de Mencache
define('MEMCACHED_INTERNAL_ENABLED', false);
define('MEMCACHED_SESSION_ENABLED', false);

define('DEFAULT_METHOD','render');

define('COD_ORDERS_ALL', 0);
define('COD_ORDERS_PAID', 1);

//Debug
define('DEBUG', true);
define('LOG_DEBUGENABLED', false);
define('LOG_FILENAME', '/var/log/grupeo/grupeo-tool%s.log');

define('COD_ALL', 0);
define('COD_PAYED', 1);

define('GRUPEO_SHOP_ID', 1);
define('AS_SHOP_ID', 2);
define('ELPAIS_SHOP_ID', 7);

//IPs frontend y backend
define('FRONTEND_IPS', '5.196.93.148,149.202.66.103,37.187.175.63');

//Configuracion memcached

define('MEMCACHED_INTERNAL_HOST', 'localhost');
define('MEMCACHED_INTERNAL_PORT', 11211);
define('MEMCACHED_INTERNAL_MAX_LIFE_TIME', 86400);
