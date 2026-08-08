<?php
require_once __DIR__ . '/OpenGraph.php';
$url = 'https://www.ds-pedia.com/2026/06/22/%e7%84%a1%e6%a9%9f%e8%b3%aa%e3%81%aa%e7%94%bb%e9%9d%a2%e3%81%ab%e6%95%a3%e3%82%8a%e3%81%b0%e3%82%81%e3%82%89%e3%82%8c%e3%81%9f%e3%80%81%e7%a7%81%e3%81%a0%e3%81%91%e3%81%ae%e5%b0%8f%e3%81%95%e3%81%aa/';
$graph = OpenGraph::fetch($url);
echo json_encode($graph ? $graph->keys() : false);
