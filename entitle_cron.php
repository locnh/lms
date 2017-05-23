<?php

require dirname(__FILE__) . '/application/config/database.php';

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if ($result = $mysqli->query("SELECT id FROM users WHERE active = 1")) {

    $values = array();

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        $values[] = '(' . $row['id'] . ',' . 'CURDATE()' . ',' . '"2020-12-31"' . ',' . '1' . ',' . '1' . ',' . '"Monthly entitlements"' . ')';
    }

    $query  = "INSERT INTO entitleddays (employee, startdate, enddate, type, days, description) VALUES ";
    $query .= implode(',', $values);

    //die($query);

    $mysqli->query($query);
}

$mysqli->close();

