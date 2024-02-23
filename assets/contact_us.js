import './styles/contact_us.scss';

let btn_submit = document.querySelector("#btn_submit")
let inputs = document.querySelectorAll(".input_form")
let label_mod = document.querySelector(".labelMod")
let contact_form = document.querySelector(".contactUsForm")
let check_form = []

btn_submit.addEventListener("click", (event) => {
    /**
     * On vide le tableau check_form à chaque fois que l'on clique sur le bouton
     */
    check_form = []

    /**
     * Vérification des inputs du formulaire
     */
    inputs.forEach(element => {

        let elementID = element.id
        let valueInput = element.value.trim()
        let errorMessage = ''

        switch (element.type) {
            case "text":
                if (elementID === "contact_form_firstName" || elementID === "contact_form_lastName") {
                    if (valueInput === "") {
                        errorMessage = "Ce champ est obligatoire"
                        error_input(element, errorMessage);
                    } else {
                        validate_input(element);
                    }

                    if (elementID === "firstName" && valueInput.length < 2) {
                        errorMessage = "Au moins 2 caractères requis"
                        error_input(element, errorMessage);
                    }

                    if (elementID === "lastName" && valueInput.length < 2) {
                        errorMessage = "Au moins 2 caractères requis"
                        error_input(element, errorMessage);
                    }
                }
                break;
            case "textarea":
                if (valueInput === "") {
                    element.style.border = "2px solid #Ec1d1d";
                    check_form.push("empty");

                    errorMessage = "Ce champ est obligatoire"
                    error_input(element, errorMessage);
                } else if (valueInput.length < 10) {
                    errorMessage = "Au moins 10 caractères requis"
                    error_input(element, errorMessage);
                } else {
                    validate_input(element);
                }
                break;
            case "email":
                let check_mail = isMail(valueInput);
                if (valueInput === "" || check_mail == null) {
                    errorMessage = "Veuillez entrer une adresse mail valide"
                    error_input(element, errorMessage);
                } else {
                    validate_input(element);
                }
                break;
            case "checkbox":
                if (element.checked === false) {
                    label_mod.style.color = "#Ec1d1d";
                    check_form.push("unchecked");
                } else if (element.checked === true) {
                    label_mod.style.color = "var(--our-black)";
                }
                break;
            default:
                break;
        }
    })

    if (check_form.length > 0) {
        event.preventDefault();
    }

})

function isMail(email) {
    let mailRegex = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/;
    let regex = new RegExp(mailRegex);
    return email.match(regex);
}

function error_input(element, errorMessage = "") {
    shakeAnimation(element)

    element.style.borderBottom = "2px solid #Ec1d1d"
    check_form.push("empty")
    let small = document.createElement("small")
    small.innerText = errorMessage
    small.classList.add("small")
    let errorsDiv = element.nextElementSibling;

    if (errorsDiv && errorsDiv.classList.contains('errors-w')) {
        let existingSmall = errorsDiv.querySelector('small');
        if (existingSmall) {
            existingSmall.remove();
        }
        errorsDiv.appendChild(small);
    }
}

function validate_input(element) {
    if (element.type === "textarea") {
        element.style.border = "1px solid black";
    } else {
        element.style.borderBottom = "1px solid black"
    }
    let errorsDiv = element.nextElementSibling;
    if (errorsDiv && errorsDiv.classList.contains('errors-w')) {
        let existingSmall = errorsDiv.querySelector('small');
        if (existingSmall) {
            existingSmall.remove();
        }
    }
}

function shakeAnimation(element) {
    element.style.animation = "shake 0.82s cubic-bezier(.36,.07,.19,.97) both"

    element.addEventListener('animationend', () => {
        element.style.animation = '';
    });
}