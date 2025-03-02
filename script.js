// ==================================================
// Funcionalidad del Carrusel
// ==================================================

const carouselInner = document.querySelector('.carousel-inner');
const carouselItems = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.carousel-control.prev');
const nextButton = document.querySelector('.carousel-control.next');

let currentIndex = 0;

function moveCarousel(direction) {
    const totalItems = carouselItems.length;
    const visibleItems = 5;

    if (direction === 'next') {
        currentIndex = (currentIndex + 1) % (totalItems - visibleItems + 1);
    } else if (direction === 'prev') {
        currentIndex = (currentIndex - 1 + (totalItems - visibleItems + 1)) % (totalItems - visibleItems + 1);
    }

    const offset = -currentIndex * (100 / visibleItems);
    carouselInner.style.transform = `translateX(${offset}%)`;
}

prevButton.addEventListener('click', () => moveCarousel('prev'));
nextButton.addEventListener('click', () => moveCarousel('next'));

moveCarousel('next');

// ==================================================
// Funcionalidad del Aviso de Cookies
// ==================================================

const cookieNotice = document.getElementById('cookie-notice');
const acceptCookiesButton = document.getElementById('accept-cookies');

if (cookieNotice && acceptCookiesButton) {
    acceptCookiesButton.addEventListener('click', () => {
        cookieNotice.style.display = 'none';
    });
}

// ==================================================
// Funcionalidad de la Ventana Modal para las Flores
// ==================================================

const flores = document.querySelectorAll('.flor-clickeable');
const modal = document.getElementById('modal');
const modalTitulo = document.getElementById('modal-titulo');
const modalImagen = document.getElementById('modal-imagen');
const modalDescripcion = document.getElementById('modal-descripcion');
const modalPrecio = document.getElementById('modal-precio');
const cerrarModal = document.querySelector('.cerrar-modal');

const datosFlores = [
    // Manojos
    { nombre: "Manojo 1", imagen: "manojo1.jpg", descripcion: "Descripción del Manojo 1.", precio: "$20.000" },
    { nombre: "Manojo 2", imagen: "manojo2.jpg", descripcion: "Descripción del Manojo 2.", precio: "$18.000" },
    { nombre: "Manojo 3", imagen: "manojo3.jpg", descripcion: "Descripción del Manojo 3.", precio: "$22.000" },
    { nombre: "Manojo 4", imagen: "manojo4.jpg", descripcion: "Descripción del Manojo 4.", precio: "$19.000" },
    { nombre: "Manojo 5", imagen: "manojo5.jpg", descripcion: "Descripción del Manojo 5.", precio: "$21.000" },
    { nombre: "Manojo 6", imagen: "manojo6.jpg", descripcion: "Descripción del Manojo 6.", precio: "$17.000" },
    { nombre: "Manojo 7", imagen: "manojo7.jpg", descripcion: "Descripción del Manojo 7.", precio: "$23.000" },
    { nombre: "Manojo 8", imagen: "manojo8.jpg", descripcion: "Descripción del Manojo 8.", precio: "$20.000" },
    // Ramos
    { nombre: "Ramo 1", imagen: "ramo1.jpg", descripcion: "Descripción del Ramo 1.", precio: "$25.000" },
    { nombre: "Ramo 2", imagen: "ramo2.jpg", descripcion: "Descripción del Ramo 2.", precio: "$24.000" },
    { nombre: "Ramo 3", imagen: "ramo3.jpg", descripcion: "Descripción del Ramo 3.", precio: "$26.000" },
    { nombre: "Ramo 4", imagen: "ramo4.jpg", descripcion: "Descripción del Ramo 4.", precio: "$22.000" },
    { nombre: "Ramo 5", imagen: "ramo5.jpg", descripcion: "Descripción del Ramo 5.", precio: "$27.000" },
    { nombre: "Ramo 6", imagen: "ramo6.jpg", descripcion: "Descripción del Ramo 6.", precio: "$23.000" },
    { nombre: "Ramo 7", imagen: "ramo7.jpg", descripcion: "Descripción del Ramo 7.", precio: "$28.000" },
    { nombre: "Ramo 8", imagen: "ramo8.jpg", descripcion: "Descripción del Ramo 8.", precio: "$24.000" }
];

if (flores.length > 0 && modal) {
    flores.forEach((flor, index) => {
        flor.addEventListener('click', () => {
            const florData = datosFlores[index];
            modalTitulo.textContent = florData.nombre;
            modalImagen.src = florData.imagen;
            modalDescripcion.textContent = florData.descripcion;
            modalPrecio.textContent = `Precio: ${florData.precio}`;
            modal.style.display = 'flex';
        });
    });

    cerrarModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}