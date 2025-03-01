// Seleccionar elementos del DOM
const carouselInner = document.querySelector('.carousel-inner');
const carouselItems = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.carousel-control.prev');
const nextButton = document.querySelector('.carousel-control.next');

// Índice de la imagen actual
let currentIndex = 0;

// Función para mover el carrusel
function moveCarousel(direction) {
    const totalItems = carouselItems.length;
    const visibleItems = 5; // Número de imágenes visibles a la vez

    if (direction === 'next') {
        currentIndex = (currentIndex + 1) % (totalItems - visibleItems + 1);
    } else if (direction === 'prev') {
        currentIndex = (currentIndex - 1 + (totalItems - visibleItems + 1)) % (totalItems - visibleItems + 1);
    }

    // Calcular el desplazamiento
    const offset = -currentIndex * (100 / visibleItems);
    carouselInner.style.transform = `translateX(${offset}%)`;
}

// Event listeners para los botones de control
prevButton.addEventListener('click', () => moveCarousel('prev'));
nextButton.addEventListener('click', () => moveCarousel('next'));

// Inicializar el carrusel
moveCarousel('next'); // Muestra las primeras 5 imágenes al cargar la página

// Seleccionar elementos del DOM
const cookieNotice = document.getElementById('cookie-notice');
const acceptCookiesButton = document.getElementById('accept-cookies');

// Ocultar el aviso de cookies al hacer clic en "Aceptar"
acceptCookiesButton.addEventListener('click', () => {
    cookieNotice.style.display = 'none';
    // Aquí podrías guardar una cookie para recordar la aceptación
});