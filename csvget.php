<?php

  setlocale(LC_ALL, 'ja_JP.UTF-8');

  ini_set('memory_limit', '512M');

  require_once('config.php');
  require_once('./helper/db_helper.php');
  require_once('./helper/extra_helper.php');

  //CSV取り込み処理
  $csv = array();
  $kendata=array();
  $file = './csv/KEN_ALL.CSV';
  //エンコーディング処理
  $data = file_get_contents($file); // string型に変換
  $data = mb_convert_encoding($data, 'UTF-8', 'sjis-win'); //この関数を通すことで文字化けが解消される
  //初期化・一時ファイル作成
  $temp = tmpfile();
  $csv  = array();
  $count=0;
  fwrite($temp, $data); //$tempファイルに、$dataの内容を書き込む。
  rewind($temp); //ファイルポインタを先頭の位置に戻す
  while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
    $data = implode(",", $data); //一行づつ、配列を","で連結して、文字列として返す
    $csv= explode(",", $data); //一行ずつ、カンマ区切りしたフィールドを配列の要素として扱う
    $kendata[$count]=$csv;
    $count+=1;
  }
  echo $count.'件のデータを配列に格納完了!!<br>';

  //MySQL取り込み処理
  // $dbh=get_db_connect();
  // if (table_exists($dbh,'address')) {
  //   echo "取り込み先テーブルは存在しています。";
  // } else {
  //   $dbh=get_db_connect();
  //   if(create_table_address($dbh,'address')){
  //     echo "取り込み先テーブルを作成し、データの取り込みを行います。";
  //   } else {
  //     die('テーブル作成失敗');
  //   }
  // }

  $count=0;
  $dbh=get_db_connect();
  foreach ($kendata as $row) {
    if ($row[8]!=='以下に掲載がない場合') {
      if (insert_ken($dbh,$row[2],$row[6],$row[3],$row[7],$row[4],$row[8],$row[5])===false) {
        die('Error!('.$row[6].$row[7].$row[8].')');
      }
      $count+=1;
    }
  }

  echo $count.'件のデータをMySQLに取り込み完了!!<br>';
