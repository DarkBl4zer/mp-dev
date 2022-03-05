<?php $__env->startSection('titulo'); ?>
GESTION MÓDULO MP
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugins'); ?>
<!-- DataTables CSS-->
<link rel="stylesheet" href="<?php echo e(asset("assets/plugins/datatables/datatables.min.css")); ?>">
<!-- Select2 CSS-->
<link rel="stylesheet" href="<?php echo e(asset("assets/plugins/select2/css/select2.min.css")); ?>">
<!-- daterange picker CSS-->
<link rel="stylesheet" href="<?php echo e(asset("assets/plugins/bootstrap-daterangepicker/daterangepicker.css")); ?>">

<!-- DataTables JS-->
<script src="<?php echo e(asset("assets/plugins/datatables/datatables.min.js")); ?>"></script>
<script type="text/javascript">
    var SpanishDT = "/assets/plugins/datatables/Spanish.json";
</script>
<!-- Select2 JS-->
<script src="<?php echo e(asset("assets/plugins/select2/js/select2.full.min.js")); ?>"></script>
<!-- date-range-picker -->
<script src="<?php echo e(asset("assets/plugins/moment/min/moment.min.js")); ?>"></script>
<script src="<?php echo e(asset("assets/plugins/bootstrap-daterangepicker/daterangepicker.js")); ?>"></script>
<script src="<?php echo e(asset("assets/plugins/bootstrap-daterangepicker/Spanish.js")); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('regresar'); ?>
<a href="<?php echo e(route('inicio')); ?>" style="position:fixed; left:-10px; top: 72px; display:block; z-index:99999;">
    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Volver a Principal">
        <i class="fas fa-ellipsis-v"></i> <span style="font-size: 10px; vertical-align: middle;">INTERVENCIÓN</span>
    </button>
</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <strong>GESTION MÓDULO MP</strong>
    </div>
    <div class="card-body">
        <div class="row top10">
            <div class="col-sm-12">
                <table id="tablaDatos" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                </table>
                <div id="noDatos" class="col-md-12 text-center"></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('codigos'); ?>
    <!-- Códigos para Plan de Trabajo -->
    <script src="<?php echo e(asset("assets/js/gestion/index.js")); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("plantilla.base", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mp\resources\views/gestion/index.blade.php ENDPATH**/ ?>