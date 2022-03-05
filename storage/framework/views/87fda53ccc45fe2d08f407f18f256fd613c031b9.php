<?php
    if($btnO){
        if ($rol == 1 || $rol == 6) {
            echo '<a href="'.route('penales1_oficio').'">';
        }
        if ($rol == 2 || $rol == 7) {
            echo '<a href="'.route('penales2_oficio').'">';
        }
        if ($rol == 3) {
            echo '<a href="'.route('movilidad_oficio').'">';
        }
        if ($rol == 4) {
            echo '<a href="'.route('juzgados_oficio').'">';
        }
        if ($rol == 5) {
            echo '<a href="'.route('segunda_oficio').'">';
        }
        if ($rol == 8) {
            echo '<a href="'.route('policivos_oficio').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>OF</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">OFICIO</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnP){
        if ($rol == 1 || $rol == 6) {
            echo '<a href="'.route('penales1_parte').'">';
        }
        if ($rol == 2 || $rol == 7) {
            echo '<a href="'.route('penales2_parte').'">';
        }
        if ($rol == 3) {
            echo '<a href="'.route('movilidad_parte').'">';
        }
        if ($rol == 4) {
            echo '<a href="'.route('juzgados_parte').'">';
        }
        if ($rol == 5) {
            echo '<a href="'.route('segunda_parte').'">';
        }
        if ($rol == 8) {
            echo '<a href="'.route('policivos_parte').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>PA</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">PARTE</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnA){
        if ($rol == 1 || $rol == 6) {
            echo '<a href="'.route('penales1_agencias').'">';
        }
        if ($rol == 2 || $rol == 7) {
            echo '<a href="'.route('penales2_agencias').'">';
        }
        if ($rol == 9) {
            echo '<a href="'.route('coordinador_agencias').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <i class="fa fa-exclamation-circle noti-nivel1" aria-hidden="true" id="noti_nivel1_id1" style="display:none;"></i>';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>AE</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">AGENCIAS ESPECIALES</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnE){
        if ($rol == 1 || $rol == 6) {
            echo '<a href="'.route('penales1_enteramientos').'">';
        }
        if ($rol == 2 || $rol == 7) {
            echo '<a href="'.route('penales2_enteramientos').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>EN</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">ENTERAMIENTOS</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnN){
        if ($rol == 3) {
            echo '<a href="'.route('movilidad_notificaciones').'">';
        }
        if ($rol == 4) {
            echo '<a href="'.route('juzgados_notificaciones').'">';
        }
        if ($rol == 5) {
            echo '<a href="'.route('segunda_notificaciones').'">';
        }
        if ($rol == 8) {
            echo '<a href="'.route('policivos_notificaciones').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>N</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">NOTIFICACIONES</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnC){
        if ($rol == 9) {
            echo '<a href="'.route('coordinador_agencias').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>A</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">AGENCIAS</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnG){
        if ($rol == 10) {
            echo '<a href="'.route('gestion').'">';
        }
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>G</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">GESTIÓN</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }

    if($btnX){
        echo '<a href="'.route('estadisticas_informes').'">';
        echo '    <div class="row">';
        echo '        <div class="col-md-1">';
        echo '            <div class="alert btn btn-primary btn-circle" role="alert"><strong>ES</strong></div>';
        echo '        </div>';
        echo '        <div class="col-md-11">';
        echo '            <div class="alert colorDeFondo" style="color: #FFFFFF" role="alert">ESTADÍSTICAS</div>';
        echo '        </div>';
        echo '    </div>';
        echo '</a>';
    }
?><?php /**PATH C:\laragon\www\mp\resources\views/plantilla/botones.blade.php ENDPATH**/ ?>