import { Vista } from './vista.js';

export class Victoria extends Vista {
  constructor(controlador, base) {
    super(controlador, base);
    this.controlador = controlador; // Almacenar el controlador como propiedad de la clase
    this.crearInterfaz2();
  }

  crearInterfaz2(puntuacion) {
    const divPuntuacion = document.createElement('div');
    divPuntuacion.className = 'elemento-con-animacion';
    divPuntuacion.style.backgroundColor = '#b8ffd3';

    // Crear el párrafo con el mensaje de puntuación
    const pMensaje = document.createElement('p');
    console.log('HAS OBTENIDO ESTO: ' + puntuacion);
    pMensaje.textContent = `¡Has obtenido ${puntuacion} puntos!`;

    // Crear el campo de entrada tipo texto
    const inputTexto = document.createElement('input');
    inputTexto.type = 'text';
    inputTexto.placeholder = 'Ingresa tu nombre'; // Puedes añadir un placeholder opcional

    // Crear el botón para enviar el formulario
    const btnEnviar = document.createElement('button');
    btnEnviar.textContent = 'Enviar';
    btnEnviar.className = 'btnEnviarFormulario';

    // Agregar evento al botón para enviar el formulario
    btnEnviar.addEventListener('click', () => {
      const nombre = inputTexto.value; // Obtener el valor del campo de entrada
      const puntuacion = this.controlador.obtenerPuntuacion(); // Obtener la puntuación
      // Llamada a la función para validar el formulario
      this.validarFormulario(inputTexto, nombre, puntuacion);
    });

    // Crear el botón para volver al inicio
    const btnVolverInicio = document.createElement('button');
    btnVolverInicio.textContent = 'Volver al inicio';
    btnVolverInicio.className = 'btnSiguienteTiradas';

    // Agregar evento al botón para volver al inicio
    btnVolverInicio.addEventListener('click', () => {
      location.reload();
    });

    divPuntuacion.appendChild(pMensaje);
    divPuntuacion.appendChild(inputTexto); // Agregar el campo de entrada al contenedor
    divPuntuacion.appendChild(btnEnviar); // Agregar el botón de enviar al contenedor
    divPuntuacion.appendChild(btnVolverInicio);
    this.base.appendChild(divPuntuacion);
  }

  enviarFormularioAjax(nombre, puntuacion) {
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('puntuacion', puntuacion);

    return fetch('./js/php/puntuacion.php', {
      method: 'POST', // Cambiar a método POST
      body: formData,
    }).then((response) => response.json());
  }

  aplicarEstilos(elemento, esValido, mensajeError) {
    const errorSpan = elemento.nextElementSibling;

    if (!esValido) {
      elemento.style.transition = 'border-color 0.3s ease, box-shadow 0.3s ease';
      elemento.style.border = '1px solid red';
      elemento.style.boxShadow = '2px 2px 40px rgba(255, 0, 0, 0.7)';

      if (!errorSpan || !errorSpan.classList.contains('error-message')) {
        const nuevoMensajeError = document.createElement('span');
        nuevoMensajeError.textContent = mensajeError;
        nuevoMensajeError.classList.add('error-message');
        elemento.parentNode.insertBefore(
          nuevoMensajeError,
          elemento.nextSibling
        );
      } else {
        errorSpan.textContent = mensajeError;
      }
    } else {
      elemento.style.transition = 'border-color 0.3s ease, box-shadow 0.3s ease';
      elemento.style.border = '1px solid green';
      elemento.style.boxShadow = '2px 2px 40px rgba(0, 255, 0, 0.7)';

      if (errorSpan && errorSpan.classList.contains('error-message')) {
        elemento.parentNode.removeChild(errorSpan);
      }
    }
  }

  mensajeAlerta() {
    const modalContainer = document.createElement('div');
    modalContainer.classList.add('custom-modal');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const message = document.createElement('p');
    message.textContent = '¡Competición creada con éxito!';

    const okButton = document.createElement('button');
    okButton.textContent = 'OK';

    okButton.addEventListener('click', () => {
      location.reload(true);
    });

    modalContent.appendChild(message);
    modalContent.appendChild(okButton);
    modalContainer.appendChild(modalContent);

    document.body.appendChild(modalContainer);
  }

  validarFormulario(inputTexto, nombre, puntuacion) {
    const nombreRegex = /^[A-Za-z0-9]{5,100}$/;
    const nombreValido = nombreRegex.test(nombre);
    this.aplicarEstilos(inputTexto, nombreValido, 'Nombre no válido. Debe contener entre 5 y 25 caracteres. No puede haber ni espacios ni caracteres espaciales.');
    if (nombreValido) {
      // Llamada a la función para enviar datos por AJAX
      this.enviarFormularioAjax(nombre, puntuacion).then(() => {
        // Validación exitosa, recargar la página
        location.reload();
      });
    }
  }
}
