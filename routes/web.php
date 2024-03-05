<?php
use App\Http\Controllers\AdminCardapioController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\QrcodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
Route::prefix('admin')->group(function (){
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

    // Atualizar Categoria
    Route::put('/categorias/{id}', [AdminCardapioController::class, 'atualizarCategoria']);

    // Remover Categoria
    Route::delete('/categorias/{id}', [AdminCardapioController::class, 'removerCategoria']);
  
    // Visualizar Itens por Categoria
    Route::get('/categorias/{id}/itens', [AdminCardapioController::class, 'visualizarItensPorCategoria']);
  
    // Ordenar Itens
    Route::get('/itens-cardapio/ordenar', [AdminCardapioController::class, 'ordenarItens']);
  });

// Rotas do CardapioController
Route::prefix('cardapio')->group(function () {

    //listar categorias
    Route::get('/listar-categorias', 'CardapioController@listarCategorias');

    // Listar Todos os Itens do Cardápio
    Route::get('/itens', [CardapioController::class, 'listarItens']);

    // Visualizar Detalhes de um Item do Cardápio
    Route::get('/itens/{id}', [CardapioController::class, 'visualizarDetalhesItem']);

    // Pesquisar Itens do Cardápio
    Route::get('/pesquisar', [CardapioController::class, 'pesquisarItens']);

     // Filtrar Itens por Categoria
     Route::get('/itens/filtrar', [CardapioController::class, 'filtrarItensPorCategoria']);

     // Ordenar Itens
     Route::get('/itens/ordenar', [CardapioController::class, 'ordenarItens']);
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

    // Adicionar Observação ao Pedido
    Route::put('/{id}/adicionar-observacao', [PedidoController::class, 'adicionarObservacao']);

    // Confirmar Pedido
    Route::put('/{id}/confirmar', [PedidoController::class, 'confirmarPedido']);
    
    // Cancelar Pedido
    Route::put('/{id}/cancelar', [PedidoController::class, 'cancelarPedido']);

    Route::get('/pedidos/novos', 'PedidoController@buscarNovosPedidos');
});

// Rota do QrcodeController
Route::get('/qrcode/abrir-cardapio', [QrcodeController::class, 'abrirCardapio']);


//Rota para login e autentificação 
// Rota para exibir o formulário de login para administradores
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');

// Rotas de administradores
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('admin.logout');


  //rota para Autentificação
  Route::prefix('admin')->group(function () {
    // Rotas de autenticação
    Route::get('/register', 'AdminAuthController@showRegisterForm')->name('admin.register');
    Route::post('/register', 'AdminAuthController@register');
    Route::get('/login', 'AdminAuthController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuthController@login');
    Route::post('/logout', 'AdminAuthController@logout')->name('admin.logout');
});
