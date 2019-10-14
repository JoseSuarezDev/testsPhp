<?php

require_once '../connect.php';

$id = 2; $name = 'jose'; $age = 13; $address = 'mirando'; $salary = 300;
echo 'hi';

function getUsers() {
    // consulta:
    $stmt = $GLOBALS['conn']->query("SELECT * FROM schematest.test");
    // de que manera me traera la consulta (la instruccion)
    /* $resp = $stmt->fetch(); */
    $return = json_encode($stmt->fetchAll());
    // imprimir
    /* print $resp['name'];

    print json_encode( $resp );

    while ($row = $stmt->fetch()) {
        echo $row['name']."<br />\n";
        echo $row['id']."<br />\n";
    } */
    
    return $return;
}
function getUser($id) {
    $stmt = $GLOBALS['conn']->query("SELECT * FROM schematest.test where id=$id");
    $return = json_encode($stmt->fetch());
    return $return;
}

/* function setUser($id, $name, $age, $address, $salary) {
    $array = array( $id, $name, $age, $address, $salary );
    $sql = "INSERT INTO schematest.test (id, name, age, address, salary) VALUES (?,?,?,?,?)";
    $GLOBALS['conn']->prepare($sql)->execute($array);
} */

function updateUser($id, $name, $age, $address, $salary) {
    $array = array( $name, $age, $address, $salary, $id );
    $sql = "UPDATE schematest.test SET name=?, age=?, address=?, salary=? WHERE id=?";
    $GLOBALS['conn']->prepare($sql)->execute($array);

}

function deleteUser($id) {
    $array = array($id);
    $sql = "DELETE FROM schematest.test WHERE id=?";
    $GLOBALS['conn']->prepare($sql)->execute($array);

}

echo getUsers();
echo getUser(1);
// echo setUser($id, $name, $age, $address, $salary);
echo updateUser($id, $name, $age, $address, $salary);
echo deleteUser($id);

?>