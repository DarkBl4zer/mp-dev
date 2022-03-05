<?php $__env->startSection('contenido'); ?>
<?php
    $htmlRoles = '<option value="0"></option>';
    foreach ($roles as $item) {
        $htmlRoles .= '<option value="' . $item->valor . '">' . $item->nombre . '</option>';
    }
?>
<br><br>
<form action="<?php echo e(route('logear')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <label class="minilabel" for="RolUsuario">Rol de usuario</label>
    <select class="form-control" id="RolUsuario" name="RolUsuario">
        <?php
            echo $htmlRoles;
        ?>
    </select>
    <br><br>
    <button type="submit" class="btn btn-success">Logear</button>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("plantilla.base", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mp\resources\views/login.blade.php ENDPATH**/ ?>