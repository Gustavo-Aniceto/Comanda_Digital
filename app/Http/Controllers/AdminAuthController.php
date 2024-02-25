<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Mostra o formulário de registro
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    // Processa o registro do administrador
    public function register(Request $request)
    {
        // Valida os dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cria um novo administrador
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redireciona para a página de login
        return redirect()->route('admin.login')->with('success', 'Administrador registrado com sucesso!');
    }

    // Mostra o formulário de login
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Processa o login do administrador
    public function login(Request $request)
    {
        // Valida os dados do formulário de login
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tenta fazer login do administrador
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            // Se o login for bem-sucedido, redireciona para a página de dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
        }

        // Se o login falhar, redireciona de volta com uma mensagem de erro
        return redirect()->route('admin.login')->withErrors(['email' => 'Credenciais inválidas']);
    }

    // Faz logout do administrador
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
