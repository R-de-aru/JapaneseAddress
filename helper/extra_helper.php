<?php
function html_escape($word){
  return htmlspecialchars($word,ENT_QUOTES,'UTF-8');
}
