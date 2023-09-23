<?php 
//Iniciar sessão
session_start();

//DEFINIDO VARIÁVEIS PARA CONEXÃO COM O BANCO DE DADOS
//usuário - ser root é padrão do sistema
$user = "root";
//senha - padrão do sql é ser vazia
$pass = "";
//nome do banco de dados - o meu já criado no sql se chama "pizzaria"
$db = "pizzaria";
//servidor - no caso é "localhost" pois é nosso servidor local Apache
$host = "localhost";


//"try catch" é uma instrução para teste que vai ou executar a ação ou dar um erro - Em resumo, este código estará estabelecendo uma conexão com um banco de dados MySQL usando PDO e configurando o tratamento de erros para lançar exceções em caso de problemas. Se ocorrer um erro, ele imprimirá uma mensagem de erro e encerrará a execução do script.:

try {
    //Esta variável é a que vamos usar para estabelecer as conexões - com ela já geramos a conexão com o bd:
    $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
    //Criamos estes 2 atributos juntos para habilitar os erros:
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    print "Erro: " . $e->getMessage() . "<br/>";
    die();
    //Aqui se der um erro no sistema ele já mostra na tela o tipo de erro no getMessage() e finaliza o sistema com die().
}


/*
try { ... } catch (PDOException $e) { ... }: Isso é uma estrutura de tratamento de exceção. O código dentro do bloco try é onde você tenta realizar uma operação que pode gerar um erro. Se ocorrer um erro, ele será "capturado" pelo bloco catch e você pode lidar com ele de maneira apropriada.

$conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);: Esta linha cria uma instância da classe PDO, que é usada para estabelecer conexões com bancos de dados. Ela recebe informações sobre o host, nome do banco de dados, nome de usuário e senha como argumentos. Isso cria uma conexão com o banco de dados MySQL especificado.

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);: Estas linhas definem dois atributos na instância do PDO. O primeiro atributo, PDO::ATTR_ERRMODE, configura o modo de tratamento de erros para lançar exceções (exceptions) quando ocorrerem erros no banco de dados. O segundo atributo, PDO::ATTR_EMULATE_PREPARES, desativa a emulação de preparação de consultas (query prepares), garantindo que as consultas sejam preparadas e executadas corretamente pelo MySQL.

O bloco catch (PDOException $e) { ... } é onde você lida com exceções lançadas por qualquer código dentro do bloco try. Se ocorrer um erro durante a criação da conexão PDO, o código dentro deste bloco será executado.

print "Erro: " . $e->getMessage() . "<br/>";: Esta linha imprime uma mensagem de erro que é obtida a partir da exceção ($e) usando o método getMessage(). Essa mensagem deve fornecer informações sobre o erro que ocorreu.

die();: Essa função encerra a execução do script imediatamente após imprimir a mensagem de erro. Isso é útil para impedir que o script continue a ser executado se ocorrer um erro na conexão com o banco de dados.
*/

?>