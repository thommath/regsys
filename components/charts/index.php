<?php
function sanitizeUsage($categories, $key){
  foreach ($categories as $category => $value) {
    if($value[$key] == 0){
      unset($categories[$category]);
    }
  }
  return $categories;
}
function sanitizeUsageTwo($categories, $key, $key2){
  foreach ($categories as $category => $value) {
    if($value[$key] == 0 && $value[$key2] == 0){
      unset($categories[$category]);
    }
  }
  return $categories;
}
?>
<script src="/dependencies/js/Chart.js"></script>
