import './styles/admin_articles.scss';

let crown = document.querySelectorAll('.mainButton')
let articles = document.querySelector('.articles')
let filterButtons = document.querySelector('.filterButtons')
let headerBlock = document.querySelector('header')
let plusDiv = document.querySelector('.plusDiv')
let modalMain = document.querySelector('.modalMain')
let modalMainButton = document.querySelector('.modalMainButton')
let modalNoButton = document.querySelector('.modalNoButton')
let articleTitleP = document.querySelector('.articleTitle')

crown.forEach(function (element) {
    element.addEventListener('click', function () {
        let articleTitle = element.dataset.title;
        let mainArticleId = element.dataset.id;
        let status = element.dataset.status;

        modalOpen()
        windowListener()

        articleTitleP.innerHTML = "'" + articleTitle + "'"

        modalNoButton.addEventListener('click', function () {
            modalClose()
        })

        modalMainButton.href = '/admin/article/main/' + mainArticleId + '/filter/' + status
    })
})

function windowListener() {
    window.addEventListener('click', function (event) {
        if (event.target === modalMain) {
            modalClose()
        }
    })
}
function modalOpen() {
    modalMain.classList.add('displayed')
    articles.classList.add('blurred')
    filterButtons.classList.add('blurred')
    header.classList.add('blurred')
    plusDiv.classList.add('blurred')
}

function modalClose() {
    modalMain.classList.remove('displayed');
    articles.classList.remove('blurred')
    filterButtons.classList.remove('blurred')
    header.classList.remove('blurred')
    plusDiv.classList.remove('blurred')
}
