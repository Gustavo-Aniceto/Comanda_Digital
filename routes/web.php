<?php
use App\Http\Controllers\AdminCardapioController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\QrcodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rotas do AdminCardapioController
Route::prefix('admin')->group(function () {
    // Listar Todos os Itens do Cardápio
    Route::get('/itens-cardapio', [AdminCardapioController::class, 'listarItens']);

    // Criar Novo Item do Cardápio
    Route::post('/itens-cardapio', [AdminCardapioController::class, 'criarItem']);

    // Visualizar Detalhes de um Item do Cardápio
    Route::get('/itens-cardapio/{id}', [AdminCardapioController::class, 'visualizarItem']);

    // Atualizar um Item do Cardápio
    Route::put('/itens-cardapio/{id}', [AdminCardapioController::class, 'atualizarItem']);

    // Remover um Item do Cardápio
    Route::delete('/itens-cardapio/{id}', [AdminCardapioController::class, 'removerItem']);

    // Upload de Imagens para Itens do Cardápio
    Route::post('/itens-cardapio/{id}/upload-imagem', [AdminCardapioController::class, 'uploadImagem']);

    // Listar Todas as Categorias
    Route::get('/categorias', [AdminCardapioController::class, 'listarCategorias']);

    // Adicionar Categoria de Item do Cardápio
    Route::post('/categorias', [AdminCardapioController::class, 'adicionarCategoria']);

    // Relacionar Item do Cardápio com uma Categoria
    Route::post('/itens-cardapio/{id}/relacionar-categoria', [AdminCardapioController::class, 'relacionarItemCategoria']);
});

// Rotas do CardapioController
Route::prefix('cardapio')->group(function () {
    // Listar Todos os Itens do Cardápio
    Route::get('/itens', [CardapioController::class, 'listarItens']);

    // Visualizar Detalhes de um Item do Cardápio
    Route::get('/itens/{id}', [CardapioController::class, 'visualizarDetalhesItem']);

    // Pesquisar Itens do Cardápio
    Route::get('/pesquisar', [CardapioController::class, 'pesquisarItens']);
});

// Rotas do PedidoController
Route::prefix('pedidos')->group(function () {
    // Listar Todos os Pedidos do Usuário
    Route::get('/', [PedidoController::class, 'listarPedidosDoUsuario']);

    // Criar um Novo Pedido
    Route::post('/', [PedidoController::class, 'criarPedido']);

    // Visualizar Detalhes de um Pedido
    Route::get('/{id}', [PedidoController::class, 'visualizarPedido']);

    // Atualizar um Pedido
    Route::put('/{id}', [PedidoController::class, 'atualizarPedido']);

    // Remover um Pedido
    Route::delete('/{id}', [PedidoController::class, 'removerPedido']);

    // Calcular Total do Pedido
    Route::get('/{id}/total', [PedidoController::class, 'calcularTotalPedido']);

    // Visualizar Histórico de Pedidos
    Route::get('/historico', [PedidoController::class, 'visualizarHistoricoPedidos']);
});

// Rota do QrcodeController
Route::get('/qrcode/abrir-cardapio', [QrcodeController::class, 'abrirCardapio']);
