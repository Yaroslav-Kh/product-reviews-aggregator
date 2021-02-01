<?php

$db = include 'connect.php';

$db->query("DELETE FROM reviews" );
$db->query("DELETE FROM product" );
