<?php
include "simple_html_dom.php";
echo "<pre>";

$filelist = glob('files/counts/*');
// var_dump($filelist);
// exit;

foreach($filelist as $file) {

  $html = file_get_contents($file);
  $html = str_get_html($html);

  unlink($file);

  $ret = $html->find('div[class=single-main]',0);

  $ret = str_replace("<p> Voltar </p>","",$ret);
  $ret = str_replace("<h3 class=\"description-area\">Detalhes do Conto Erotico:</h3>","",$ret);
  $ret = str_replace("&#8212;","",$ret);
  $ret = str_replace("  ","",$ret);
  $ret = str_replace("  ","",$ret);

  $ret = strip_tags($ret);
  $ret = html_entity_decode($ret);
  $ret = urldecode($ret);

  $ret = trim($ret);

  echo $file;
  echo $ret;


  $insert = "insert into txt ('set','text','obs') values ('Contos Eroticos','".$ret."','".$file."')";

  $stmt = $file_db->prepare($insert);

  if(!empty($ret))$stmt->execute();


  // echo $ret; // Output: <div id="hello">foo</div><div id="world" class="bar">World</div>
  // $ie++;
  // if($ie >= 10) exit;
}
?>
