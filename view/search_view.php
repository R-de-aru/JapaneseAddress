<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>住所検索</title>
</head>
<body>
  <!-- 検索条件入力 -->
  <h3>検索条件指定</h3>
  <form action="" method="GET">
    <p>郵便番号：<input type="text" name="addno"> ※「0000000」の形で入力してください</p>
    <p>都道府県：
      <select name="add1">
        <option value="指定しない">指定しない</option>
        <?php foreach($ken as $data): ?>
          <option value="<?php echo $data['add1'];?>" <?php if(isset($add1) and $add1===$data['add1']) echo "selected";?>><?php echo $data['add1'];?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>市区町村：<input type="text" name="add2"></p>
    <p>町域：<input type="text" name="add3"></p>
    <input type="hidden" name="page" value="0">
    <input type="submit" value="検索！">
  </form>
  <br>
  <!-- 表示 -->
  <?php if(isset($addno) or isset($add1) or isset($add2) or isset($add3)): ?>
    <?php if ($count>0): ?>
      <?php if($count>$page+SEARCH_DISP_LIMIT): ?>
        <p><?php echo $count; ?>件ヒット！(<?php echo $page+1;?>～<?php echo $page+SEARCH_DISP_LIMIT;?>件目)</p>
      <?php else: ?>
        <p><?php echo $count; ?>件ヒット！(<?php echo $page+1;?>～<?php echo $count;?>件目)</p>
      <?php endif; ?>
      <table border="1">
        <tr>
          <th>郵便番号</th>
          <th>都道府県</th>
          <th>市区町村</th>
          <th>町域</th>
        </tr>
        <?php foreach ($result as $row): ?>
          <tr>
            <td><?php echo $row['addno']; ?></td>
            <td><?php echo $row['add1']; ?></td>
            <td><?php echo $row['add2']; ?></td>
            <td><?php echo $row['add3']; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
      <!--  10件ごとに1ページ表示したい -->
      <?php for($i=0;$i<=$count;$i+=SEARCH_DISP_LIMIT) {?>
        <?php $pagecount+=1 ?>
        <a href="search.php?addno=<?php echo $addno; ?>&add1=<?php echo $add1; ?>&add2=<?php echo $add2; ?>&add3=<?php echo $add3; ?>&page=<?php echo $i;?>"><?php echo $pagecount; ?></a>
      <?php } ?>
    <?php else: ?>
      <p>該当するデータはありません。</p>
    <?php endif; ?>
  <?php endif; ?>
</body>
