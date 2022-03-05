<?php
	$nombre = "No autenticado";
	$nombre_delegada = "No autenticado";
	$email = "No autenticado";
	if (Session::has('UsuarioMp')) {
        $sesion = Session::get('UsuarioMp');
        $nombre = $sesion[0]['nombre'];
        $nombre_delegada = $sesion[0]['nombre_delegada'];
        $email = $sesion[0]['email'];
	}
?>
<br>
<div class="card">
    <div class="card-header" id="headingOne">
        <div class="row">
            <div class="col-md-2 text-right">
                <a href="<?php echo e(route('inicio')); ?>">
                    <img src="<?php echo e(asset("assets/images/logo.png")); ?>" width="140" height="120" class="img-fluid" alt="">
                </a>
            </div>
            <div class="col-md-7 text-center">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" style="color: black !important;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <b><img src="<?php echo e(asset("assets/images/unserInfo.svg")); ?>" width="30px" height="30px">&nbsp;&nbsp; <?php echo e($nombre); ?></b>
                        </a>
                        <div class="dropdown-menu rounded" aria-labelledby="navbarDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 46px, 0px);">
                            <small>
                                <a class="dropdown-item" href="#">
                                    <img src="<?php echo e(asset("assets/images/depend2.svg")); ?>" width="30px" height="30px"> -&nbsp;&nbsp; <strong><?php echo e($nombre_delegada); ?></strong>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <img src="<?php echo e(asset("assets/images/email.svg")); ?>" width="30px" height="30px"> -&nbsp;&nbsp; <strong><?php echo e($email); ?></strong>
                                </a>
                            </small>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <h5><span class="badge badge-danger">
                            <a class="nav-link" href="<?php echo e(route('logout')); ?>" style="color: #FFFFff;">
                                <b><i class="fas fa-running"></i> - Salir del Sistema</b>
                            </a>
                        </span></h5>
                    </li>
                </ul>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\mp\resources\views/plantilla/encabezado.blade.php ENDPATH**/ ?>