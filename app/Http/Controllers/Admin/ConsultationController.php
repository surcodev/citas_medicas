<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Subida de archivos con Dropzone y relación polimórfica.
     */
    public function dropzone(Request $request, Consultation $consultation)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Almacena el archivo en el disco 'public' dentro de una carpeta específica para la consulta
            $path = $file->store('consultations/'.$consultation->id, 'public');

            // Asocia la imagen a esta consulta
            $consultation->images()->create([
                'path' => $path,
                'size' => $file->getSize(),
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
