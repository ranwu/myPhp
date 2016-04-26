<?php
try {
    $DBH = new PDO('mysql:host=localhost;dbname=test','root','');
    } catch (Exception $e) {
        echo $e->getMessage();
    }