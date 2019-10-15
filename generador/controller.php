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
        /* echo $_POST["input$i"];
        echo $_POST["code$i"];
        echo $_POST["obser$i"]; */
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
        
        $string = '';
        for ($i=0; $i < count($campos); $i++) { 
            $string .= $campos[$i]['name'] ." ". $campos[$i]['observation'] ." ". $campos[$i]['code'] .",";
        }              

        $sql = "CREATE TABLE base.$nameTable (
                id serial PRIMARY KEY,
                code VARCHAR (50) UNIQUE NOT NULL,
                name VARCHAR (50) NOT NULL,
                $string
                created_on TIMESTAMP NOT NULL,
                active character varying(1) NOT NULL DEFAULT 'Y'::character varying,
                deleted character varying(1) NOT NULL DEFAULT 'N'::character varying
            )";
        print( $string);
        
        // En caso de queres hacerlo por php:
        /* $GLOBALS['conn']->exec($sql); */

        // Prueba de como ejecutar la funcion de postgre por aqui:
        // $sql = "SELECT createTable('nombre', 'trabaja VARCHAR (50) NOT NULL')";

        $array = array( $nameTable, $string );
        $sql = 'SELECT createTable(?,?)';
        $GLOBALS['conn']->prepare($sql)->execute($array);

    }

    createTable($id);
?>