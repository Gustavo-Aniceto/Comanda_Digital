<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    // Listar Todos os Pedidos do Usuário
    public function listarPedidosDoUsuario()
    {
        $pedidos = Pedido::where('user_id', auth()->id())->get();
        return response()->json($pedidos);
    }

    // Criar um Novo Pedido
    public function criarPedido(Request $request)
    {
        $pedido = Pedido::create([
            'user_id' => auth()->id(),
            'status' => 'em_andamento', // Ou qualquer outro status inicial
            // Adicione outros campos necessários aqui, como endereço de entrega, etc.
        ]);

        return response()->json($pedido, 201);
    }

    // Visualizar Detalhes de um Pedido
    public function visualizarPedido($id)
    {
        $pedido = Pedido::with('itens')->findOrFail($id);
        return response()->json($pedido);
    }

    // Atualizar um Pedido (por exemplo, adicionar ou remover itens)
    public function atualizarPedido(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar se o pedido pertence ao usuário autenticado
        if ($pedido->user_id !== auth()->id()) {
            return response()->json(['mensagem' => 'Você não tem permissão para atualizar este pedido'], 403);
        }

        // Verificar se o pedido está em andamento
        if ($pedido->status !== 'em_andamento') {
            return response()->json(['mensagem' => 'Este pedido não pode ser atualizado'], 400);
        }

        // Validar os dados da solicitação
        $request->validate([
            'itens_adicionar' => 'nullable|array',
            'itens_adicionar.*.item_id' => 'required|exists:itens,id',
            'itens_adicionar.*.quantidade' => 'required|integer|min:1',
            'itens_remover' => 'nullable|array',
            'itens_remover.*.item_id' => 'required|exists:itens,id',
            'itens_remover.*.quantidade' => 'required|integer|min:1',
        ]);

        // Adicionar novos itens ao pedido
        if ($request->has('itens_adicionar')) {
            foreach ($request->itens_adicionar as $item) {
                $pedido->itens()->create([
                    'item_id' => $item['item_id'],
                    'quantidade' => $item['quantidade'],
                    // Adicione outras informações necessárias aqui, como preço, etc.
                ]);
            }
        }

        // Remover itens do pedido
        if ($request->has('itens_remover')) {
            foreach ($request->itens_remover as $item) {
                // Encontrar o item do pedido correspondente para remover
                $itemPedido = ItemPedido::where('pedido_id', $pedido->id)
                                         ->where('item_id', $item['item_id'])
                                         ->first();

                if ($itemPedido) {
                    // Remover o item do pedido
                    $itemPedido->delete();
                }
            }
        }

        return response()->json(['mensagem' => 'Pedido atualizado com sucesso'], 200);
    }
    // A implementação específica dependerá dos requisitos do seu aplicativo

    // Remover um Pedido
    public function removerPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['mensagem' => 'Pedido removido com sucesso'], 200);
    }

    // Calcular Total do Pedido
    public function calcularTotalPedido($id)
    {
        $pedido = Pedido::with('itens')->findOrFail($id);
        $total = $pedido->itens->sum(function ($item) {
            return $item->preco * $item->quantidade;
        });

        return response()->json(['total' => $total]);
    }

    // Finalizar um Pedido (alterar status para "finalizado" ou similar)

    // Visualizar Histórico de Pedidos
    public function visualizarHistoricoPedidos()
    {
        $historico = Pedido::where('user_id', auth()->id())->where('status', '!=', 'em_andamento')->get();
        return response()->json($historico);
    }
    // Adicionar Observação ao Pedido
    public function adicionarObservacao(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->observacao = $request->input('observacao');
        $pedido->save();

        return response()->json(['mensagem' => 'Observação adicionada ao pedido'], 200);
    }

    // Confirmar Pedido
    public function confirmarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'confirmado';
        $pedido->save();

        // Aqui você pode adicionar lógica para enviar notificação ao usuário

        return response()->json(['mensagem' => 'Pedido confirmado'], 200);
    }

    // Cancelar Pedido
    public function cancelarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->status = 'cancelado';
        $pedido->save();

        // Aqui você pode adicionar lógica para enviar notificação ao usuário

        return response()->json(['mensagem' => 'Pedido cancelado'], 200);
    }

    
}
