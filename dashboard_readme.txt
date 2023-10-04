HTML DA PÁGINA 

    <div class="container">: Define uma área na página com largura ajustada para diferentes tamanhos de tela, mantendo o conteúdo centralizado.

    <div class="row">: Cria uma linha dentro do container para organizar o conteúdo em colunas.

    <div class="col-md-12">: Esta coluna ocupa toda a largura disponível em telas médias e maiores.

    <h2>Gerenciar Pedidos:</h2>: Um título de nível 2 que informa que o que vem a seguir é sobre o gerenciamento de pedidos.

    <table clasns="table">: Inicia uma tabela estilizada usando as classes do Bootstrap para tornar a exibição mais agradável.

    <thead>: Cabeçalho da tabela.

    <th scope="col">: Cada th dentro do cabeçalho é uma coluna.

    <tbody>: Corpo da tabela onde os dados reais são inseridos.

    <tr>: Cada tr é uma linha da tabela.

    <td>: Cada td é uma célula, onde dados ou botões podem ser colocados.

    <form action="process/order.php" method="POST" class="form-group update-form">: Início de um formulário que envia dados para "process/order.php" usando o método POST. A classe form-group é usada para aplicar estilos.

    <input type="hidden" name="type" value="update">: Um campo de entrada oculto que envia o tipo de operação, neste caso, "update".

    <input type="hidden" name="id" value="1">: Um campo oculto que envia o ID do pedido.

    <select name="status" class="form-control status-input">: Um menu suspenso para escolher o novo status do pedido, estilizado pelo Bootstrap.

    <option value="">Entrega</option>: Uma opção no menu suspenso, neste caso, "Entrega".

    <button type="submit" class="update-btn"><i class="fas fa-sync-alt"></i></button>: Um botão para enviar o formulário, com um ícone de atualização incorporado.

    </form>: Fim do formulário de atualização.

    <td>: Outra célula na linha, geralmente usada para mais dados ou ações.

    <form action="process/orders.php" method="POST">: Início de outro formulário que envia dados para "process/orders.php".

    <input type="hidden" name="type" value="update">: Campo oculto indicando o tipo de operação.

    <input type="hidden" name="id" value="1">: Campo oculto contendo o ID do pedido.

    <button type="submit" class="delete-btn"><i class="fas fa-times"></i></button>: Botão para excluir o pedido, com um ícone de "X" incorporado.

    </form>: Fim do formulário de ações.

    Este código HTML usa o Bootstrap para criar uma tabela estilizada com opções de atualização e exclusão para cada pedido. O Bootstrap facilita o design responsivo e a organização visual.




