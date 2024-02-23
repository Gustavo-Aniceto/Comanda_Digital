<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Pedido; // Importe o modelo Pedido

class PagamentoController extends Controller
{
    // Processar Pagamento
    public function processarPagamento(Request $request)
    {
        // Simulação de integração com gateway de pagamento fictício
        $client = new Client();
        
        try {
            // Envio dos dados do pedido para o gateway de pagamento
            $response = $client->post('http://gateway-pagamento.exemplo/pagamento', [
                'json' => $request->all(),
            ]);

            // Verificar resposta do gateway de pagamento
            if ($response->getStatusCode() == 200) {
                // O pagamento foi bem-sucedido
                $dadosPagamento = json_decode($response->getBody(), true);

                // Aqui você pode processar os dados do pagamento e atualizar o status do pedido no seu sistema
                $pedidoId = $request->input('pedido_id'); // Supondo que o ID do pedido seja enviado junto com os dados de pagamento
                $pedido = Pedido::find($pedidoId);
            
                if ($pedido) {
                    // Atualizar o status do pedido para "Pago"
                    $pedido->status = 'Pago';
                    $pedido->save();
            

                    return response()->json(['mensagem' => 'Pagamento realizado com sucesso', 'dados_pagamento' => $dadosPagamento]);
                } else {
                    return response()->json(['erro' => 'Pedido não encontrado'], 404);
                }
            } else {
                // Falha no pagamento
                return response()->json(['erro' => 'Falha ao processar o pagamento'], 400);
            }
        } catch (\Exception $e) {
            // Tratar erros de conexão com o gateway de pagamento
            return response()->json(['erro' => 'Erro ao conectar-se ao gateway de pagamento'], 500);
        }
    }
}
