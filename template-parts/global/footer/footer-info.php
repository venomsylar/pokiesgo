<?php
$footer_info = get_field('footer_info', 'option');
if($footer_info) { ?>
    <div class="footer_info">
        <?php echo venom_get_header_logo(true); ?>
        
        <?php echo $footer_info ?>
        <hr>
    </div>
<?php } ?>