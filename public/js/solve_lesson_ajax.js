/**
 * Created by johncurry on 6/29/17.
 */
function submit_me(user_id, lesson_id){
    var formStr = "<span class='challengeIsSolved' id='solveChallenge'>Lesson is Comlete!</span>";
    formStr += " <form style='display:inline-block;' id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='lesson_id' value='" + lesson_id + "'>";
    formStr += "<input name='action' type='hidden' value='reset_lesson_ajax_hook' />&nbsp;";
    formStr += "<input id='reset_button' value = 'Reset Lesson?' type='button' onClick='resetLesson(" + user_id + "," + lesson_id + ");' /> </form>";

    jQuery.post(
        solve_lesson_script.ajaxurl,
        jQuery("#theForm").serialize(),
        function(){
            jQuery("#formArea").html(formStr);
        }
    );
}

function resetLesson(user_id, lesson_id){
    var formStr = "<form id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='lesson_id' value='" + lesson_id + "'>";
    formStr += "<input name='action' type='hidden' value='solve_lesson_ajax_hook' />&nbsp;";
    formStr += "<input id='submit_button' value = 'Solve Lesson' type='button' onClick='submit_me(" + user_id + "," + lesson_id + ");' /> </form>";

    jQuery.post(
        solve_lesson_script.ajaxurl,
        jQuery("#theForm").serialize(),
        function(){
            jQuery("#formArea").html(formStr);
        }
    );
}