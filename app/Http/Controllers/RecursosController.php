<?php

namespace App\Http\Controllers;

use App\Contenido;
use App\OpcionContenido;
use App\Recurso;
use Creitive\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    /**
     * RecursosController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        Breadcrumbs::addCrumb('Recursos', 'recursos');
    }

    public function index()
    {
        $recursos = Recurso::paginate(15);
        return view('recursos.index', compact('recursos'));
    }

    public function create()
    {
        Breadcrumbs::addCrumb('Nueva', 'nuevo');
        return view('recursos.create');
    }

    public function store(Request $request)
    {
        //Crear recurso
        \DB::beginTransaction();
        try {
            $data = $request->all();
            $recurso = new Recurso();
            $recurso->codigo = $data['codigo'];
            $recurso->nombre = $data['nombre'];
            $recurso->descripcion = $data['descripcion'];
            $recurso->save();

            //Buscar contenido y agregarlo
            foreach($data['contenidos'] as $c)
            {
                $contenido = new Contenido();
                $contenido->tipo = $c['tipo'];
                $contenido->data = $c['data'];
                $contenido->recurso()->associate($recurso);
                $contenido->save();

                //Asociar a recurso

                if(array_key_exists('opciones',$c))
                    foreach($c['opciones'] as $opt)
                    {
                        $opcion = new OpcionContenido();
                        $opcion->data = $opt['data'];
                        $opcion->correcto = array_get($opt,'correcto', false) === 'on' ? true : false;
                        $opcion->contenido()->associate($contenido);
                        $opcion->save();
                    }

            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e);
            //return $e->getMessage() . ' - ' . $e->getTraceAsString();
        }

        return redirect()->route('recursos.show', $recurso->id);
    }

    public function show($id)
    {
        $recurso = Recurso::with('contenidos','contenidos.opciones')->findOrFail($id);
        Breadcrumbs::addCrumb($recurso->nombre, $id);

        return view('recursos.show', compact('recurso'));
    }

    public function edit($id)
    {
        $recurso = Recurso::findOrFail($id);
        Breadcrumbs::addCrumb($recurso->nombre, $id);
        Breadcrumbs::addCrumb('Editar', 'editar');

        return view('recursos.edit', compact('recurso'));
    }

    public function update($id, Request $request)
    {

        $data = $request->all();
        $recurso = Recurso::findOrFail($id);
        $recurso->codigo = $request->codigo;
        $recurso->nombre = $request->nombre;
        $recurso->descripcion = $request->descripcion;

        $recurso->save();

        //Buscar contenido y agregarlo
        foreach($data['contenidos'] as $c)
        {
            $cId = array_get($c,'id',0);
            $contenido = Contenido::findOrNew($cId);
            $contenido->tipo = $c['tipo'];
            $contenido->data = $c['data'];
            $contenido->recurso()->associate($recurso);
            $contenido->save();

            //Asociar a recurso

            if(array_key_exists('opciones',$c))
                foreach($c['opciones'] as $opt)
                {
                    $optId = array_get($opt,'id',0);
                    $opcion = OpcionContenido::findOrNew($optId);
                    $opcion->data = $opt['data'];
                    $opcion->correcto = array_get($opt,'correcto', false) === 'on' ? true : false;
                    $opcion->contenido()->associate($contenido);
                    $opcion->save();
                }

        }

        return redirect()->route('recursos.show', $id);
    }

    public function delete($id)
    {
        $recurso = Recurso::findOrFail($id);
        $recurso->delete();

        return 'true';
    }
}
