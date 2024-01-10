/**
 * Clase que representa un validador de formularios.
 * @class
 */
class FormularioValidator {
    /**
     * Constructor de la clase FormularioValidator.
     * Inicializa los campos del formulario que serán validados.
     * @constructor
     */
    constructor() {
        /**
         * Lista de campos a validar en el formulario.
         * @type {string[]}
         */
        this.campos = [
            'texto_pregunta',
            'ambito',
            'texto_respuesta_correcta',
            'texto_respuesta_incorrecta1',
            'texto_respuesta_incorrecta2'
        ];

        console.log("cargado con extio")
    }

    /**
     * Método para validar todo el formulario.
     * @returns {boolean} - Devuelve true si el formulario es válido, false si no lo es.
     */
    validarFormulario() {
        // reseteo de estilos y errores antes de la validación
        this.resetearEstilosYErrores();

        // variable que indica si el formulario es válido
        let formularioValido = true;

        // validación de cada campo
        for (let campo of this.campos) {
            const inputElement = document.getElementById(campo);
            const valor = inputElement.value.trim();

            // campo vacío
            if (this.campoVacio(valor)) {
                this.mostrarError(inputElement, 'Campo no puede estar vacío');
                formularioValido = false;
            }
            // longitud máxima
            else if (this.excedeLongitud(valor)) {
                this.mostrarError(inputElement, 'Campo no puede tener más de 100 caracteres');
                formularioValido = false;
            }
            // caracteres especiales
            else if (this.contieneCaracteresEspeciales(valor)) {
                this.mostrarError(inputElement, 'Campo no puede contener caracteres especiales');
                formularioValido = false;
            }
            // si es válido, se oculta el mensaje de error
            else {
                this.ocultarError(inputElement);
            }
        }

        // devuelvo el resultado de la validación del formulario
        return formularioValido;
    }

    /**
     * Método que verifica si un campo está vacío.
     * @param {string} valor - Valor del campo a validar.
     * @returns {boolean} - Devuelve true si el campo está vacío, false si no lo está.
     */
    campoVacio(valor) {
        return valor === '';
    }

    /**
     * Método que verifica si un campo excede la longitud máxima permitida.
     * @param {string} valor - Valor del campo a validar.
     * @returns {boolean} - Devuelve true si el campo excede la longitud máxima, false si no la excede.
     */
    excedeLongitud(valor) {
        return valor.length > 100;
    }

    /**
     * Método que verifica si un campo contiene caracteres especiales con un REGEX.
     * @param {string} valor - Valor del campo a validar.
     * @returns {boolean} - Devuelve true si el campo contiene caracteres especiales, false si no los contiene.
     */
    contieneCaracteresEspeciales(valor) {
        return /[!@#$%^&*(),.":{}|<>]/.test(valor);
    }

    /**
     * Método para mostrar un mensaje de error asociado a un campo.
     * @param {HTMLElement} elemento - Elemento HTML del campo.
     * @param {string} mensaje - Mensaje de error a mostrar.
     */
    mostrarError(elemento, mensaje) {
        const errorMensajeId = elemento.id + '-error-mensaje';
        let errorMensajeElement = document.getElementById(errorMensajeId);

        // si no existe el elemento de mensaje de error, se crea
        if (!errorMensajeElement) {
            errorMensajeElement = document.createElement('div');
            errorMensajeElement.id = errorMensajeId;
            errorMensajeElement.className = 'error-mensaje';
            errorMensajeElement.innerHTML = mensaje;

            // se inserta el mensaje de error después del campo de entrada
            elemento.parentNode.insertBefore(errorMensajeElement, elemento.nextSibling);

            // aplico estilos al texto y al input
            elemento.style.boxShadow = '0 0 5px red';
        }
    }

    /**
     * Método para ocultar el mensaje de error asociado a un campo.
     * @param {HTMLElement} elemento - Elemento HTML del campo.
     */
    ocultarError(elemento) {
        const errorMensajeId = elemento.id + '-error-mensaje';
        const errorMensajeElement = document.getElementById(errorMensajeId);

        // si existe el elemento de mensaje de error, se elimina
        if (errorMensajeElement) {
            errorMensajeElement.remove();

            // se restauran los estilos del input
            elemento.style.boxShadow = '';
        }
    }

    /**
     * Método para resetear estilos y errores de todos los campos del formulario.
     */
    resetearEstilosYErrores() {
        for (let campo of this.campos) {
            const inputElement = document.getElementById(campo);
            const errorMensajeId = inputElement.id + '-error-mensaje';
            const errorMensajeElement = document.getElementById(errorMensajeId);

            // restauro estilos del input
            inputElement.style.boxShadow = '';

            // elimino mensaje de error
            if (errorMensajeElement) {
                errorMensajeElement.remove();
            }
        }
    }
}

/**
 * Función externa para validar un formulario enviado.
 * @returns {boolean} - Devuelve true si el formulario es válido, false si no lo es.
 */
function validarFormularioEnviado() {
    const validator = new FormularioValidator();
    return validator.validarFormulario();
}