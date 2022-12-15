<div class="post_meta_extra areas">
    <h3><i>Select the states you want to show:</i></h3>
    <?php  foreach ($states as $term){ ?>
        <span class="state-field-container"><input name="area_selected[]"
                     type="checkbox"
                     class="area-selection"
                     <?php echo $term->selected ? 'checked' : ''  ?>
                     for="<?php echo 'area-' . $term->term_id ?>"
                     value="<?php echo $term->term_id ?>">
            <label for="<?php echo 'area-' . $term->term_id ?>"><?php echo $term->name ?></label>
        </span>
    <?php } ?>
</div>
<div class="post_meta_extra selected_areas_section">
    <h3><i>Select location:</i></h3>
    <div class="selected_areas_section_wrapper">
        <?php foreach ($states as $state){ ?>
        <?php if ($state->selected){ ?>
            <div class="area">
                <p><strong><?php echo $state->name ?></strong></p>
                <div class="locations">
                    <p><input type="checkbox" value="<?php echo $state->term_id ?>" class="all-location-state" id="<?php echo 'all-location-' . $state->term_id ?>"> <label for="<?php echo 'all-location-' . $term->term_id ?>">Check All</label></p>
                    <?php
                        $subcategory_name = 'different';
                    foreach ($state->cities as $city){
                        if($city->name != $subcategory_name && count($city->locations) > 0){
                            $subcategory_name = $city->name;
                            echo "<p><strong>". $subcategory_name ."</strong></p>";
                        }
                        foreach ($city->locations as $location){
                        ?>
                            <p><input name="area_location_selected[]"
                                     type="checkbox"
                                     class="city-selection <?php echo 'state-group-' . $state->term_id ?>"
                     <?php echo $location->selected ? 'checked' : ''  ?>
                     id="<?php echo 'location-' . $location->ID ?>"
                                     value="<?php echo $location->ID ?>">
                                <label for="<?php echo 'location-' . $location->ID ?>"><?php echo $location->post_title ?></label>
                            </p>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </span>
        <?php } ?>
        <?php } ?>
    </div>
    <?php /*foreach ($terms as $term){ */?><!--
        <span><input type="checkbox" for="<?php /*echo 'area-' . $term->term_id */?>"> <label for="<?php /*echo 'area-' . $term->term_id */?>"><?php /*echo $term->name */?></label></span>
    --><?php /*} */?>
</div>
<style>
    .selected_areas_section_wrapper .area{
        width: 250px;
        display: inline-block;
    }

    .selected_areas_section_wrapper .area .locations{
        height: 400px;
        overflow-y: scroll;
    }


    .state-field-container{
        margin-right: 20px;
    }
</style>