<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function checkResident(Request $request)
    {
        $document = trim($request->input('document'));

        if (empty($document)) {
            return response()->json(['exists' => false, 'message' => 'Debe ingresar un documento.'], 400);
        }

        $document = strval($document);

        $resident = Resident::where('document', $document)->first();

        if (!$resident) {
            return response()->json(['exists' => false, 'message' => 'No existe ese Residente en la base de datos.']);
        }

        if (!empty($resident->blocked) || $resident->status === 'inactive') {
            return response()->json(['exists' => false, 'message' => 'El residente está bloqueado o suspendido.']);
        }

        return response()->json([
            'exists' => true,
            'resident' => [
                'id' => $resident->id,
                'name' => $resident->name,
                'last_name' => $resident->last_name,
                'document' => $resident->document,
                'document_type' => $resident->document_type,
                'email' => $resident->email,
                'phone' => $resident->phone,
                'address' => $resident->address,
                'birth_date' => $resident->birth_date,
                'status' => $resident->status,
            ]
        ]);
    }


    public function registerResident(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document' => 'required|string|max:50|unique:residents,document',
            'document_type' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:residents,email',
            'phone' => 'nullable|string|max:20|unique:residents,phone',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $resident = Resident::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Residente registrado exitosamente.',
            'resident' => $resident
        ]);
    }
}
