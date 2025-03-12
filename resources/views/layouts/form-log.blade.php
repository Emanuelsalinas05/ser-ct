

<div class="container-fluid shadow " style="font-size:10px;">

    <div class="tx2 colorBG card-header " >
        &nbsp;<b>ACCESO &nbsp;  <i class="fa fa-desktop"></i></b>
    </div>

    <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                <!-- csrf -->
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input  type="text" name="email"
                            style="color:#802434;"
                            class="tx2 form-control  input-sm @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="USUARIO"
                            autofocus>
                    <div class="input-group-append">
                        <div class="anchlog tx2 input-group-text" >
                            <span class="fa fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}" style="color:#802434; font-weight: bold;"></span>&nbsp;
                        </div>
                    </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="input-group mb-3" id="show_hide_password">
                            <input  type="password" name="password"
                                    style="color:#802434;"
                                    class="tx2 password1 form-control @error('password') is-invalid @enderror"
                                    placeholder="CONTRASEÑA">
                            <div id="pwd" class="input-group-append">
                                <div class="anchlog tx2 input-group-text">
                                    <a href="" style="color:black;">
                                        <i  class="fa fa-eye-slash {{ config('adminlte.classes_auth_icon', '') }}"
                                            aria-hidden="true" style="color:#802434; font-weight: bold;"></i>
                                    </a>
                                </div>
                            </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div>
                    <button type=submit class="btn btn-outline-secondary btn-block btn-sm "
                            style="text-decoration:none; ">
                        Ingresar <i class="fa fa-sign-in"></i>
                    </button>
                </div>
            </form>
    </div>
</div>


