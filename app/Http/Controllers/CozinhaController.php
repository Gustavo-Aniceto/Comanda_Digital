<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class CozinhaController extends Controller
{
    // Listar Pedidos Pendentes com Paginação(10 pedidos por vez)
    public function listarPedidosPendentes(Request $request)
    {
        $pedidosPendentes = Pedido::where('status', 'em_andamento')->paginate(10);
        return response()->json($pedidosPendentes);
    }

    // Filtrar Pedidos por Status
    public function filtrarPedidosPorStatus(Request $request, $status)
    {
        $pedidos = Pedido::where('status', $status)->paginate(10);
        return response()->json($pedidos);
    }

    // Implementação de Autenticação: middleware 'auth'
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Marcar Pedido como Concluído com Verificações Adicionais
    public function marcarPedidoConcluido(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar se o pedido está em andamento
        if ($pedido->status !== 'em_andamento') {
            return response()->json(['erro' => 'Este pedido não está mais em andamento'], 400);
        }

        // Verificar se todos os itens do pedido foram preparados
        foreach ($pedido->itens as $item) {
            if (!$item->preparado) {
                return response()->json(['erro' => 'Não é possível concluir o pedido pois nem todos os itens foram preparados'], 400);
            }
        }

        // Atualizar o status do pedido para "Concluído"
        $pedido->status = 'concluido';
        $pedido->save();

        return response()->json(['mensagem' => 'Pedido marcado como concluído'], 200);
    }

    // Endpoint para Visualizar Detalhes do Pedido
    public function visualizarDetalhesPedido($id)
    {
        $pedido = Pedido::with('itens')->findOrFail($id);
        return response()->json($pedido);
    }

    public function buscarNovosPedidos(Request $request) {
        // Obter a data/hora da última atualização da interface da cozinha
        $ultimaAtualizacao = $request->input('ultima_atualizacao');
    
        // Buscar os novos pedidos que foram criados após a última atualização
        $novosPedidos = Pedido::where('created_at', '>', $ultimaAtualizacao)->get();
    
        // Retornar os novos pedidos como uma resposta JSON
        return response()->json($novosPedidos);
    }
}
