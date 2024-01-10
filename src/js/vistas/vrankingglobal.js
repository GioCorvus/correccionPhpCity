import { Vista } from './vista.js'

/**
 * Clase RankingGlobal que extiende de Vista para mostrar el ranking global del juego.
 * @extends Vista
 */
export class RankingGlobal extends Vista {

  /**
   * Constructor de la clase RankingGlobal.
   * @param {Controlador} controlador - Instancia del controlador del juego.
   * @param {HTMLElement} base - Elemento HTML base para la interfaz del ranking global.
   */
  constructor (controlador, base) {
    super(controlador, base)

    // Obtener el botón "Volver al Juego" del DOM y asignar evento de clic
    this.volverAlJuego = this.base.querySelectorAll('button')[0]
    this.volverAlJuego.onclick = this.pulsarvolverAlJuego.bind(this)
  }

  /**
   * Método para mostrar el ranking global en la interfaz.
   * @param {object[]} data - Datos de los jugadores para mostrar en el ranking.
   */
  mostrarRankingGlobal(data) {
    const rankingTable = document.getElementById('rankingTable');
    const tbody = rankingTable.querySelector('tbody');
    tbody.innerHTML = ''; 

    // Iterar sobre los datos de los jugadores y crear filas en la tabla
    data.forEach(jugador => {
      const row = document.createElement('tr');
      const nombreCell = document.createElement('td');
      const puntuacionCell = document.createElement('td');
      const fechaCell = document.createElement('td');

      nombreCell.textContent = jugador.nombre;
      puntuacionCell.textContent = jugador.puntuacion;
      fechaCell.textContent = jugador.fecha_hora;

      row.appendChild(nombreCell);
      row.appendChild(puntuacionCell);
      row.appendChild(fechaCell);

      tbody.appendChild(row);
    });
  }

  /**
   * Método para manejar el evento de clic en el botón "Volver al Juego".
   */
  pulsarvolverAlJuego () {
    this.controlador.verVista(Vista.vmenuinicial)
  }
}
