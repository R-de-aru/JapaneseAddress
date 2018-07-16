<?php
function get_db_connect(){
  try {
    $dsn=DSN;
    $user=DB_USER;
    $password=DB_PASS;
    $dbh=new PDO($dsn,$user,$password);
  } catch (PDOException $e) {
      echo $e->getMessage();
      die();
  }
  $dbh->setAttribute(PDO::ATTR_ERRMODE,ERRMODE_EXCEPTION);
  return $dbh;
}

function insert_ken($dbh,$addno,$add1,$add1kana,$add2,$add2kana,$add3,$add3kana){
  //sql作成
  $sql="insert into address(addno,add1,add1kana,add2,add2kana,add3,add3kana)
  values (:addno,:add1,:add1kana,:add2,:add2kana,:add3,:add3kana)";
  //プリペア、引数置換
  $stmt=$dbh->prepare($sql);
  $stmt->bindvalue(':addno',$addno,PDO::PARAM_STR);
  $stmt->bindvalue(':add1',$add1,PDO::PARAM_STR);
  $stmt->bindvalue(':add1kana',$add1kana,PDO::PARAM_STR);
  $stmt->bindvalue(':add2',$add2,PDO::PARAM_STR);
  $stmt->bindvalue(':add2kana',$add2kana,PDO::PARAM_STR);
  $stmt->bindvalue(':add3',$add3,PDO::PARAM_STR);
  $stmt->bindvalue(':add3kana',$add3kana,PDO::PARAM_STR);
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

function get_ken($dbh){
  $ken=[];
  $sql="select max(x.kenid) as id ,max(x.add1) as add1 from address as x group by x.add1 order by x.kenid asc";
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    $ken[]=$row;
  }
  return $ken;
}

function search_address($dbh,$addno,$add1,$add2,$add3,$pagecount){
  $result=[];
  $sql="select addno,add1,add2,add3 from address where 1=1";
  if ($addno!=='') {
    $sql=$sql." and addno like :addno";
  }
  if ($add1!=='指定しない') {
    $sql=$sql." and add1 like :add1";
  }
  if ($add2!=='') {
    $sql=$sql." and add2 like :add2";
  }
  if ($add3!=='') {
    $sql=$sql.=" and add3 like :add3";
  }
  $sql=$sql." order by addno limit :pagecount , :pagelimit";
  $stmt=$dbh->prepare($sql);
  if ($addno!=='') {
    $stmt->bindvalue(':addno','%'.$addno.'%',PDO::PARAM_STR);
  }
  if ($add1!=='指定しない') {
    $stmt->bindvalue(':add1','%'.$add1.'%',PDO::PARAM_STR);
  }
  if ($add2!=='') {
    $stmt->bindvalue(':add2','%'.$add2.'%',PDO::PARAM_STR);
  }
  if ($add3!=='') {
    $stmt->bindvalue(':add3','%'.$add3.'%',PDO::PARAM_STR);
  }
  $stmt->bindvalue(':pagecount',$pagecount,PDO::PARAM_INT);
  $stmt->bindvalue(':pagelimit',SEARCH_DISP_LIMIT,PDO::PARAM_INT);
  $stmt->execute();
  while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[]=$row;
  }
  return $result;
}

function count_address($dbh,$addno,$add1,$add2,$add3){
  $count=0;
  $sql="select count(addno) as count from address where 1=1";
  if ($addno!=='') {
    $sql=$sql." and addno like :addno";
  }
  if ($add1!=='指定しない') {
    $sql=$sql." and add1 like :add1";
  }
  if ($add2!=='') {
    $sql=$sql." and add2 like :add2";
  }
  if ($add3!=='') {
    $sql=$sql.=" and add3 like :add3";
  }
  $stmt=$dbh->prepare($sql);
  if ($addno!=='') {
    $stmt->bindvalue(':addno','%'.$addno.'%',PDO::PARAM_STR);
  }
  if ($add1!=='指定しない') {
    $stmt->bindvalue(':add1','%'.$add1.'%',PDO::PARAM_STR);
  }
  if ($add2!=='') {
    $stmt->bindvalue(':add2','%'.$add2.'%',PDO::PARAM_STR);
  }
  if ($add3!=='') {
    $stmt->bindvalue(':add3','%'.$add3.'%',PDO::PARAM_STR);
  }
  $stmt->execute();
  //$countflg!==0の場合、件数を取得
  while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    $count=$row;
  }
  return $count;
}

function table_exists($dbh,$table){
  $sql="show tables like :table";
  $stmt=$dbh->prepare($sql);
  $stmt->bindValue(':table',$table,PDO::PARAM_STR);
  $stmt->execute();
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
  if ($row>0) {
    return true;
  } else{
    return false;
  }
}

function create_table_address($dbh,$table){
  $sql="create table :table
  (addno varchar(7)
  ,add1kana varchar(255)
  ,add2 varchar(255)
  ,add2kana varchar(255)
  ,add3 varchar(255)
  ,add3kana varchar(255)
  )";
  $stmt=$dbh->prepare($sql);
  $stmt->bindValue(':table',$table,PDO::PARAM_STR);
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}
