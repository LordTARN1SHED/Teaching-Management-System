<?php
$folderPath = 'documents/';
$folder = opendir($folderPath);
$fileListHTML = '
<table>
  <tr>
    <th>文件名</th>
    <th>修改日期</th>
    <th>下载链接</th>
  </tr>';
while (($file = readdir($folder)) !== false) {
  if ($file != '.' && $file != '..') {
    $modifiedDate = date("Y-m-d H:i:s", filemtime($folderPath . $file));
    $downloadLink = '<a href=" ' . urlencode($file) . '">下载</a >';
    $fileListHTML .= '
    <tr>
      <td>' . $file . '</td>
      <td>' . $modifiedDate . '</td>
      <td>' . $downloadLink . '</td>
    </tr>';
  }
}
closedir($folder);
$fileListHTML .= '</table>';
echo $fileListHTML;
?>
