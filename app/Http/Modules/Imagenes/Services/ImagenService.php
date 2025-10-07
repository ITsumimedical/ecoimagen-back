<?php

namespace App\Http\Modules\Imagenes\Services;

use App\Http\Modules\Imagenes\Models\Imagene;


class ImagenService
{

    // public function __construct(protected ImagenRepository $imagenRepository)
    // {
    // }

    public function crearImagen($request)
    {


        if ($request->hasFile('imagenes')) {

            $files = $request->file('imagenes');
            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $path = '../storage/app/public/imagenEntidad/'. $request['entidad_id'] ;
                $pathDB = '/storage/imagenEntidad/' . $request['entidad_id'] .'/' . $file_name;
                $file->move($path, $file_name);
                Imagene::create([
                    'nombre' => $request['nombre'],
                    'ruta' => $pathDB,
                    'nombre_imagen' => $file_name,
                    'entidad_id' => $request['entidad_id'],
                ]);
            }

            return 'Estadística creada con éxito';
        } else {
          return  'Estadística creada con éxito';
        }
    }


    public function actualizarImagen($request)
    {
      $imagen =  Imagene::find($request['id']);
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $file_name = $file->getClientOriginalName();
            if($file != $imagen->nombre_imagen){
                $path = '../storage/app/public/imagenEntidad/'. $imagen->entidad_id ;
                $pathDB = '/storage/imagenEntidad/' . $imagen->entidad_id .'/' . $file_name;
                $file->move($path, $file_name);
                $imagen->update(['nombre' => $request['nombre'],
                    'ruta' => $pathDB,
                    'nombre_imagen' => $file_name,]);
            }else{
                $imagen->update(['nombre' => $request['nombre']]);
            }


            return 'Estadística ups1 con éxito';
        } else {
            $imagen->update(['nombre' => $request['nombre']]);
          return  'Estadística ups2 con éxito';
        }
    }

    public function eliminar($data){
        Imagene::find($data['id'])->delete();
    }
}
