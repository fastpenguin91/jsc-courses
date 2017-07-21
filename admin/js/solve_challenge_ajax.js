/**
 * Created by johncurry on 7/21/17.
 */
function submit_me(user_id, challenge_id){
    var formStr = "Yup this is where it goes";

        /*"<span class='challengeIsSolved' id='solveChallenge'>Challenge is Solved!</span>";
    formStr += " <form style='display:inline-block;' id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='challenge_id' value='" + challenge_id + "'>";
    formStr += "<input name='action' type='hidden' value='reset_challenge_ajax_hook' />&nbsp;";
    formStr += "<input id='reset_button' value = 'Reset Challenge?' type='button' onClick='resetChallenge(" + user_id + "," + challenge_id + ");' /> </form>";
    */

        var data = {
            'action': 'my_action', //solve_challenge_ajax_hook
            'whatever': ajax_object.we_value
        };

        console.log("Before post");
        console.log(data);

    jQuery.post(
        ajax_object.ajax_url,
        data,
        //jQuery("#lessonsGoHere").serialize(),
        function(response){
            console.log("yeah this is here.");
            console.log(response);
            jQuery("#lessonsGoHere").html(formStr);
            alert("ajax_script is the new 'handle'. my_action is the new action. Yes. I work without the serialize thing. Tst I still work..... I'v been submitted WITHOUT THE FUNCTION in the jsc_courses plugin!!");
        }
    );
}