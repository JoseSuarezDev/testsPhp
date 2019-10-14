<?php
    require_once '../connect.php';

    $id;
    // echo $_GET['id'];    
    echo $_POST['nameTable'];    
    echo $_POST['codeTable'];    
    echo $_POST['observaciones']; 
    $inputs = ( (count($_POST) - 3) / 3 );
    $names = array();
    $codes = array();
    $observs = array();
    for ($i = 1; $i <= $inputs; $i++) {
        $names[] = $_POST["input$i"];
        $codes[] = $_POST["code$i"];
        $observs[] = $_POST["obser$i"];
    }

    function setTable($code, $name, $observacion) {
        try {
            // Insertar el registro en la tabla entityclass
            $array = array( $code, $name, $observacion );
            $sql = "INSERT INTO base.entityclass (code, name, observation ) VALUES (?,?,?)";
            $GLOBALS['conn']->prepare($sql)->execute($array);
            // Obtener el id insertado
            $id = $GLOBALS['conn']->lastInsertId('base.entityclass_id_seq');
            $GLOBALS['id'] = $id;
            

            // Registrar los campos de la tabla en entitysubclass 
            for ($i = 0; $i < $GLOBALS['inputs']; $i++) {
                // $array = array( $codeSub, $nameSub, $id, $observacionSub );
                $array = array( $GLOBALS['codes']["$i"], $GLOBALS['names']["$i"], $id, $GLOBALS['observs']["$i"] );
                $sql = "INSERT INTO base.entitysubclass (code, name, identityclass, observation) VALUES (?,?,?,?)";
                $GLOBALS['conn']->prepare($sql)->execute($array);
            }

        } catch (Throwable $th) {
            echo $th;
        }        
    }

    // setTable($_POST['nameTable'], $_POST['codeTable'], $_POST['observaciones']);
    $id = 80;
    function createTable($id) {
        $stmt = $GLOBALS['conn']->query("SELECT * FROM base.entityclass where id=$id");
        $Table = $stmt->fetch();
        $nameTable = $Table['name'];

        $stmt = $GLOBALS['conn']->query("SELECT * FROM base.entitysubclass where identityclass=$id");
        $campos = $stmt->fetchAll();
        for ($i=0; $i < count($campos); $i++) { 
            echo json_encode($campos[$i]);                
        }
    }

    createTable($id);
?>