import './styles/admin_article.scss';

let buttonValidateForm = document.querySelector(".formValidate");
let buttonValidateModal = document.querySelector(".modalMainButton");
let buttonCancelForm = document.querySelector(".formCancel");
let buttonCancelModal= document.querySelector(".modalNoButton");
let modalText = document.querySelector(".pConfirmation");
let upload = document.getElementById('article_imageFile_file');

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

const imageUpload = document.getElementById('article_imageFile_file');
function previewImage(e) {
  console.log(e);
  const input = e.target;
  const image = document.getElementById('preview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      image.src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
imageUpload.addEventListener('change', previewImage);

