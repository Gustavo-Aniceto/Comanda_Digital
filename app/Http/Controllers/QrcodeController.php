<?php

namespace App\Http\Controllers;

class QrcodeController extends Controller
{
    public function abrirCardapio()
    {
        // Aqui você pode gerar um URL único que representa o cardápio
        $urlCardapio = route('cardapio.index');

        // Redirecionar o usuário para o cardápio
        return redirect()->to($urlCardapio);
    }
}
