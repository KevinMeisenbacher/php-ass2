<?php
    $dsn = 'mysql:host=localhost:3306;dbname=my_guitar_shop1';
    $username = 'mgs_user';
    $db_password = 'pa55word';

    try {
        $db = new PDO($dsn, $username, $db_password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>