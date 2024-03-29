// Sélectionner la lightbox et le bouton de fermeture
let lightboxModal = document.querySelector('.lightbox');
let btnCloseLightbox = document.querySelector('.lightbox-close');
const lightbox = document.querySelector('.lightbox');
let listOfInfo = [];

// Fonction pour ouvrir la lightbox

document.querySelectorAll('.icon-fullscreen').forEach((icon) => {
    icon.addEventListener('click', function(e) {
        let modal = document.querySelector('.lightbox');
        let selectedImage = e.target.closest('.galerie-img').querySelector('#img-fullscreen');
        let modalImage = modal.querySelector('.lightbox-container img');

        modalImage.src = selectedImage.src;
        modalImage.alt = selectedImage.alt;
        modal.style.display = 'block';
        modal.classList.add('active');    
    })
})

document.querySelectorAll('.galerie-img-info').forEach((galerieImg) => {
        //récupérer les infos de la photo
        const title = galerieImg.querySelector('.galerie-title').textContent;
        const categorie = galerieImg.querySelector('.galerie-cat').textContent;
        const annee = galerieImg.getAttribute('data-date');

        listOfInfo.push(
            {
                title: title,
                categorie: categorie,
                annee: annee
            }
        );
})


// Fonction pour fermer la lightbox

function closeLightbox() {
    lightboxModal.style.display = 'none';
}
btnCloseLightbox.addEventListener('click', closeLightbox);


// récupération des informations (titre, catégorie, année) de la photo
  var listOfIconFullScreen = document.querySelectorAll('.icon-fullscreen');

  // Lorsque l'un des boutons est cliqué
  listOfIconFullScreen.forEach(function(button, position) {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      // Enregistrer l'index du bouton cliqué pour la navigation
      const title = listOfInfo[position].title;
      const categorie = listOfInfo[position].categorie;
      const annee = listOfInfo[position].annee;

      lightbox.querySelector('.lightbox-titre').textContent = title;
      lightbox.querySelector('.lightbox-cat').textContent = categorie;
      lightbox.querySelector('.lightbox-annee').textContent = annee;

      lightbox.setAttribute('data-current-index', position);

    });
  });

// navigation des flèches 
lightbox.querySelector('.lightbox-prev').addEventListener('click', function(e) {
    e.stopPropagation(); // Empêche la propagation de l'événement pour éviter la fermeture de la lightbox
    // parseInt permet de recuperer une chaine de caractères en entier 
    var currentIndex = parseInt(lightbox.getAttribute('data-current-index'));
    var previousButton = listOfIconFullScreen[currentIndex - 1];
    if (previousButton) {
      previousButton.click();
      lightbox.setAttribute('data-current-index', currentIndex - 1);
    }
  });

  lightbox.querySelector('.lightbox-next').addEventListener('click', function(e) {
    e.stopPropagation(); // Empêche la propagation de l'événement pour éviter la fermeture de la lightbox

    var currentIndex = parseInt(lightbox.getAttribute('data-current-index'));
    var nextButton = listOfIconFullScreen[currentIndex + 1];
    if (nextButton) {
      nextButton.click();
      lightbox.setAttribute('data-current-index', currentIndex + 1);
    }
  });