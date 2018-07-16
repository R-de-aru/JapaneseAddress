<?php
  //設定&関数読み込み
  require_once('config.php');
  require_once('./helper/db_helper.php');
  require_once('./helper/extra_helper.php');

  if (isset($_GET['addno']) or isset($_GET['add1']) or isset($_GET['add2']) or isset($_GET['add3'])) {
    $addno=$_GET['addno'];
    $addno=html_escape($addno);
    $add1=$_GET['add1'];
    $add1=html_escape($add1);
    $add2=$_GET['add2'];
    $add2=html_escape($add2);
    $add3=$_GET['add3'];
    $add3=html_escape($add3);
    $page=$_GET['page'];
    $page=(int)html_escape($page);
    $result=[];
    $tmpcount=0;
    $count=0;
    $dbh=get_db_connect();
    // 検索、レコード取得
    $result=search_address($dbh,$addno,$add1,$add2,$add3,$page);
    $tmpcount=count_address($dbh,$addno,$add1,$add2,$add3);
    $count=intval($tmpcount['count']);
    //var_dump($result);// int(0)を返してくる
    //var_dump($result);
    //var_dump($count);
  }

  //都道府県一覧を取得して配列にセット
  $ken=[];
  $dbh=get_db_connect();
  $ken=get_ken($dbh);
  //var_dump($ken);

  //検索・表示用PHPファイル呼び出し
  include_once('./view/search_view.php');
