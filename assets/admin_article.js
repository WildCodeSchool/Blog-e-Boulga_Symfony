import './styles/admin_article.scss';

let buttonValidateForm = document.querySelector(".formValidate");
let buttonValidateModal = document.querySelector(".modalMainButton");
let buttonCancelForm = document.querySelector(".formCancel");
let buttonCancelModal= document.querySelector(".modalNoButton");
let modalText = document.querySelector(".pConfirmation");

let form = document.querySelector(".formArticle");

let modal = document.querySelector(".modalMain")

buttonValidateForm.addEventListener("click", () =>{
  modalOpen();
  windowListener();
  modalText.textContent = "Désirez-vous enregistrer votre article?";
})

buttonCancelForm.addEventListener("click", () =>{
  modalOpen();
  windowListener();
  modalText.textContent = "Désirez-vous annuler la création ou modification de votre article?";
  buttonValidateModal.addEventListener("click", (event) => {
    event.preventDefault();
    location.href = "/admin/article/index";
  })
})

buttonCancelModal.addEventListener("click", () =>{
  modalClose();
})

function windowListener() {
  window.addEventListener('click', function (event) {
    if (event.target === modal) {
      modalClose()
    }
  })
}

function modalOpen() {
  modal.classList.add('displayed')
}

function modalClose() {
  modal.classList.remove('displayed');
}
