<?php

namespace App\Http\Controllers;

use App\Jugador;
use App\Recurso;
use App\RecursoOverride;
use Creitive\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $uploadUserRelativePath = 'app/public/users/avatars/';
    private $assetUserRelativePath = 'storage/users/avatars/';

    public function edit()
    {
        return view('user.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->nombre = $request->nombre;
        $user->descripcion = $request->descripcion;

        //Check for avatar upload
        $uploadedFile = $request->avatar;
        if (isset($uploadedFile)) {

            //Remove old file if existent
            if(!empty($user->avatar)){
                //Get the old file name
                $oldFile = basename($user->avatar);
                $path = storage_path($this->uploadUserRelativePath) . $oldFile;
                unlink($path);
            }

            //Parsear y copiar imagen
            $filename = uniqid('user-avatar-') . '.' . $uploadedFile->getClientOriginalExtension();
            $moved = $uploadedFile->move(storage_path($this->uploadUserRelativePath), $filename);

            if(!$moved)
                throw new \Exception("Error moviendo archivo");

            $user->avatar = asset($this->assetUserRelativePath . $filename);
        }

        $user->save();

        return redirect()->route('user.profile');
    }

    public function showProfile()
    {
        Breadcrumbs::addCrumb(Auth::user()->nombre ,'user');
        Breadcrumbs::addCrumb('Perfil','profile');
        return view('user.profile');
    }

    public function indexOverrides()
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre ,'user');
        Breadcrumbs::addCrumb('Mis Recursos Sobreescritos','overrides');

        $overrides = $user->recursoOverrides()->paginate(15);
        return view('user.overrides', compact('overrides'));
    }

    public function nuevoOverride()
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre ,'user');
        Breadcrumbs::addCrumb('Mis Recursos Sobreescritos','overrides');
        Breadcrumbs::addCrumb('Nuevo','nuevo');

        $overrides = Recurso::all();
        $jugadores = $user->jugadores;

        return view('user.overrides.create',compact('overrides','jugadores'));
    }

    public function showOverride($id)
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre,'user');
        Breadcrumbs::addCrumb('Mis Recursos Sobreescritos','overrides');

        $override = RecursoOverride::find($id);

        Breadcrumbs::addCrumb($id . ' - ' . $override->recurso->codigo, $id);

        return view('user.overrides.show', compact('override'));
    }

    public function storeOverride(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $override = RecursoOverride::create($data);
        $jugadores = explode(',',$request->jugadores);
        $override->jugadores()->sync($jugadores);

        return redirect()->route('user.overrides.show', $override->id);
    }

    public function editOverride($id)
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre,'user');
        Breadcrumbs::addCrumb('Mis Recursos Sobreescritos','overrides');

        $override = RecursoOverride::findOrFail($id);
        $jugadores = $user->jugadores;


        Breadcrumbs::addCrumb($id . ' - ' . $override->recurso->codigo, $id);
        Breadcrumbs::addCrumb('Editar', 'editar');

        return view('user.overrides.edit', compact('override','jugadores'));
    }

    public function updateOverride($id, Request $request)
    {
        $override = RecursoOverride::findOrFail($id);
        $override->nombre = $request->nombre;
        $override->descripcion = $request->descripcion;
        $jugadores = explode(',',$request->jugadores);
        $override->jugadores()->sync($jugadores);

        $override->save();
        return redirect()->route('user.overrides.show', $id);
    }

    public function deleteOverride($id)
    {
        $override = RecursoOverride::findOrFail($id);
        $override->delete();
        return 'true';
    }

    //Jugadores
    public function indexJugadores()
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre ,'user');
        Breadcrumbs::addCrumb('Mis Jugadores','jugadores');

        $jugadores = $user->jugadores()->paginate(15);
        return view('user.jugadores', compact('jugadores'));
    }

    public function nuevoJugador()
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre ,'user');
        Breadcrumbs::addCrumb('Mis Jugadores','jugadores');
        Breadcrumbs::addCrumb('Nuevo','nuevo');

        return view('user.jugadores.create');
    }

    public function showJugador($id)
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre,'user');
        Breadcrumbs::addCrumb('Mis Jugadores','jugadores');

        $jugador = Jugador::findOrFail($id);
        Breadcrumbs::addCrumb($jugador->codigo, $id);

        return view('user.jugadores.show', compact('jugador'));
    }

    public function storeJugador(Request $request)
    {
        $jugador = new Jugador();
        $jugador->nombre = $request->nombre;
        $jugador->user_id = Auth::user()->id;

        $jugador->save();
        return redirect()->route('user.jugadores.show', $request->jugador_id);
    }

    public function editJugador($id)
    {
        $user = Auth::user();
        Breadcrumbs::addCrumb($user->nombre,'user');
        Breadcrumbs::addCrumb('Mis Jugadores','jugadores');

        $jugador = Jugador::findOrFail($id);

        Breadcrumbs::addCrumb($jugador->codigo, $id);
        Breadcrumbs::addCrumb('Editar', 'editar');

        return view('user.jugadores.edit', compact('jugador'));
    }

    public function updateJugador($id, Request $request)
    {
        $user = Auth::user();
        $jugador = Jugador::findOrFail($id);
        $jugador->nombre = $request->nombre;
        $jugador->save();

        return redirect()->route('user.jugadores.show', $id);
    }

    public function deleteJugador($id)
    {
        $user = Auth::user();
        Jugador::findOrFail($id)->delete();
        return 'true';
    }

    //TODO: vista para ver overrides de jugador
    public function jugadorRecursos($jugadorId, $codes)
    {
        $overrides =  Jugador::findOrFail($jugadorId)->overrides->keyBy(function($item){
            return $item->recurso->codigo;
        });

        $recursos = Recurso::whereIn('codigo',explode(',',$codes))->get()->keyBy('codigo');

        //Override
        foreach($recursos as $key => &$value){
            if($overrides->has($key)){
                $value->nombre = $overrides[$key]->nombre;
                $value->descripcion = $overrides[$key]->descripcion;
            }
        }

        return $recursos;
    }
}
