<?php
//Este é o arquivo que servirá como base para montarmos as pizzas na home

//Usamos o template do arquivo de conexões para conectar este arquivo de pizza.php também
include_once("conn.php");

// Obtém o método HTTP usado para acessar este arquivo (GET ou POST).
$method = $_SERVER["REQUEST_METHOD"];

// Resgate dos dados do DB e montagem do pedido se o método for GET - BASICAMENTE ESTA PARTE DO IF "GET" É PARA PEGAR OS DADOS DA DB E COLOCAR PARA O CLIENTE ESCOLHER NA TELA
if ($method === "GET") {
    
    // Consulta o banco de dados para obter todas as bordas de pizza.
    $bordasQuery = $conn->query("SELECT * FROM bordas");

    // Armazena os resultados da consulta em um array associativo.
    $bordas = $bordasQuery->fetchAll();


    $massasQuery = $conn->query("SELECT * FROM massas");

    $massas = $massasQuery->fetchAll();


    $saboresQuery = $conn->query("SELECT * FROM sabores");

    $sabores = $saboresQuery->fetchAll();


// Criação do pedido se o método for POST
} elseif ($method === "POST") {

    // Obtém os dados enviados pelo cliente através do formulário POST.
    $data = $_POST;

    // Extrai informações específicas dos dados enviados.
    $borda = $data["borda"];
    $massa = $data["massa"];
    $sabores = $data["sabores"];

    //validação de sabores máximos (máx 3) - regra de negócio
    if (count($sabores) > 3) {
        
        // Se o cliente selecionar mais de 3 sabores, uma mensagem de erro é definida.
        $_SESSION["msg"] = "Selecione no máximo 3 sabores!";
        $_SESSION["status"] = "warning";

    } else {
        
        //Salvando BORDA e MASSA na pizza

        $stmt = $conn->prepare("INSERT INTO pizza (bordas_id, massas_id) VALUES (:borda, :massa)");

        //Filtrando inputs

        $stmt->bindParam(":borda", $borda, PDO::PARAM_INT);
        $stmt->bindParam(":massa", $massa, PDO::PARAM_INT);

        $stmt->execute();

        // resgatando o ultimo id da ultima pizza

        $pizzaId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO pizza_sabores (pizza_id, sabores_id) VALUES (:pizza, :sabor)");

        // repetição até terminar de salvar todos os SABORES

        foreach($sabores as $sabor) {

            // filtrando os inputs

            $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
            $stmt->bindParam(":sabor", $sabor, PDO::PARAM_INT);
            
            $stmt->execute();
        }


        // CRIAR O PEDIDO DA PIZZA:

        $stmt = $conn->prepare("INSERT INTO pedidos (pizza_id, condicao_id) VALUES (:pizza, :status)");

        // status deve sempre inicial como "1", que é "em produção":

        $statusId = 1;

        // filtrando os inputs

        $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
        $stmt->bindParam(":status", $statusId, PDO::PARAM_INT);

        $stmt->execute();


        //EXIBIR MENSAGEM DE SUCESSO:

        $_SESSION["msg"] = "Pedido realizado com sucesso";
        $_SESSION["status"] = "success";

    }
    
    //Retorna à pagina inicial
    header("Location: ..");

}

?>



<!--

    1. Usamos o template do arquivo de conexões para conectar este arquivo de pizza.php também: Este comentário explica que o arquivo está incluindo (usando) outro arquivo chamado "conn.php", que  contém as configurações necessárias para conectar-se ao banco de dados. Ao incluir esse arquivo, este código obtém acesso às funcionalidades de conexão definidas nele.

    1.1. $method = $_SERVER["REQUEST_METHOD"];: Esta linha de código obtém o método HTTP (GET ou POST) usado para acessar este arquivo. Ela usa a variável superglobal $_SERVER["REQUEST_METHOD"] para recuperar o método HTTP. Essa informação é importante porque permite ao código saber como o cliente está interagindo com a página, ou seja, se o cliente está apenas visualizando a página (GET) ou se está enviando dados por meio de um formulário (POST). O resultado é armazenado na variável $method para uso posterior.

    1.2. Resumindo, esta parte do código está configurando o método HTTP usado para acessar o arquivo e armazenando essa informação na variável $method. Isso será útil para determinar o fluxo de controle do programa com base na forma como o cliente está interagindo com a página.



    2. Verificação do método de acesso: O bloco condicional if ($method === "GET") { verifica se o método de acesso é GET. Isso significa que estamos lidando com a visualização de informações do banco de dados - BASICAMENTE ESTA PARTE DO IF "GET" É PARA PEGAR OS DADOS DA DB E COLOCAR PARA O CLIENTE ESCOLHER NA TELA.

    2.1. Consulta ao banco de dados (GET): Dentro do bloco GET, as linhas a seguir realizam consultas ao banco de dados para obter informações sobre bordas, massas e sabores de pizza.

    2.2. Resgate de dados do banco de dados: Os resultados das consultas são armazenados nas variáveis $bordas, $massas e $sabores usando fetchAll(). Isso nos fornece os dados do banco de dados para exibição na página.

            OBS: SOBRE CONVERTER OS DADOS DE SQL EM ARRAY:

            Usando a função fetchAll(), você está efetivamente convertendo os dados recuperados do banco de dados de um formato específico do banco de dados para uma estrutura de dados utilizável em PHP. Aqui está como esse processo funciona:

            Dados do Banco de Dados: Quando você executa uma consulta SQL em um banco de dados, o banco de dados retorna os dados em um formato que é específico para o banco de dados. Isso pode ser um conjunto de registros e colunas em um formato bruto.

            fetchAll(): Ao chamar a função fetchAll() em um resultado de consulta (por exemplo, $bordasQuery->fetchAll()), você está pegando os dados brutos do banco de dados e convertendo-os em uma estrutura de dados mais amigável para PHP, que é um array associativo.

            Array Associativo: O resultado da função fetchAll() é um array associativo onde cada entrada do array corresponde a uma linha do resultado da consulta. Isso torna os dados acessíveis e manipuláveis em PHP. Você pode iterar sobre o array, acessar campos específicos usando chaves associativas e realizar operações nos dados de forma mais fácil.

            Portanto, essa conversão é essencial para permitir que você utilize os dados do banco de dados em seu código PHP, facilitando o processamento e a exibição desses dados em sua aplicação web. É uma parte fundamental da interação entre o banco de dados e a linguagem de programação.

    2.3. $bordasQuery = $conn->query("SELECT * FROM bordas");: Nesta linha, uma consulta SQL é executada no banco de dados. A consulta é especificada entre as aspas duplas e diz ao banco de dados para selecionar todas as informações da tabela "bordas". O resultado da consulta é armazenado na variável $bordasQuery.

    2.4. $bordas = $bordasQuery->fetchAll();: Aqui, a função fetchAll() é usada para buscar todos os resultados da consulta que foi armazenada em $bordasQuery. Essa função retorna esses resultados como um array associativo, onde cada entrada do array representa uma borda de pizza com seus atributos (por exemplo, nome, preço, ID, etc.). O resultado é então armazenado na variável $bordas.

    2.5. Em resumo, essas linhas de código realizam uma consulta ao banco de dados para obter todas as informações das bordas de pizza e, em seguida, armazenam essas informações em uma variável chamada $bordas. Isso permite que esses dados sejam usados posteriormente na página, por exemplo, para exibir as opções de borda disponíveis para o cliente ao fazer um pedido.



    3. POST
    3.1. elseif ($method === "POST") {: Este é um bloco condicional que verifica se o método de acesso é POST. Isso significa que o cliente está enviando dados para o servidor, como ao preencher um formulário e clicar em "enviar".

    3.2. $data = $_POST;: Estamos simplesmente copiando todos os dados enviados pelo cliente por meio do método POST e armazenando-os na variável $data para uso posterior no código. Isso permite que você acesse os valores enviados no formulário, como as escolhas de borda, massa e sabores da pizza, e os utilize para criar um pedido. É uma convenção de nomenclatura usar $data.

            OBS: O que é $_POST? -> $_POST é uma superglobal em PHP que é usada para coletar dados de um formulário HTML que foi submetido usando o método POST. Quando um cliente envia um formulário HTML, os dados desse formulário são enviados para o servidor e podem ser acessados no PHP por meio da variável $_POST.

            Por exemplo, se você tem um formulário HTML com campos como nome, email e senha e o usuário preenche esses campos e clica no botão "Enviar", os dados desses campos serão enviados para o servidor e podem ser acessados em PHP da seguinte maneira:

            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            Neste exemplo, $nome, $email e $senha conterão os valores que o usuário inseriu no formulário.

            O uso de $_POST é comum ao lidar com formulários HTML, pois permite que você receba e processe os dados enviados pelo cliente no servidor.


    3.3. $borda = $data["borda"];, $massa = $data["massa"];, $sabores = $data["sabores"];: Neste trecho, estamos atribuindo valores às variáveis $borda, $massa e $sabores. Esses valores são obtidos a partir do array associativo $_POST, que é preenchido com os dados enviados pelo cliente por meio de um formulário HTML usando o método POST.

        Por exemplo a borda: $borda = $data["borda"];: Aqui, estamos atribuindo à variável $borda o valor que foi enviado pelo cliente com o nome "borda" no formulário. Isso significa que estamos capturando a escolha da borda da pizza que o cliente fez.

    
    3.4. if (count($sabores) > 3) {: Esta é uma validação de regra de negócio. Estamos verificando se o cliente selecionou mais de 3 sabores, o que não é permitido. Se isso acontecer, uma mensagem de erro é definida na variável de sessão $_SESSION["msg"] e o status é definido como "warning".

            OBS: $_SESSION["msg"] é uma variável de sessão em PHP que está sendo usada para armazenar uma mensagem que será exibida ao usuário após a conclusão de uma ação no sistema. Vou explicar em detalhes:

            $_SESSION é uma superglobal em PHP que permite que você armazene informações que podem ser acessadas em diferentes páginas do seu site ou aplicação durante a mesma sessão do usuário. Isso é útil para compartilhar dados entre diferentes partes do seu código, como mensagens de sucesso ou informações de login.

            "msg" é uma chave associada à variável de sessão $_SESSION. É uma convenção de nomenclatura escolhida para representar uma mensagem que será exibida ao usuário.

            Portanto, $_SESSION["msg"] está sendo usada para armazenar uma mensagem que será exibida ao usuário após a conclusão de uma ação. Por exemplo, no código que você forneceu, após a criação de um pedido de pizza bem-sucedido, a mensagem "Pedido realizado com sucesso" é armazenada em $_SESSION["msg"]. Posteriormente, essa mensagem pode ser exibida na página para informar ao usuário que o pedido foi feito com êxito.

            Essa abordagem é comumente usada para fornecer feedback ao usuário sobre o resultado de suas ações no sistema.


    3.5. else {: Se o cliente não selecionou mais de 3 sabores, o código dentro deste bloco é executado.

    3.6. $stmt = $conn->prepare("INSERT INTO pizza (bordas_id, massas_id) VALUES (:borda, :massa)");: Aqui, estamos preparando uma instrução SQL para inserir um novo registro na tabela "pizza" do banco de dados. Estamos inserindo a borda selecionada e a massa selecionada pelo cliente usando o PDO (PHP Data Objects), que é uma extensão do PHP para trabalhar com bancos de dados.

            OBS: $stmt é uma variável que representa um "statement" (declaração) preparado. Um statement preparado é uma consulta SQL que é pré-compilada pelo banco de dados, o que a torna mais segura e eficiente para executar múltiplas vezes.

            $conn é uma variável que deve conter uma instância de conexão PDO com o banco de dados. O PDO é uma classe que permite estabelecer conexões com diferentes tipos de bancos de dados (MySQL, PostgreSQL, SQLite, etc.) e realizar operações no banco de dados.

            ->prepare(...) é um método do objeto de conexão PDO ($conn) que é usado para preparar uma consulta SQL. O argumento passado para prepare é a própria consulta SQL.

            "INSERT INTO pizza (bordas_id, massas_id) VALUES (:borda, :massa)" é a consulta SQL em si. Ela está inserindo um novo registro na tabela "pizza" com os valores das colunas "bordas_id" e "massas_id" definidos como parâmetros com marcadores de posição :borda e :massa. Esses marcadores de posição serão substituídos pelos valores reais quando a consulta for executada.


    3.7. $stmt->bindParam(":borda", $borda, PDO::PARAM_INT);, $stmt->bindParam(":massa", $massa, PDO::PARAM_INT);: Estamos vinculando os valores das variáveis $borda e $massa aos parâmetros da instrução SQL. Estamos informando que esses valores são inteiros (PDO::PARAM_INT).

            OBS: :borda e :massa são marcadores de posição na consulta SQL preparada. Eles representam valores que serão substituídos pelos valores reais quando a consulta for executada.

            $borda e $massa são as variáveis que contêm os valores que você deseja associar aos marcadores de posição na consulta SQL.

            PDO::PARAM_INT é uma constante que define o tipo de dado do parâmetro. Neste caso, você está dizendo que os valores associados aos marcadores :borda e :massa são números inteiros.

            Quando você chama $stmt->bindParam(":borda", $borda, PDO::PARAM_INT);, você está basicamente dizendo ao PDO que quando a consulta SQL for executada, o valor de $borda deve ser tratado como um número inteiro e substituirá :borda na consulta. O mesmo se aplica a $massa.

            POR QUE TRANSFORAMAR EM INTEIROS? 
            
            Transformar os valores em inteiros usando PDO::PARAM_INT é uma prática comum em consultas SQL preparadas por alguns motivos:

            Segurança: Ao definir explicitamente o tipo de dado como inteiro, você está informando ao banco de dados como o valor deve ser tratado. Isso pode ajudar a prevenir ataques de injeção de SQL, pois o banco de dados saberá que o valor deve ser tratado como um número inteiro e não será interpretado como código SQL malicioso.

            Eficiência: A especificação do tipo de dado pode melhorar a eficiência da consulta, pois o banco de dados pode otimizar o processamento com base no tipo de dado esperado. Isso é mais perceptível em consultas complexas ou quando grandes volumes de dados estão envolvidos.

            Prevenção de erros: Ao definir o tipo de dado, você pode ajudar a garantir que os dados estejam formatados corretamente antes de serem inseridos no banco de dados. Isso pode ajudar a evitar erros de formatação ou inserção de dados inválidos.

            Clareza do código: Explicitamente definir o tipo de dado torna o código mais claro e legível para outros desenvolvedores que possam revisar ou colaborar no projeto. Isso indica a intenção de como os dados devem ser usados.


    3.8. $stmt->execute();: Aqui, estamos executando a instrução SQL para inserir os dados na tabela "pizza".
    
            OBS: $stmt->execute(); é uma instrução que efetivamente executa a consulta preparada anteriormente. Quando você prepara uma consulta SQL com o método prepare() da classe PDO, você está criando um modelo da consulta com espaços reservados para os valores que serão inseridos posteriormente de forma segura. O método execute() é responsável por preencher esses espaços reservados com os valores fornecidos e executar a consulta no banco de dados.

            No contexto deste código, após a preparação da consulta SQL para inserir uma nova pizza no banco de dados, os espaços reservados :borda e :massa são preenchidos com os valores das variáveis $borda e $massa. Em seguida, a chamada $stmt->execute(); efetivamente insere uma nova entrada na tabela de pizzas com os valores fornecidos. Isso garante que a operação de inserção seja realizada de maneira segura e evita vulnerabilidades de segurança, como SQL injection.


    3.9. $pizzaId = $conn->lastInsertId();: Estamos obtendo o ID da última pizza inserida no banco de dados. Isso será usado posteriormente.

    * $stmt = $conn->prepare("INSERT INTO pizza_sabores (pizza_id, sabores_id) VALUES (:pizza, :sabor)");: Estamos preparando uma instrução SQL para inserir os sabores selecionados pelo cliente na tabela "pizza_sabores". Vamos repetir este processo para cada sabor selecionado.

    * foreach($sabores as $sabor) {: Aqui, estamos iniciando um loop foreach para percorrer os sabores selecionados pelo cliente.

    *  $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);, $stmt->bindParam(":sabor", $sabor, PDO::PARAM_INT);: Estamos vinculando os valores do ID da pizza ($pizzaId) e o ID do sabor atual ($sabor) aos parâmetros da instrução SQL.

    * $stmt->execute();: Estamos executando a instrução SQL para inserir o sabor na tabela "pizza_sabores". Isso é repetido para cada sabor selecionado.

            Após inserir os dados da pizza na tabela de pizzas, precisamos obter o ID da pizza recém-inserida. O método $conn->lastInsertId() é usado para obter o ID da última inserção no banco de dados. Esse valor é armazenado na variável $pizzaId.

            Em seguida, é preparada uma nova consulta SQL para inserir os sabores da pizza na tabela pizza_sabores. A consulta SQL possui espaços reservados :pizza e :sabor que serão preenchidos com os valores apropriados.

            A parte seguinte do código utiliza um loop foreach para iterar sobre a lista de sabores selecionados pelo cliente (armazenados na variável $sabores). Dentro do loop, os espaços reservados :pizza e :sabor são preenchidos com os valores de $pizzaId (o ID da pizza recém-inserida) e $sabor (o ID do sabor atual no loop), respectivamente. Em seguida, a consulta é executada com $stmt->execute();, inserindo cada sabor associado à pizza na tabela pizza_sabores.

            Esse processo se repete até que todos os sabores selecionados tenham sido inseridos na tabela pizza_sabores. Dessa forma, as informações da pizza são totalmente registradas no banco de dados, incluindo os sabores escolhidos.


    3.10. $stmt = $conn->prepare("INSERT INTO pedidos (pizza_id, condicao_id) VALUES (:pizza, :status)");: Estamos preparando uma instrução SQL para criar um novo pedido na tabela "pedidos". O status inicial é definido como "1" (em produção).

    * $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);, $stmt->bindParam(":status", $statusId, PDO::PARAM_INT);: Estamos vinculando os valores do ID da pizza ($pizzaId) e o ID do status ($statusId) aos parâmetros da instrução SQL.

    * $stmt->execute();: Estamos executando a instrução SQL para criar o pedido da pizza.

    * $_SESSION["msg"] = "Pedido realizado com sucesso";, $_SESSION["status"] = "success";: Estamos definindo uma mensagem de sucesso na variável de sessão $_SESSION["msg"] e o status como "success".

    
    3.11. header("Location: ..");: Estamos redirecionando o cliente de volta à página inicial após o pedido ser realizado com sucesso.

