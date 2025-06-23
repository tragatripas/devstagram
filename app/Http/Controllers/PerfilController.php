<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //Modificar el request para que el username sea slug
        $request->request->add([
            'username' => Str::slug($request->username),
        ]);
        
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20',
            'not_in:twitter,editar-perfil,perfil,posts,imagenes,logout,register,login'],
        ]);

        if($request->imagen) {
            $imagen = $request->file('imagen');
            
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }
        
        //guardar los cambios del usuario autenticado
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; // Si no hay imagen, mantener la actual'';
        $usuario->save();

        //reedireccionar usuario
        return redirect()->route('posts.index', ['user' => $usuario->username])
            ->with('mensaje', 'Perfil actualizado correctamente');
    }

}
