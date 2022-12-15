jQuery(document).ready(function( $ ) {

    $(".all-location-state").on('change', '.locations', function(){
        //$("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        console.log('XX')
    });

    $(".all-location-state").on('change', function(){
        $('.state-group-'+$(this).val()).not(this).prop('checked', this.checked);
    });

    $('.areas .area-selection').on('change', function(){
        var term_id= $(this).val();
        console.log(term_id)
    });
    
});