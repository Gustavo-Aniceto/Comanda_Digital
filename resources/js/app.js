import './bootstrap';

// Definindo a função para buscar os novos pedidos
function buscarNovosPedidos() {
    // requisição AJAX para buscar os novos pedidos
    $.ajax({
        url: '/pedidos/novos', // Rota para buscar os novos pedidos
        method: 'GET',
        success: function(response) {
            // Atualizar a tela da cozinha com os novos pedidos
            atualizarTela(response);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao buscar novos pedidos:', error);
        }
    });
}

// função para atualizar a tela da cozinha com os novos pedidos
function atualizarTela(pedidos) {

    // Seletor do elemento onde os novos pedidos serão exibidos
    const pedidosCozinha = document.getElementById('pedidos-cozinha');

    // Percorrer os novos pedidos e adicionar cada um à lista de pedidos da cozinha
    pedidos.forEach(pedido => {
        // Criar um elemento de parágrafo para exibir os detalhes do pedido
        const pedidoElemento = document.createElement('p');
        pedidoElemento.textContent = `Pedido #${pedido.id}: ${pedido.itens.length} itens`;


        // Adicionar o elemento do pedido à lista de pedidos da cozinha
        pedidosCozinha.appendChild(pedidoElemento);
    });
}

//função para buscar novos pedidos a cada 30 segundos (30000 milissegundos)
setInterval(buscarNovosPedidos, 30000);

