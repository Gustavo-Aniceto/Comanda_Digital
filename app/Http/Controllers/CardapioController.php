<?php

namespace App\Http\CardapioControllers;

use Illuminate\http\Requests;
use App\Models\ItemCardapio;



class CardapioController extends Controller
{

    //função para listar todos os itens disponíveis no cardápio.
    public function listarItens()
    {
        $itens = ItemCardapio::all();
        return response()->json($itens);
    }

    //função para visualizar os detalhes de um item específico do cardápio.
    public function visualizarDetalhesItem($id)
    {
        $item = ItemCardapio::find($id);

        if (!$item) {
            return response()->json(['mensagem' => 'Item não encontrado'], 404);
        }

        return response()->json($item);
    }

    // função para permitir que os usuários pesquisem itens no cardápio com base em critérios específicos.
    public function pesquisarItens(Request $request)
    {
        $termoPesquisa = $request->input('termo');

        // Busca os itens do cardápio que correspondem ao termo de pesquisa
        $itens = ItemCardapio::where('nome', 'like', '%' . $termoPesquisa . '%')
                              ->orWhere('descricao', 'like', '%' . $termoPesquisa . '%')
                              ->get();

        return response()->json($itens);
    }

   

}