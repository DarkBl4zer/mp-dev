<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?php echo $__env->yieldContent('titulo', 'Inicio'); ?> | MP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--============================= Estilos Plugins =============================-->
        <!-- Bootstrap 4.3.1 -->
        <link rel="stylesheet" href="<?php echo e(asset("assets/plugins/bootstrap/css/bootstrap.min.css")); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset("assets/plugins/font-awesome/css/all.css")); ?>">
        <!-- NotyJS -->
        <link rel="stylesheet" href="<?php echo e(asset("assets/plugins/noty/noty.css")); ?>">
        <!-- Loading icon -->
        <link rel="stylesheet" href="<?php echo e(asset("assets/css/loading.css")); ?>">
        <!-- Estilos para todas las paginas -->
        <link rel="stylesheet" href="<?php echo e(asset("assets/css/todos.css")); ?>">
        <!--============================= Estilos Plugins =============================-->

        <!--============================= Códigos Plugins =============================-->
        <!-- jQuery 3.4.1 -->
        <script src="<?php echo e(asset("assets/plugins/jquery/jquery.min.js")); ?>"></script>
        <!-- Popper 1.14.7 -->
        <script src="<?php echo e(asset("assets/plugins/popper/popper.min.js")); ?>"></script>
        <!-- Bootstrap 4.3.1 -->
        <script src="<?php echo e(asset("assets/plugins/bootstrap/js/bootstrap.min.js")); ?>"></script>
        <!-- Bootstrap 4.3.1 -->
        <script src="<?php echo e(asset("assets/plugins/noty/noty.js")); ?>"></script>
        <!-- Códigos para codificar los datos en base 64 -->
        <script src="<?php echo e(asset("assets/js/base64.js")); ?>"></script>
        <!-- Códigos para todas las paginas -->
        <script src="<?php echo e(asset("assets/js/todos.js")); ?>"></script>
        <!--============================= Códigos Plugins =============================-->


        
        <!--============================= Plugins incrustados =============================-->
        <?php echo $__env->yieldContent('plugins'); ?>
        <!--============================= Plugins incrustados =============================-->

        <!--============================= Estilos incrustados =============================-->
        <?php echo $__env->yieldContent('estilos'); ?>
        <!--============================= Estilos incrustados =============================-->

    </head>
    <body>

        <div id="cover-spin">
            <div class="loader4"></div>
        </div>

        <div class="container contenido">
            <div style="position:fixed; left:-10px; display:block; z-index:99999;" onclick="irAprincipal()">
                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="" data-original-title="Volver a Principal"><i class="fas fa-home fa-lg"></i> <span style="font-size: 10px; vertical-align: middle;">SINPROC</span> </button>
            </div>
            <?php echo $__env->yieldContent('regresar'); ?>
            <?php echo $__env->make('plantilla.encabezado', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--============================= Contenido incrustados =============================-->
            <?php echo $__env->yieldContent('contenido'); ?>
            <div id="espacioModal"></div>
            <br><br>
            <!--============================= Contenido incrustados =============================-->
        </div>
        <script type="text/javascript">
            var csrf = "<?php echo e(csrf_token()); ?>";
        </script>
        <?php if(session("success")): ?>
            <script type="text/javascript">
                llamadoNoty("<center><p><i class='fas fa-check-circle fa-3x'></i></p></center><?php echo e(session("success")); ?>",'success','topRight',true,3000);
            </script>
        <?php endif; ?>
        <?php if(session("danger")): ?>
            <script type="text/javascript">
                llamadoNoty("<center><p><i class='fas fa-check-circle fa-3x'></i></p></center><h5><strong>Error! </strong></h5><?php echo e(session("danger")); ?>",'error','topRight',true,3000);
            </script>
        <?php endif; ?>
        <!--============================= Códigos incrustados =============================-->
        <?php echo $__env->yieldContent('codigos'); ?>
        <!--============================= Códigos incrustados =============================-->

    </body>
</html>
<?php /**PATH C:\laragon\www\mp\resources\views/plantilla/base.blade.php ENDPATH**/ ?>