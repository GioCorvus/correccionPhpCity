import { Vista } from './vista.js'

export class MenuCompeticion extends Vista {

  constructor (controlador, base) {
    super(controlador, base)

    this.crearCompeticion = this.base.querySelectorAll('button')[0]
    this.unirCompeticion = this.base.querySelectorAll('button')[1]

    this.crearCompeticion.onclick = this.pulsarCrearCompeticion.bind(this)
    this.unirCompeticion.onclick = this.pulsarUnirCompeticion.bind(this)

    this.crearInterfaz()
  }

  crearInterfaz () {

    this.btnVolverJuego = document.createElement('button')
    this.base.appendChild(this.btnVolverJuego)
    this.btnVolverJuego.textContent = 'VOLVER AL MENÚ'
    this.btnVolverJuego.className = 'volverAlJuego'

    // Asociar evento al botón para volver al menú principal (vMenuInicial)
    this.btnVolverJuego.onclick = () => {
      this.controlador.verVista(Vista.vmenuinicial)
    }
  }

  pulsarCrearCompeticion () {
    this.controlador.verVista(Vista.vcrearcompeticion)
  }

  pulsarUnirCompeticion () {
    this.mensajeAlerta()
  }

  mensajeAlerta() {
    const modalContainer = document.createElement('div');
    modalContainer.classList.add('custom-modal');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const message = document.createElement('p');
    message.textContent = 'Esta opción está en desarrollo';

    const okButton = document.createElement('button');
    okButton.textContent = 'OK';

    okButton.addEventListener('click', () => {
      // Close the modal
      modalContainer.remove();

      // Proceed to the desired view
      this.controlador.verVista(Vista.vmenuinicial);
    });

    modalContent.appendChild(message);
    modalContent.appendChild(okButton);
    modalContainer.appendChild(modalContent);

    document.body.appendChild(modalContainer);
  }

}
