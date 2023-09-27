<?php
//Este é o arquivo que servirá como base para montarmos as pizzas na home

//Usamos o template do arquivo de conexões para conectar este arquivo de pizza.php também
include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

// Resgate dos dados do DB e montagem do pedido se o método for GET
if ($method === "GET") {
    
    $bordasQuery = $conn->query("SELECT * FROM bordas");

    $bordas = $bordasQuery->fetchAll();


    $massasQuery = $conn->query("SELECT * FROM massas");

    $massas = $massasQuery->fetchAll();


    $saboresQuery = $conn->query("SELECT * FROM sabores");

    $sabores = $saboresQuery->fetchAll();


// Criação do pedido se o método for POST
} elseif ($method === "POST") {

    $data = $_POST;

    $borda = $data["borda"];
    $massa = $data["massa"];
    $sabores = $data["sabores"];

    //validação de sabores máximos (máx 3) - regra de negócio

    if (count($sabores) > 3) {
        
        $_SESSION["msg"] = "Selecione no máximo 3 sabores!";
        $_SESSION["status"] = "warning";

    } else {
        
        echo "Passou da validação de 3 sabores";
        exit;

    }
    
    //Retorna à pagina inicial
    header("Location: ..");

}

?>
