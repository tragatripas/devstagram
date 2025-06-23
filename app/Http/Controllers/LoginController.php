<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        //VALIDACION
        return view('auth.login');
    }

    public function store(Request $request)
    {
       
        //VALIDACION
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]); 
        
        //AUTENTICACION DEL USUARIO
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            //REDIRECCIONAMIENTO
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        //REDIRECCIONAMIENTO CON ÉXITO
        return redirect()->route('posts.index', ['user' => auth()->user()->username]);
    }
}
