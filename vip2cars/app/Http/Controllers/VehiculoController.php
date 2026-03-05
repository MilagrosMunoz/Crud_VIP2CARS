<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');

        $vehiculos = Vehiculo::when($busqueda, function ($query) use ($busqueda) {
                $query->where('placa', 'like', "%$busqueda%")
                      ->orWhere('marca', 'like', "%$busqueda%")
                      ->orWhere('nombre_cliente', 'like', "%$busqueda%")
                      ->orWhere('nro_documento', 'like', "%$busqueda%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vehiculos.index', compact('vehiculos', 'busqueda'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa'            => 'required|string|max:10|unique:vehiculos|regex:/^[A-Za-z0-9\-]+$/',
            'marca'            => 'required|string|max:100|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'modelo'           => 'required|string|max:100',
            'anio_fabricacion' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'nombre_cliente'   => 'required|string|max:100|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos_cliente'=> 'required|string|max:150|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'nro_documento'    => 'required|digits:8',
            'correo_cliente'   => 'required|email|max:150',
            'telefono_cliente' => 'required|digits_between:7,15',
        ], [
            'placa.required'            => 'La placa es obligatoria.',
            'placa.unique'              => 'Esa placa ya está registrada.',
            'placa.regex'               => 'La placa solo puede tener letras, números y guiones.',
            'marca.required'            => 'La marca es obligatoria.',
            'marca.regex'               => 'La marca solo puede contener letras.',
            'modelo.required'           => 'El modelo es obligatorio.',
            'anio_fabricacion.required' => 'El año de fabricación es obligatorio.',
            'anio_fabricacion.digits'   => 'El año debe tener exactamente 4 dígitos.',
            'anio_fabricacion.min'      => 'El año no puede ser menor a 1900.',
            'anio_fabricacion.max'      => 'El año no puede ser mayor al actual.',
            'nombre_cliente.required'   => 'El nombre del cliente es obligatorio.',
            'nombre_cliente.regex'      => 'El nombre solo puede contener letras.',
            'apellidos_cliente.required'=> 'Los apellidos son obligatorios.',
            'apellidos_cliente.regex'   => 'Los apellidos solo pueden contener letras.',
            'nro_documento.required'    => 'El número de documento es obligatorio.',
            'nro_documento.digits'      => 'El DNI debe tener exactamente 8 dígitos numéricos.',
            'correo_cliente.required'   => 'El correo es obligatorio.',
            'correo_cliente.email'      => 'El correo no tiene un formato válido.',
            'telefono_cliente.required' => 'El teléfono es obligatorio.',
            'telefono_cliente.digits_between' => 'El teléfono solo puede contener números.',
        ]);

        Vehiculo::create($request->all());

        return redirect()->route('vehiculos.index')
                         ->with('success', 'Vehículo registrado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'placa'            => 'required|string|max:10|unique:vehiculos,placa,' . $vehiculo->id . '|regex:/^[A-Za-z0-9\-]+$/',
            'marca'            => 'required|string|max:100|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'modelo'           => 'required|string|max:100',
            'anio_fabricacion' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'nombre_cliente'   => 'required|string|max:100|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos_cliente'=> 'required|string|max:150|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
            'nro_documento'    => 'required|digits:8',
            'correo_cliente'   => 'required|email|max:150',
            'telefono_cliente' => 'required|digits_between:7,15',
        ], [
            'placa.required'            => 'La placa es obligatoria.',
            'placa.unique'              => 'Esa placa ya está registrada.',
            'placa.regex'               => 'La placa solo puede tener letras, números y guiones.',
            'marca.required'            => 'La marca es obligatoria.',
            'marca.regex'               => 'La marca solo puede contener letras.',
            'modelo.required'           => 'El modelo es obligatorio.',
            'anio_fabricacion.required' => 'El año de fabricación es obligatorio.',
            'anio_fabricacion.digits'   => 'El año debe tener exactamente 4 dígitos.',
            'anio_fabricacion.min'      => 'El año no puede ser menor a 1900.',
            'anio_fabricacion.max'      => 'El año no puede ser mayor al actual.',
            'nombre_cliente.required'   => 'El nombre del cliente es obligatorio.',
            'nombre_cliente.regex'      => 'El nombre solo puede contener letras.',
            'apellidos_cliente.required'=> 'Los apellidos son obligatorios.',
            'apellidos_cliente.regex'   => 'Los apellidos solo pueden contener letras.',
            'nro_documento.required'    => 'El número de documento es obligatorio.',
            'nro_documento.digits'      => 'El DNI debe tener exactamente 8 dígitos numéricos.',
            'correo_cliente.required'   => 'El correo es obligatorio.',
            'correo_cliente.email'      => 'El correo no tiene un formato válido.',
            'telefono_cliente.required' => 'El teléfono es obligatorio.',
            'telefono_cliente.digits_between' => 'El teléfono solo puede contener números.',
        ]);

        $vehiculo->update($request->all());

        return redirect()->route('vehiculos.index')
                         ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
                         ->with('success', 'Vehículo eliminado correctamente.');
    }
}