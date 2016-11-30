<?php

$headers = get_headers($_GET['url']);
header('Content-Type: application/json');
echo json_encode($headers);