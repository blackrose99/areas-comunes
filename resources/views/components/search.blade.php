<div id="searchComponent" class="card-form text-center">

    <div id="searchForm">
        <h2>Buscar Residente</h2>
        <p class="text-muted mb-4">Ingrese el número de documento del residente para realizar la búsqueda.</p>
        <div class="input-group mb-3">
            <span class="input-group-text bg-primary text-white">
                <i class="fa fa-id-card"></i>
            </span>
            <input type="text" id="document" class="form-control" placeholder="Número de documento">
        </div>
        <button id="checkBtn" class="btn btn-custom w-100 mb-2">
            <i class="fa fa-search"></i> Buscar
        </button>
        <button id="btn_login" class="btn btn-secondary w-100 mb-2">
            <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
        </button>
    </div>

    <div id="div_login" class="card-form text-center" style="display: none;">
        <h2>Iniciar Sesión</h2>
        <p class="text-muted mb-4">Ingrese sus credenciales para acceder al sistema.</p>
        <div class="input-group mb-3">
            <span class="input-group-text bg-primary text-white">
                <i class="fa fa-user"></i>
            </span>
            <input type="text" id="username" class="form-control" placeholder="Usuario">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text bg-primary text-white">
                <i class="fa fa-lock"></i>
            </span>
            <input type="password" id="password" class="form-control" placeholder="Contraseña">
        </div>
        <button id="loginBtn" class="btn btn-custom w-100 mb-2">
            <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
        </button>
        <button id="btn_back_to_search" class="btn btn-secondary w-100 mb-2">
            <i class="fa fa-arrow-left"></i> Volver
        </button>
    </div>

</div>