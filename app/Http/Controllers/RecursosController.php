<?php

namespace App\Http\Controllers;

use App\Contenido;
use App\OpcionContenido;
use App\Recurso;
use Creitive\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecursosController extends Controller
{
    private $uploadRelativePath = 'app/public/recursos/';
    private $assetRelativePath = 'storage/recursos/';

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
            $recurso->descripcion = $data['descripcion'] === null ? '' : $data['descripcion'];
            $recurso->save();

            //Buscar contenido y agregarlo
            for ($j = 0; $j < count($data['contenidos']); $j++) {
                $c = $data['contenidos'][$j];
                $contenido = new Contenido();
                $contenido->tipo = $c['tipo'];
                $contenido->data = $c['data'];
                $contenido->indice = $j;
                $contenido->recurso()->associate($recurso);

                //Buscar imagen
                $uploadedFile = array_get($c, 'imagen', null);
                if (isset($uploadedFile)) {
                    $contenido->imagen = $this->processUploadedFile($uploadedFile, $recurso->id);
                }

                $contenido->save();

                //Asociar a recurso
                if (array_key_exists('opciones', $c)) {
                    for ($i = 0; $i < count($c['opciones']); $i++) {
                        $opt = $c['opciones'][$i];
                        $opcion = new OpcionContenido();
                        $opcion->data = $opt['data'];
                        $opcion->data_secundaria = array_get($opt,'data_secundaria', '');
                        $opcion->tipo = $opt['tipo'];
                        $opcion->indice = $i;
                        $opcion->contenido()->associate($contenido);

                        //Check if the data uploaded was actually an UploadedFile
                        if(is_a($opcion->data, UploadedFile::class))
                        {
                            $opcion->data = $this->processUploadedFile($opcion->data, $recurso->id . '-opcion');
                        }

                        if(is_a($opcion->data_secundaria, UploadedFile::class))
                        {
                            $opcion->data_secundaria = $this->processUploadedFile($opcion->data_secundaria, $recurso->id . '-opcion');
                        }

                        $opcion->save();
                    }
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
        $recurso = Recurso::with('contenidos', 'contenidos.opciones')->findOrFail($id);
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
        \DB::beginTransaction();
        try {
            $data = $request->all();
            $recurso = Recurso::findOrFail($id);
            $recurso->codigo = $request->codigo;
            $recurso->nombre = $request->nombre;
            $recurso->descripcion = $data['descripcion'] === null ? '' : $data['descripcion'];

            $recurso->save();
            $contenidoMap = [];
            //Buscar contenido y agregarlo
            for ($j = 0; $j < count($data['contenidos']); $j++) {
                $c = $data['contenidos'][$j];
                $cId = array_get($c, 'id', 0);
                $contenido = Contenido::findOrNew($cId);
                $contenido->tipo = $c['tipo'];
                $contenido->data = $c['data'];
                $contenido->indice = $j;
                $contenido->recurso()->associate($recurso);

                //Eliminar imágen antigua si esta fue desvinculada
                if(strlen($contenido->imagen) > 0 && array_get($c, 'imagen-url','') !== $contenido->imagen)
                {
                    if(file_exists(storage_path($this->uploadRelativePath) . basename($contenido->imagen)))
                        unlink(storage_path($this->uploadRelativePath) . basename($contenido->imagen));

                    $contenido->imagen = '';
                }

                //Buscar imagen
                $uploadedFile = array_get($c, 'imagen', null);
                if (isset($uploadedFile)) {
                    //Parsear y copiar imagen
                    $filename = uniqid('recurso-' . $recurso->id . '-img-') . '.' . $uploadedFile->getClientOriginalExtension();
                    $moved = $uploadedFile->move(storage_path($this->uploadRelativePath), $filename);

                    if (!$moved)
                        throw new \Exception("Error moviendo archivo");

                    $contenido->imagen = asset($this->assetRelativePath . $filename);
                }

                $contenido->save();

                $contenidoMap[$contenido->id] = $contenido;

                $opcionMap = [];
                if (array_key_exists('opciones', $c)) {
                    for ($i = 0; $i < count($c['opciones']); $i++) {
                        $opt = $c['opciones'][$i];
                        $optId = array_get($opt, 'id', 0);
                        $opcion = OpcionContenido::findOrNew($optId);
                        $opcion->indice = $i;
                        $opcion->tipo = $opt['tipo'];
                        $opcion->contenido()->associate($contenido);

                        //Eliminar imágen antigua si esta fue desvinculada
                        if($opcion->containsImageOnPrimaryData() && array_get($opt, 'data','') !== $opcion->data)
                        {
                            if(file_exists(storage_path($this->uploadRelativePath) . basename($opcion->data)))
                                unlink(storage_path($this->uploadRelativePath) . basename($opcion->data));
                        }

                        //Luego de la posible eliminacion, setear
                        $opcion->data = $opt['data'];

                        //Check if the data uploaded was actually an UploadedFile
                        if(is_a($opcion->data, UploadedFile::class))
                        {
                            $path = $this->processUploadedFile($opcion->data, $recurso->id . '-opcion');
                            $opcion->data = $path;
                        }

                        //Secondary data processing
                        if($opcion->containsImageOnSecondaryData()&& array_get($opt, 'data_secundaria', '') !== $opcion->data_secundaria)
                        {
                            if(file_exists(storage_path($this->uploadRelativePath) . basename($opcion->data_secundaria)))
                                unlink(storage_path($this->uploadRelativePath) . basename($opcion->data_secundaria));
                        }

                        //Luego de la posible eliminacion, setear
                        $opcion->data_secundaria = array_get($opt, 'data_secundaria', '');

                        //Check if the data uploaded was actually an UploadedFile
                        if(is_a($opcion->data_secundaria, UploadedFile::class))
                        {
                            $path = $this->processUploadedFile($opcion->data_secundaria, $recurso->id . '-opcion');
                            $opcion->data_secundaria = $path;
                        }

                        $opcion->save();

                        $opcionMap[$opcion->id] = $opcion;
                    }
                }

                //Borrar todos las opciones que no fueron guardadas (ya no existen)
                foreach ($contenido->opciones as $opt) {
                    if (!array_key_exists($opt->id, $opcionMap))
                        $opt->delete();
                }
            }

            //Borrar todos las opciones que no fueron guardadas (ya no existen)
            foreach ($recurso->contenidos as $cont) {
                if (!array_key_exists($cont->id, $contenidoMap))
                    $cont->delete();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e);
        }

        return redirect()->route('recursos.show', $id);
    }

    public function delete($id)
    {
        $recurso = Recurso::findOrFail($id);
        $recurso->delete();

        return 'true';
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param $uniqueId
     * @return string
     * @throws \Exception
     */
    private function processUploadedFile(UploadedFile $uploadedFile, $identifier)
    {
        //Parsear y copiar imagen
        $filename = uniqid('recurso-' . $identifier . '-img-') . '.' . $uploadedFile->getClientOriginalExtension();
        $moved = $uploadedFile->move(storage_path($this->uploadRelativePath), $filename);

        if (!$moved)
            throw new \Exception("Error moviendo archivo");

        return asset($this->assetRelativePath . $filename);
    }
}
