function updateTask(element, div) {
    // Edit task with user input

    let parentDiv = div.parentNode;
    let id = element.id;

    // Get current tags
    let tagsDiv = parentDiv.querySelector("div[id='tagsintasks']");
    let tagsText = tagsDiv.innerText;
    const tags = tagsText.split('\n\n');

    tagsDiv.innerHTML = "";

    // Display options
    for (let i=0;i<tags.length;i++) {
        inputTag(tagsDiv, tags[i]);
    }

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

    // Pass task_id to server
    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "id";
    idInput.value = id;

    formElement.appendChild(idInput);

    // Pass dueDate to server
    const dateInput = document.createElement("input");
    dateInput.type = "hidden";
    dateInput.name = "duedate";

    formElement.appendChild(dateInput);

    // Pass action to execute
    const actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = "update";

    formElement.appendChild(actionInput);

    // Pass tags to be added/removed

    // Set initial values to inputs
    let selectElements = tagsDiv.querySelectorAll("select");
    for (let i=0;i<selectElements.length;i++) {
        let tagsInput = document.createElement("input");
        tagsInput.type = "hidden";
        tagsInput.name = "tags[]";
        tagsInput.setAttribute("value", selectElements[i].options[selectElements[i].selectedIndex].value);
        selectElements[i].addEventListener("change", () =>
        {
            tagsInput.setAttribute("value", selectElements[i].options[selectElements[i].selectedIndex].value);
        });
        formElement.appendChild(tagsInput);
    }

    // Set values to added inputs as well (allows to add more tags than initially)
    tagsDiv.addEventListener("change", () => {
        let selectElements = tagsDiv.querySelectorAll("select");
        for (let i=0;i<selectElements.length;i++) {
            let tagsInput = document.createElement("input");
            tagsInput.type = "hidden";
            tagsInput.name = "tags[]";
            tagsInput.setAttribute("value", selectElements[i].options[selectElements[i].selectedIndex].value);
            selectElements[i].addEventListener("change", () =>
            {
                tagsInput.setAttribute("value", selectElements[i].options[selectElements[i].selectedIndex].value);
            });
            formElement.appendChild(tagsInput);
        }
    });

    // Plus button
    const plusButton = document.createElement("button");
    plusButton.innerText = "+";
    plusButton.className = "button";
    plusButton.addEventListener("click", () => {
        inputTag(tagsDiv);
    });

    tagsDiv.parentNode.appendChild(plusButton);

    // Save button
    const buttonInput = document.createElement("input");
    buttonInput.className = "button";
    buttonInput.type = "submit";
    buttonInput.name = "task_edit";
    buttonInput.value = "Save";

    formElement.appendChild(buttonInput);

    // Close form
    div.appendChild(formElement);

    // Store last due date
    let dueDiv = parentDiv.querySelector("div[id='duedate']");
    let dueDate = dueDiv.innerText;
    dueDate = dueDate.replace("Due: ", "");

    // Clear due date
    dueDiv.innerHTML = "";

    dueDiv.innerText = "Due: ";

    // Change date
    const inputDate = document.createElement("input");
    inputDate.type = "date";
    inputDate.setAttribute('value', dueDate);
    dateInput.setAttribute('value', dueDate);

    // Register changes
    let newDate;
    inputDate.addEventListener('change', function() {
        newDate = this.value;
        console.log(newDate);
        dateInput.setAttribute('value', newDate);
    });

    dueDiv.appendChild(inputDate);
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

    // Close form
    div.appendChild(formElement);
}

function inputTag(parentDiv=document.getElementById("tagselect"), defaultOption="None") {
    let element = document.getElementById("tags");
    let div = parentDiv;

    // Create the <select> element
    const selectElement = document.createElement("select");
    selectElement.name = "tags[]";

    // Add options to the <select> element
    for (let i = 0; i < element.length; i++) {
        const option = document.createElement("option");
        option.text = element.options[i].value;
        if (defaultOption === option.text) {
            option.selected = true;
        }
        selectElement.appendChild(option);

    // Append the <select> element to the div
    div.appendChild(selectElement);
    }
}
