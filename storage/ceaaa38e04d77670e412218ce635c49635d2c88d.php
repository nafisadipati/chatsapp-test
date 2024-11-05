<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
    <nav>
        <ul>
            <?php if(Auth::check()): ?>
                <li><?php echo e(Auth::user()->name); ?></li>
                <li><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
            <?php else: ?>
                <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html>
<?php /**PATH /home/skywalkers/Documents/whatsapp-clone/resources/views/layouts/app.blade.php ENDPATH**/ ?>