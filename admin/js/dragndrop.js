/**
 * Created by johncurry on 7/13/17.
 */

function dragstart_handler(ev){
    console.log(ev.target.id);
    //console.log(ev);
    // Change the source element's background color to signify drag has started
    ev.currentTarget.style.border = "dashed";
    ev.dataTransfer.setData("text", ev.target.id);
    var data = ev.dataTransfer.getData("text");
    console.log("The data is: " + data);
}

function dragover_handler(ev) {
    console.log("dragOver");
    console.log(ev.target.id);
    // Change the target element's border to signify a drag over event
    // has occurred
    ev.currentTarget.style.background = "lightblue";
    ev.currentTarget.style.padding = "10px";
    ev.preventDefault();
}

function dragleave_handler(ev) {
    console.log("dragLeave");
    // Change the source element's border back to white
    ev.currentTarget.style.background = "white";
}

function drop_handler(ev) {
    console.log("target elem...");
    var baseElement = document.getElementById(ev.target.id);
    ev.preventDefault();
    var parentDiv = baseElement.parentNode;
    var data = ev.dataTransfer.getData("text");
    console.log(document.getElementById(data));
    parentDiv.insertBefore(document.getElementById(data), baseElement);
}

console.log("still in JS yo");