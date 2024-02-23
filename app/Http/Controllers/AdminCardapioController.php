<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCardapio;

class AdminCardapioController extends Controller
{
    // Listar Todos os Itens do Cardápio
    public function listarItens()
    {
        $itens = ItemCardapio::all();
        return response()->json($itens);
    }

    // Criar Novo Item do Cardápio
    public function criarItem(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
    
        $imagem = $request->file('imagem');
        $nomeImagem = time().'.'.$imagem->getClientOriginalExtension();
        $caminho = 'imagens/';
        $imagem->move($caminho, $nomeImagem);
    
        $item = ItemCardapio::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $caminho.$nomeImagem,
            'categoria_id' => $request->categoria_id,
        ]);
    
        return response()->json($item, 201);
    }
    

    // Visualizar Detalhes de um Item do Cardápio
    public function visualizarItem($id)
    {
        $item = ItemCardapio::findOrFail($id);
        return response()->json($item);
    }

    // Atualizar um Item do Cardápio
    public function atualizarItem(Request $request, $id)
    {
        $item = ItemCardapio::findOrFail($id);

        // Validação dos dados recebidos do formulário
        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric|min:0',
            // Adicione outras regras de validação conforme necessário
        ]);

        // Atualiza as informações do item
        $item->update($request->all());

        return response()->json($item, 200);
    }

    // Remover um Item do Cardápio
    public function removerItem($id)
    {
        $item = ItemCardapio::findOrFail($id);
        $item->delete();

        return response()->json(['mensagem' => 'Item removido do cardápio'], 200);
    }

     // Upload de Imagens para Itens do Cardápio
     public function uploadImagem(Request $request, $id)
     {
         $request->validate([
             'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         $item = ItemCardapio::findOrFail($id);
 
         if ($request->hasFile('imagem')) {
             $imagem = $request->file('imagem');
             $nomeImagem = time().'.'.$imagem->getClientOriginalExtension();
             $caminho = 'imagens/';
             $imagem->move($caminho, $nomeImagem);
 
             $item->imagem = $caminho.$nomeImagem;
             $item->save();
 
             return response()->json(['mensagem' => 'Imagem adicionada com sucesso'], 200);
         }
 
         return response()->json(['erro' => 'Falha ao fazer upload da imagem'], 400);
     }
     public function listarCategorias()
     {
         $categorias = Categoria::all();
         return response()->json($categorias);
     }
 
     // Adicionar Categoria de Item do Cardápio
     public function adicionarCategoria(Request $request)
     {
         $request->validate([
             'nome' => 'required|unique:categorias',
         ]);
 
         $categoria = Categoria::create($request->all());
 
         return response()->json($categoria, 201);
     }
 
     // Relacionar Item do Cardápio com uma Categoria
     public function relacionarItemCategoria(Request $request, $itemId)
     {
         $request->validate([
             'categoria_id' => 'required|exists:categorias,id',
         ]);
 
         $item = ItemCardapio::findOrFail($itemId);
         $item->categoria_id = $request->categoria_id;
         $item->save();
 
         return response()->json(['mensagem' => 'Item relacionado com categoria com sucesso'], 200);
     }

     // Atualizar Categoria
    public function atualizarCategoria(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|unique:categorias,nome,'.$id,
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return response()->json($categoria, 200);
    }

    // Remover Categoria
    public function removerCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json(['mensagem' => 'Categoria removida do cardápio'], 200);
    }

    // Visualizar Itens por Categoria
    public function visualizarItensPorCategoria($id)
    {
        $itens = ItemCardapio::where('categoria_id', $id)->get();
        return response()->json($itens);
    }

    // Ordenar Itens
    public function ordenarItens(Request $request)
    {
        $campo = $request->input('campo');
        $ordem = $request->input('ordem', 'asc');

        $itens = ItemCardapio::orderBy($campo, $ordem)->get();
        return response()->json($itens);
    }
}
