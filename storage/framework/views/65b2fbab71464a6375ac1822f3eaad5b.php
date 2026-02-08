<?php if($paginator->hasPages()): ?>
    <nav>
        <ul class="pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true"><span><?php echo trans('pagination.previous'); ?></span></li>
            <?php else: ?>
                <li><a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"><?php echo trans('pagination.previous'); ?></a></li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li><a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"><?php echo trans('pagination.next'); ?></a></li>
            <?php else: ?>
                <li class="disabled" aria-disabled="true"><span><?php echo trans('pagination.next'); ?></span></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/vendor/laravel/framework/src/Illuminate/Pagination/resources/views/simple-default.blade.php ENDPATH**/ ?>