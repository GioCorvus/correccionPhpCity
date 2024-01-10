import { Vista } from './vista.js'

/**
 * Clase MenuRanking que extiende de Vista para gestionar las opciones de ranking en el menú.
 * @extends Vista
 */
export class MenuRanking extends Vista {

  /**
   * Constructor de la clase MenuRanking.
   * @param {Controlador} controlador - Instancia del controlador del juego.
   * @param {HTMLElement} base - Elemento HTML base para la interfaz del menú de ranking.
   */
  constructor (controlador, base) {
    super(controlador, base)

    this.rankingGlobal = this.base.querySelectorAll('button')[0]
    this.rankingCompeticion = this.base.querySelectorAll('button')[1]
    this.testMiguel = this.base.querySelectorAll('button')[2]

    this.rankingGlobal.onclick = this.pulsarRankingGlobal.bind(this)
    this.rankingCompeticion.onclick = this.pulsarRankingCompeticion.bind(this)
    this.testMiguel.onclick = this.pulsarTestMiguel.bind(this)

    this.crearInterfaz()
  }

  /**
   * Método para crear elementos adicionales en la interfaz del menú.
   */
  crearInterfaz () {
    this.btnVerVista1 = document.createElement('button')
    this.base.appendChild(this.btnVerVista1)
    this.btnVerVista1.textContent = 'VOLVER AL MENÚ'
    this.btnVerVista1.className = 'volverAlJuego'
    this.btnVerVista1.onclick = () => {
      this.controlador.verVista(Vista.vmenuinicial)
    }
  }

  /**
   * Método para manejar el evento de clic en el botón "Ranking Global".
   */
  pulsarRankingGlobal () {
    this.controlador.verVista(Vista.vrankingglobal)
  }

  /**
   * Método para manejar el evento de clic en el botón "Ranking Competición".
   */
  pulsarRankingCompeticion() {
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

  /**
   * Método para manejar el evento de clic en el botón "Test Miguel". IGNORAR, para futura implementacion.
   */
  pulsarTestMiguel(){
    this.controlador.verVista(Vista.vformulariofinal)
  }

}
