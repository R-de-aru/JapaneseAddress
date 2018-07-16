<?php
  //設定&関数読み込み
  require_once('config.php');
  require_once('./helper/db_helper.php');
  require_once('./helper/extra_helper.php');

  //var_dump(GETCSV);
  if (GETCSV==='ON') {
    header('Location:'.SITE_URL.'/csvget.php');
    exit();
  } else {
    header('Location:'.SITE_URL.'/search.php');
    exit();
  }
