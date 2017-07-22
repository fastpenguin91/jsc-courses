/**
 * Created by johncurry on 7/21/17.
 */
function submit_me(section_id){
    var formStr = "Yup this is where it goes";

        var data = {
            'action': 'my_action', //solve_challenge_ajax_hook
            'whatever': section_id//ajax_object.we_value
        };

        console.log("Before post");
        console.log("user_id is: " + section_id );
        console.log(data);

    jQuery.post(
        ajax_object.ajax_url,
        data,
        //jQuery("#lessonsGoHere").serialize(),
        function(response){
            console.log("yeah this is here.");
            console.log(response);
            jQuery("#section_lessons").html(response);
            alert("ajax_script is the new 'handle'. my_action is the new action. Yes. I work without the serialize thing. Tst I still work..... I'v been submitted WITHOUT THE FUNCTION in the jsc_courses plugin!!");
        }
    );
}