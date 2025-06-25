<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'email'    => ['required','email' , 'unique:users,email,'.  auth()->user()->id, 'max:60'],
            'oldpassword' => ['required_with:password',],
            'password' => ['sometimes', 'nullable', 'confirmed', 'min:6'],
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
        $usuario->email    = $request->email;
        $usuario->imagen   = $nombreImagen ?? auth()->user()->imagen ?? null; // Si no hay imagen, mantener la actual'';
        
        // Verificamos si quiere cambiar la contraseña
        if ($request->filled('password')) {

            // Verificamos que la contraseña antigua sea correcta
            if (!Hash::check($request->oldpassword, $usuario->password)) {
                return back()->withErrors(['oldpassword' => 'La contraseña actual no es correcta.']);
            }

            // Todo ok, actualizamos la nueva contraseña
            $usuario->password = Hash::make($request->password);
        }
        
        $usuario->save();

        //reedireccionar usuario
        return redirect()->route('posts.index', ['user' => $usuario->username])
            ->with('mensaje', 'Perfil actualizado correctamente');
    }

}
