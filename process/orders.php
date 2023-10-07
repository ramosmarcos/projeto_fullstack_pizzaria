<?php
//Este é o arquivo que servirá como base para colocarmos as ações relacionadas aos pedidos - atualizar, deletar e resgatar pedidos

//Usamos o template do arquivo de conexões para conectar este arquivo de orders.php também
include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    
    //Pegando as infos dos pedidos
    $pedidosQuery = $conn->query("SELECT * FROM pedidos;");
    $pedidos = $pedidosQuery->fetchAll();

    //como pegamos ali em cima os pedidos, mas apenas os Ids em números, por conta do array de pedidos do fetchAll, não teremos uma listagem bonita das massas, sabores e bordas com seus nomes - Por isso faremos assim:
    $pizzas = [];

    foreach($pedidos as $pedido) {
        
        $pizza = [];

        // definir um array para a pizza
        $pizza["id"] = $pedido["pizza_id"];

        // resgatando a pizza
        $pizzaQuery = $conn->prepare("SELECT * FROM pizza WHERE id = :pizza_id");

        $pizzaQuery->bindParam(":pizza_id", $pizza["id"]);

        $pizzaQuery->execute();

        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);


        // resgatando a borda da pizza
        $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :bordas_id");

        $bordaQuery->bindParam(":bordas_id", $pizzaData["bordas_id"]);

        $bordaQuery->execute();

        $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);

        $pizza["borda"] = $borda["tipo"];


        // resgatando a massa da pizza
        $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massas_id;");

        $massaQuery->bindParam(":massas_id", $pizzaData["massas_id"]);

        $massaQuery->execute();

        $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);

        $pizza["massa"] = $massa["tipo"];


        // resgatando os sabores da pizza
        $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabores WHERE pizza_id = :pizza_id");

        $saboresQuery->bindParam(":pizza_id", $pizza["id"]);

        $saboresQuery->execute();

        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);


        // resgatando o nome dos sabores
        $saboresDaPizza = [];

        $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabores_id");

        foreach ($sabores as $sabor) {
            
            $saborQuery->bindParam(":sabores_id", $sabor["sabores_id"]);

            $saborQuery->execute();

            $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);

            array_push($saboresDaPizza, $saborPizza["tipo"]); //ou "nome"?

        }

        $pizza["sabores"] = $saboresDaPizza;


        // adicionar o status do pedido
        $pizza["condicao"] = $pedido["condicao_id"];

        
        // adiconar o array de pizza ao array das pizzas
        array_push($pizzas, $pizza);

    }

    //Teste na tela para printar as infos:
    // print_r($pizzas);


    //Resgatando os status ("condicao" - nome dado no banco de dados)
    $condicaoQuery = $conn->query("SELECT * FROM condicao;");

    $condicao = $condicaoQuery->fetchAll();

} else if ($method === "POST") {

    // verificando o tipo de POST
    $type = $_POST["type"]; 

    // deletar pedido
    if ($type === "delete") {
        
        $pizzaId = $_POST["id"];

        $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id");

        $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

        $deleteQuery->execute();

        $_SESSION["msg"] = "Pedido removido com sucesso!";
        $_SESSION["status"] = "success";

        //Isso tudo conversa com o botão delete da dashboard

    }

    // agora retorna o usuário para dashboard
    header("Location: ../dashboard.php");

}


?>


