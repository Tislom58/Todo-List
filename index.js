function updateTask(element, div, id) {
    // Replace task description with user input

    // Store last due date
    let parentDiv = div.parentNode.parentNode;
    let dueEl = parentDiv.querySelector("div[id='duedate']");
    let dueDate = dueEl.innerText;

    // Clear due date
    dueEl.innerHTML = "";

    dueEl.innerText = "Due: ";

    // Change date
    const inputDate = document.createElement("input");
    inputDate.type = "date";
    inputDate.value = dueDate;

    // Register changes
    let newDate;
    inputDate.addEventListener('change', function(event) {
        newDate = this.value;
        dateInput.setAttribute('value', newDate);
    });

    dueEl.appendChild(inputDate);

    // Get last description
    const descriptionEl = document.querySelector("div[id='" + id + "'] p");
    const description = descriptionEl.innerText;

    // Clear the element
    element.innerHTML = "";

    // Create form
    const formElement = document.createElement("form");
    formElement.action = "index.php";
    formElement.method = "POST";
    formElement.id = "edittask";

    // Text field
    const textInput = document.createElement("input");
    textInput.type = "text";
    textInput.name = "desc";
    textInput.value = description;

    formElement.appendChild(textInput);

    // Parse task_id to server
    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "id";
    idInput.value = id;

    formElement.appendChild(idInput);

    // Parse dueDate to server
    const dateInput = document.createElement("input");
    dateInput.type = "hidden";
    dateInput.name = "duedate";
    dateInput.value = dueDate;

    formElement.appendChild(dateInput);

    // Parse action to execute
    const actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = "update";

    formElement.appendChild(actionInput);

    // Save button
    const buttonInput = document.createElement("input");
    buttonInput.className = "button";
    buttonInput.type = "submit";
    buttonInput.name = "task_edit";
    buttonInput.value = "Save";

    formElement.appendChild(buttonInput);

    div.appendChild(formElement);

}

function updateTag(element, div, id) {
    // Replace tag description with user input

    // Get last description
    const descriptionEl = document.querySelector("div[id='" + id + "'] h4");
    const description = descriptionEl.innerText;

    // Clear the element
    element.innerHTML = "";

    // Create form
    const formElement = document.createElement("form");
    formElement.action = "tagspage.php";
    formElement.method = "POST";
    formElement.id = "edittag";

    // Text field
    const textInput = document.createElement("input");
    textInput.type = "text";
    textInput.name = "desc";
    textInput.value = description;

    formElement.appendChild(textInput);

    // Parsing tag_id to server
    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "id";
    idInput.value = id;

    formElement.appendChild(idInput);

    // Parsing action to execute
    const actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = "updatetag";

    formElement.appendChild(actionInput);

    // Save button
    const buttonInput = document.createElement("input");
    buttonInput.className = "button";
    buttonInput.type = "submit";
    buttonInput.name = "tag_edit";
    buttonInput.value = "Save";

    formElement.appendChild(buttonInput);

    div.appendChild(formElement);
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
