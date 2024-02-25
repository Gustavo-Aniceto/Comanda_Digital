<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCarrinho;

class CarrinhoController extends Controller
{
    // Adicionar um item ao carrinho
    public function adicionarItem(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        // Lógica para adicionar um item ao carrinho
        $item = ItemCarrinho::create([
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            
        ]);

        return response()->json($item, 201);
    }

    // Remover um item do carrinho
    public function removerItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:itens_carrinho,id',
        ]);

        // Lógica para remover um item do carrinho
        $item = ItemCarrinho::findOrFail($request->item_id);
        $item->delete();

        return response()->json(['mensagem' => 'Item removido do carrinho com sucesso'], 200);
    }

    // Atualizar a quantidade de um item no carrinho
    public function atualizarQuantidade(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:itens_carrinho,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        // Lógica para atualizar a quantidade de um item no carrinho
        $item = ItemCarrinho::findOrFail($request->item_id);
        $item->quantidade = $request->quantidade;
        $item->save();

        return response()->json(['mensagem' => 'Quantidade atualizada com sucesso'], 200);
    }

    // Calcular o total do carrinho
    public function calcularTotal(Request $request)
    {
        // Lógica para calcular o total do carrinho
        $total = ItemCarrinho::sum('preco_total');

        return response()->json(['total' => $total]);
    }

    // Visualizar o conteúdo do carrinho
    public function visualizarCarrinho(Request $request)
    {
        // Lógica para visualizar o conteúdo do carrinho
        $carrinho = ItemCarrinho::all();

        return response()->json($carrinho);
    }
}
