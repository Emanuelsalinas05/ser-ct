<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="color: #802434; font-weight: bold; margin-bottom: 15px;">¡BIENVENIDO SEREEB!</h3>
    <p style="font-size: 14px; color: #6c757d; line-height: 1.8; margin: 0;">
        Sistema para la Entrega Recepción de Escuelas<br>
        de Educación Básica
    </p>
</div>


<form method="POST" action="{{ route('login') }}" style="max-width: 380px; margin: 0 auto;">
    @csrf

    <!-- Clave Centro de Trabajo -->
    <label for="email" style="color: #802434; font-weight: 600; font-size: 14px; margin-bottom: 6px;">Clave Centro de Trabajo</label>
    <div class="input-group mb-4">
        <input type="text"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               style="background-color: #f5f6fa; border: none; border-radius: 30px; padding: 12px 20px; color: #802434; font-size: 14px;"
               placeholder="CLAVE DE CENTRO DE TRABAJO"
               value="{{ old('email') }}" autofocus>

        <div class="input-group-append">
        <span class="input-group-text" style="background: none; border: none;">
            <i class="fas fa-user-circle" style="color: #802434; font-size: 18px;"></i>
        </span>
        </div>

        @error('email')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>

    <!-- Contraseña -->
    <label for="password" style="color: #802434; font-weight: 600; font-size: 14px; margin-bottom: 6px;">Contraseña</label>
    <div class="input-group mb-4" id="show_hide_password">
        <input type="password"
               name="password"
               id="password"
               class="form-control @error('password') is-invalid @enderror"
               style="background-color: #f5f6fa; border: none; border-radius: 30px; padding: 12px 20px; color: #802434; font-size: 14px;"
               placeholder="CONTRASEÑA">

        <div class="input-group-append">
        <span class="input-group-text" style="background: none; border: none;">
            <a href="#" style="background: none; border: none; padding: 0;">
                <i class="fa fa-eye-slash" style="color: #802434; font-size: 18px;"></i>
            </a>
        </span>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>


    <!-- Botón -->
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn"
                style="background-color: #802434; color: white; font-weight: bold; border-radius: 30px; padding: 12px 40px; font-size: 16px;">
            INGRESAR
        </button>
    </div>
</form>
