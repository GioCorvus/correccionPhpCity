/**
 * Clase para gestionar la confirmación antes de borrar una pregunta.
 */
class ConfirmacionBorrado {
    /**
     * Constructor de la clase.
     */
    constructor() {
        this.enlazarEventos();
    }

    /**
     * Enlaza los eventos de clic a los botones de borrado.
     */
    enlazarEventos() {
        /**
         * Selecciona todos los enlaces que contienen "borrarPregunta" en el atributo href.
         * @type {NodeListOf<HTMLAnchorElement>}
         */
        const botonesBorrar = document.querySelectorAll('a[href*="borrarPregunta"]');

        botonesBorrar.forEach(boton => {
            boton.addEventListener('click', this.mostrarPopup.bind(this));
        });
    }

    /**
     * Muestra un popup de confirmación y realiza la acción de borrado si es confirmado.
     * @param {Event} event - El evento de clic en el botón de borrado.
     */
    mostrarPopup(event) {
        event.preventDefault();

        /**
         * Muestra un cuadro de diálogo de confirmación al usuario.
         * @type {boolean}
         */
        const confirmacion = confirm('¿Estás seguro de que deseas borrar esta pregunta?');

        if (confirmacion) {
            /**
             * Obtiene la URL del enlace de borrado.
             * @type {string | null}
             */
            const enlaceBorrado = event.currentTarget.getAttribute('href'); //obtengo la url dinamica

            if (enlaceBorrado) {
                // si confirmo y el enlace de borrado es válido, redirige
                window.location.href = enlaceBorrado;
            } else {
                console.error('Error: No se pudo obtener el enlace de borrado.');
            }
        } else {
            console.log('Borrado cancelado por el usuario.');
            // Si cancelo, no hace nada
        }
    }
}

/**
 * Instancia la clase ConfirmacionBorrado cuando se carga el documento y añado mi querido comentario para saber que el script se ha cargado
 */
document.addEventListener('DOMContentLoaded', () => {
    console.log("Me gusta mucho diseño. Y cliente. Quiero decir... Script cargado correctamente, bip bop.")
    new ConfirmacionBorrado();
});