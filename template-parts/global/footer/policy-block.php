<?php if ($privacy = get_field('privacy', 'option')) { ?>
    <div id="privacy">
        <div class="container">
            <?php echo $privacy; ?>
            <span class="privacy_close"></span>
        </div>
    </div>
<?php } ?>