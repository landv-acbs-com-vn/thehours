<?php
    // connect to database
    // $host = 'remotemysql.com';
    // $user = 'r92Nd5JzAL';
    // $pass = '3YScpMDSY0';
    // $db_name = 'r92Nd5JzAL';

    $host = '127.0.0.1';              // docker-compose: sử dụng host là tên của service mysql
    $user = 'admin';          // aci: sử dụng host là localhost hoặc 127.0.0.1 vì sử dụng cùng một network
    $pass = 'Admin123';
    $db_name = 'thehours';

    $conn = new MySQLi($host, $user, $pass, $db_name);

    if ($conn->connect_error) {
        die('Database connection error: ' . $conn->connect_error);
    }
