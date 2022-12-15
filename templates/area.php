<?php get_header();

$state = get_queried_object();
?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1><?php echo $state->name ?></h1>
            </div>
            <div class="col-md-6">
                <?php echo do_shortcode('[mlp_map ""]') ?>
            </div>
        </div>
    </div>

<?php
get_footer();
