<?php
$path = 'C:\xampp\htdocs\rekam-medis-laravel\public\images\odontogram_chart.jpeg';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
echo $base64;
?>
