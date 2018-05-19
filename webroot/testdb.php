<?php
//pear MDB2ライブラリーの取り込み
require_once 'MDB2.php';
//MYSQLデータベースインスタンス作成と接続
$con=& MDB2::connect('mysql://root:passwd@db/');
if(PEAR::isError($con)) {
  die($con->getMessage());
}

//テスト用データベースの作成
$sql = array(
  "drop database if exists sample01_db",
  "create database sample01_db",
  "use sample01_db",
  "create table testdb01 (pid int auto_increment primary key,uid varchar(30),email varchar(60),reg_date DATE)",
  "insert into testdb01 values(null,'佐藤大吉','daikichi@example.org',NOW())",
  "insert into testdb01 values(null,'渡瀬光一','koichi@example.org',NOW())",
  "insert into testdb01 values(null,'田中涼介','ryousuke@example.org',NOW())",
);
foreach ($sql as $s) {
  $sql_res=$con->queryAll($s);
}

//フェッチモードの設定と全レコードの読み込み
$con->setFetchMode(MDB2_FETCHMODE_ASSOC);
$sql_res=$con->queryAll('select * from testdb01');
//取り込んだクエリー結果を１行づつ展開
foreach ($sql_res as $line) {
  print $line['pid'].'  ';
  print $line['uid'].'  ';
  print $line['email'].'  ';
  print $line['reg_date'];
  print "<br>\n";
}
//データベースのエラー処理としてエラーの内容をレポート
if (PEAR::isError($sql_res)) {
  die($sql_res->getMessage());
}
//データベースをクローズ
$con->disconnect();
?>
