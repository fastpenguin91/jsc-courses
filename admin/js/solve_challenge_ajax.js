/**
 * Created by johncurry on 7/21/17.
 */
function select_section(section_id){

        var data = {
            'action': 'prepare_section_lessons_html',
            'whatever': section_id//ajax_object.we_value
        };

    jQuery.post(
        ajax_object.ajax_url,
        data,
        //jQuery("#lessonsGoHere").serialize(),
        function(response){
            jQuery("#section_lessons").html(response);
        }
    );
}