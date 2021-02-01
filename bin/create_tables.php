<?php

$db = include 'connect.php';

$db->query("CREATE TABLE IF NOT EXISTS product (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,   
  `name` VARCHAR(255) NOT NULL,       
  `image` VARCHAR(255) NOT NULL,     
  `price` DECIMAL(10,2) NOT NULL,    
  `author` VARCHAR(255)  NOT NULL,      
  `date_added` DATETIME NOT NULL default CURRENT_TIMESTAMP
)" );

$db->query("CREATE TABLE IF NOT EXISTS reviews (
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `product_id` int(11) NOT NULL,       
  `username` VARCHAR(255) NOT NULL,    
  `rating` int(1) NOT NULL, 
  `comment` LONGTEXT NOT NULL,      
  `date_added` DATETIME NOT NULL default CURRENT_TIMESTAMP,
   FOREIGN KEY (product_id)  REFERENCES product (id)
)" );
