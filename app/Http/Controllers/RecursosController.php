<?php

namespace App\Http\Controllers;

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
        $recurso = Recurso::create($request->all());
        return redirect()->route('recursos.show', $recurso->id);
    }

    public function show($id)
    {
        $recurso = Recurso::findOrFail($id);
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

        $recurso = Recurso::findOrFail($id);
        $recurso->codigo = $request->codigo;
        $recurso->nombre = $request->nombre;
        $recurso->descripcion = $request->descripcion;

        $recurso->save();

        return redirect()->route('recursos.show', $id);
    }

    public function delete($id)
    {
        $recurso = Recurso::findOrFail($id);
        $recurso->delete();

        return 'true';
    }
}
