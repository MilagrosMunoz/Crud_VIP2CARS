@extends('vehiculos.layout')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Vehículos registrados</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
        <i class="bi bi-plus-circle"></i> Nuevo vehículo
    </button>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('vehiculos.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="busqueda" class="form-control"
               placeholder="Buscar por placa, marca, cliente o documento..."
               value="{{ $busqueda }}">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i> Buscar
        </button>
        @if($busqueda)
            <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-danger">
                <i class="bi bi-x"></i> Limpiar
            </a>
        @endif
    </div>
</form>

{{-- Tabla --}}
@if($vehiculos->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead>
            <tr>
                <th>#</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehiculos as $vehiculo)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><span class="badge bg-dark">{{ $vehiculo->placa }}</span></td>
                <td>{{ $vehiculo->marca }}</td>
                <td>{{ $vehiculo->modelo }}</td>
                <td>{{ $vehiculo->anio_fabricacion }}</td>
                <td>{{ $vehiculo->nombre_cliente }} {{ $vehiculo->apellidos_cliente }}</td>
                <td>{{ $vehiculo->nro_documento }}</td>
                <td>
                    {{-- Ver --}}
                    <button class="btn btn-sm btn-info text-white"
                        data-bs-toggle="modal"
                        data-bs-target="#modalVer"
                        data-placa="{{ $vehiculo->placa }}"
                        data-marca="{{ $vehiculo->marca }}"
                        data-modelo="{{ $vehiculo->modelo }}"
                        data-anio="{{ $vehiculo->anio_fabricacion }}"
                        data-nombre="{{ $vehiculo->nombre_cliente }}"
                        data-apellidos="{{ $vehiculo->apellidos_cliente }}"
                        data-documento="{{ $vehiculo->nro_documento }}"
                        data-correo="{{ $vehiculo->correo_cliente }}"
                        data-telefono="{{ $vehiculo->telefono_cliente }}">
                        <i class="bi bi-eye"></i>
                    </button>
                    {{-- Editar --}}
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar"
                        data-id="{{ $vehiculo->id }}"
                        data-placa="{{ $vehiculo->placa }}"
                        data-marca="{{ $vehiculo->marca }}"
                        data-modelo="{{ $vehiculo->modelo }}"
                        data-anio="{{ $vehiculo->anio_fabricacion }}"
                        data-nombre="{{ $vehiculo->nombre_cliente }}"
                        data-apellidos="{{ $vehiculo->apellidos_cliente }}"
                        data-documento="{{ $vehiculo->nro_documento }}"
                        data-correo="{{ $vehiculo->correo_cliente }}"
                        data-telefono="{{ $vehiculo->telefono_cliente }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    {{-- Eliminar --}}
                    <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEliminar"
                        data-id="{{ $vehiculo->id }}"
                        data-placa="{{ $vehiculo->placa }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Paginación --}}
<div class="d-flex justify-content-center">
    {{ $vehiculos->appends(['busqueda' => $busqueda])->links() }}
</div>

@else
<div class="alert alert-info text-center">
    No se encontraron vehículos registrados.
</div>
@endif

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Registrar nuevo vehículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vehiculos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h6 class="text-muted mb-3">Datos del vehículo</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Placa *</label>
                            <input type="text" name="placa" class="form-control @error('placa') is-invalid @enderror"
                                   value="{{ old('placa') }}" placeholder="ABC-123">
                            @error('placa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marca *</label>
                            <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror"
                                   value="{{ old('marca') }}" placeholder="Toyota">
                            @error('marca')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Modelo *</label>
                            <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                                   value="{{ old('modelo') }}" placeholder="Corolla">
                            @error('modelo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Año de fabricación *</label>
                            <input type="number" name="anio_fabricacion" class="form-control @error('anio_fabricacion') is-invalid @enderror"
                                   value="{{ old('anio_fabricacion') }}" placeholder="2020" min="1900" max="{{ date('Y') }}">
                            @error('anio_fabricacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Datos del cliente</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre_cliente" class="form-control @error('nombre_cliente') is-invalid @enderror"
                                   value="{{ old('nombre_cliente') }}" placeholder="Juan">
                            @error('nombre_cliente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos_cliente" class="form-control @error('apellidos_cliente') is-invalid @enderror"
                                   value="{{ old('apellidos_cliente') }}" placeholder="Pérez García">
                            @error('apellidos_cliente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Nro. Documento *</label>
                            <input type="text" name="nro_documento" class="form-control @error('nro_documento') is-invalid @enderror"
                                   value="{{ old('nro_documento') }}" placeholder="12345678" maxlength="8">
                            @error('nro_documento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo *</label>
                            <input type="email" name="correo_cliente" class="form-control @error('correo_cliente') is-invalid @enderror"
                                   value="{{ old('correo_cliente') }}" placeholder="juan@email.com">
                            @error('correo_cliente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono_cliente" class="form-control @error('telefono_cliente') is-invalid @enderror"
                                   value="{{ old('telefono_cliente') }}" placeholder="999888777" maxlength="15">
                            @error('telefono_cliente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL VER --}}
<div class="modal fade" id="modalVer" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-eye"></i> Detalle del vehículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-muted mb-3">Datos del vehículo</h6>
                <div class="row mb-3">
                    <div class="col-md-4"><label class="fw-bold">Placa</label><p id="ver-placa"></p></div>
                    <div class="col-md-4"><label class="fw-bold">Marca</label><p id="ver-marca"></p></div>
                    <div class="col-md-4"><label class="fw-bold">Modelo</label><p id="ver-modelo"></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><label class="fw-bold">Año de fabricación</label><p id="ver-anio"></p></div>
                </div>
                <hr>
                <h6 class="text-muted mb-3">Datos del cliente</h6>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="fw-bold">Nombre</label><p id="ver-nombre"></p></div>
                    <div class="col-md-6"><label class="fw-bold">Apellidos</label><p id="ver-apellidos"></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><label class="fw-bold">Nro. Documento</label><p id="ver-documento"></p></div>
                    <div class="col-md-4"><label class="fw-bold">Correo</label><p id="ver-correo"></p></div>
                    <div class="col-md-4"><label class="fw-bold">Teléfono</label><p id="ver-telefono"></p></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditar" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <h6 class="text-muted mb-3">Datos del vehículo</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Placa *</label>
                            <input type="text" name="placa" id="edit-placa" class="form-control" placeholder="ABC-123">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Marca *</label>
                            <input type="text" name="marca" id="edit-marca" class="form-control" placeholder="Toyota">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Modelo *</label>
                            <input type="text" name="modelo" id="edit-modelo" class="form-control" placeholder="Corolla">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Año de fabricación *</label>
                            <input type="number" name="anio_fabricacion" id="edit-anio" class="form-control" min="1900" max="{{ date('Y') }}">
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Datos del cliente</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre_cliente" id="edit-nombre" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos_cliente" id="edit-apellidos" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Nro. Documento *</label>
                            <input type="text" name="nro_documento" id="edit-documento" class="form-control" maxlength="8">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo *</label>
                            <input type="email" name="correo_cliente" id="edit-correo" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono_cliente" id="edit-telefono" class="form-control" maxlength="15">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL ELIMINAR --}}
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-trash"></i> Eliminar vehículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas eliminar el vehículo con placa <strong id="eliminar-placa"></strong>?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <form id="formEliminar" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal Ver
    document.getElementById('modalVer').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('ver-placa').textContent     = btn.dataset.placa;
        document.getElementById('ver-marca').textContent     = btn.dataset.marca;
        document.getElementById('ver-modelo').textContent    = btn.dataset.modelo;
        document.getElementById('ver-anio').textContent      = btn.dataset.anio;
        document.getElementById('ver-nombre').textContent    = btn.dataset.nombre;
        document.getElementById('ver-apellidos').textContent = btn.dataset.apellidos;
        document.getElementById('ver-documento').textContent = btn.dataset.documento;
        document.getElementById('ver-correo').textContent    = btn.dataset.correo;
        document.getElementById('ver-telefono').textContent  = btn.dataset.telefono;
    });

    // Modal Editar
    document.getElementById('modalEditar').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        const id  = btn.dataset.id;
        document.getElementById('formEditar').action        = '/vehiculos/' + id;
        document.getElementById('edit-id').value            = id;
        document.getElementById('edit-placa').value         = btn.dataset.placa;
        document.getElementById('edit-marca').value         = btn.dataset.marca;
        document.getElementById('edit-modelo').value        = btn.dataset.modelo;
        document.getElementById('edit-anio').value          = btn.dataset.anio;
        document.getElementById('edit-nombre').value        = btn.dataset.nombre;
        document.getElementById('edit-apellidos').value     = btn.dataset.apellidos;
        document.getElementById('edit-documento').value     = btn.dataset.documento;
        document.getElementById('edit-correo').value        = btn.dataset.correo;
        document.getElementById('edit-telefono').value      = btn.dataset.telefono;
    });

    // Modal Eliminar
    document.getElementById('modalEliminar').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        const id  = btn.dataset.id;
        document.getElementById('formEliminar').action           = '/vehiculos/' + id;
        document.getElementById('eliminar-placa').textContent    = btn.dataset.placa;
    });

    // Reabrir modal si hay errores de validación
    @if($errors->any())
        window.addEventListener('DOMContentLoaded', function() {
            @if(old('_method') == 'PUT')
                var modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
                document.getElementById('formEditar').action        = '/vehiculos/{{ old("id") }}';
                document.getElementById('edit-id').value            = "{{ old('id') }}";
                document.getElementById('edit-placa').value         = "{{ old('placa') }}";
                document.getElementById('edit-marca').value         = "{{ old('marca') }}";
                document.getElementById('edit-modelo').value        = "{{ old('modelo') }}";
                document.getElementById('edit-anio').value          = "{{ old('anio_fabricacion') }}";
                document.getElementById('edit-nombre').value        = "{{ old('nombre_cliente') }}";
                document.getElementById('edit-apellidos').value     = "{{ old('apellidos_cliente') }}";
                document.getElementById('edit-documento').value     = "{{ old('nro_documento') }}";
                document.getElementById('edit-correo').value        = "{{ old('correo_cliente') }}";
                document.getElementById('edit-telefono').value      = "{{ old('telefono_cliente') }}";
                modalEditar.show();
            @else
                var modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'));
                modalCrear.show();
            @endif
        });
    @endif

    // Validaciones frontend
    document.querySelectorAll('input[name="nombre_cliente"], input[name="apellidos_cliente"]').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    });

    document.querySelectorAll('input[name="nro_documento"]').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    document.querySelectorAll('input[name="telefono_cliente"]').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection