function updateTask(element, div, id) {
    element.innerHTML = '<form action=\'index.php\' method=\'POST\' id=\'edittask\'>' +
        '<input type=\'text\' name=\'desc\'>' +
        '<input type=\'hidden\' name=\'id\' value='+ id +'>' +
        '<input type=\'hidden\' name=\'action\' value=\'update\'>' +
        '<input class=\'button\' type=\'submit\' name=\'task_edit\' value=\'Save\'/>' +
        '</form>';

    /*const selectElement = document.createElement("form");
    selectElement.action = "index.php";
    selectElement.method = "POST";
    selectElement.id = "edittask";

    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "id";
    idInput.value = id;

    selectElement.appendChild(idInput);

    const actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = "update";

    selectElement.appendChild(actionInput);

    const buttonInput = document.createElement("input");
    buttonInput.class = "button";
    buttonInput.type = "submit";
    buttonInput.name = "task_edit";
    buttonInput.value = "save";

    selectElement.appendChild(buttonInput);

    div.appendChild(selectElement);*/
}

function updateTag(element, id) {
    element.innerHTML = '<form action=\'index.php\' method=\'POST\' id=\'edittask\'>' +
        '<input type=\'text\' name=\'desc\'>' +
        '<input type=\'hidden\' name=\'id\' value=' + id + '>' +
        '<input type=\'hidden\' name=\'action\' value=\'updatetag\'>' +
        '<input class=\'button\' type=\'submit\' name=\'task_edit\' value=\'Save\'/>' +
        '</form>';
}

function inputTag() {
    let element = document.getElementById("tags");
    let div = document.getElementById("tagselect");

    // Create the <select> element
    const selectElement = document.createElement("select");
    selectElement.name = "tags[]";

    // Add options to the <select> element
    for (let i = 0; i < element.length; i++) {
        const option = document.createElement("option");
        option.text = element.options[i].value;
        selectElement.appendChild(option);

    // Append the <select> element to the div
    div.appendChild(selectElement);
    }
}
