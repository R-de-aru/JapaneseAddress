<?php
// MySQL接続用
define('DSN','mysql:dbname=address;host=localhost');
define('DB_USER','user');
define('DB_PASS','aaaa');

//住所録設定関連
define('GETCSV','ON');

//検索設定
define('SEARCH_DISP_LIMIT',100);

//その他
define('SITE_URL','http://192.168.33.11:8000');

error_reporting(E_ALL & ~E_NOTICE);
