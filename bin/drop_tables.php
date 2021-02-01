<?php

$db = include 'connect.php';

$db->query("DROP TABLE IF EXISTS reviews, product" );

