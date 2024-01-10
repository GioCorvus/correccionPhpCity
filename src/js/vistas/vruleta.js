import { Vista } from './vista.js'
import { GeneradorNumeros } from '../clases/generadornumeros.js'

/**
 * Clase Ruleta que extiende de Vista para gestionar la ruleta del juego.
 * @extends Vista
 */
export class Ruleta extends Vista {

  /**
   * Constructor de la clase Ruleta.
   * @param {Controlador} controlador - Instancia del controlador del juego.
   * @param {HTMLElement} base - Elemento HTML base para la interfaz de la ruleta.
   */
  constructor (controlador, base) {
    super(controlador, base)
    
    this.divMenuCompeticion = document.getElementById('divMenuCompeticion')
    this.divMenuCompeticion.setAttribute('tabindex', '0')
    this.divMenuCompeticion.focus()
    this.generadorNumeros = new GeneradorNumeros()

    this.divMenuCompeticion.addEventListener('keydown', this.girarRuleta.bind(this))
    this.crearBoton()
  }

  /**
   * Número de preguntas mostradas para controlar el límite.
   * @type {number}
   */
  preguntasMostradas = 0 //Para controlar el numero de pregunta que sale
  /**
   * Array para controlar que los ámbitos no se repiten.
   * @type {number[]}
   */
  ambitosSeleccionados = [] //Para controlar que los ambitos no salen repetidos

  /**
   * Método para crear dinámicamente el botón de la ruleta y añadirlo al DOM.
   */
  crearBoton() {
    // Se crea el botón dinámicamente y se agrega al DOM
    this.button = document.createElement('button')
    this.base.appendChild(this.button);
    this.button.textContent = 'GIRA LA RULETA'
    this.button.className = 'volverAlJuego'
  
    // Agregar evento de clic al botón
    this.button.addEventListener('click', () => {
      console.log('LO DESABILITO')
      // Deshabilitar el botón para evitar múltiples clics
      this.button.disabled = true;
      // Seleccionar la imagen de la ruleta y el sonido
      let sonidoRuleta = document.getElementById('audioRuleta')
      let ruletaImg = document.getElementById('ruleta')
  
      // Definir la duración total de la animación en milisegundos (8 segundos = 8000 milisegundos)
      const duracionTotal = 1000
      const velocidadInicial = 15 // Velocidad inicial en grados por intervalo
      const aceleracion = 5 // Aceleración para simular el efecto de arranque lento
  
      let tiempoTranscurrido = 0
      let rotacion = 0
      let velocidad = velocidadInicial
  
      let interval = setInterval(() => {
        ruletaImg.style.transform = `rotate(${rotacion}deg)`
  
        // Reproducir el sonido solo cuando está girando
        if (velocidad > 0) {
          sonidoRuleta.currentTime = 0
          sonidoRuleta.play()
        }
  
        if (tiempoTranscurrido < duracionTotal) {
          rotacion += velocidad
          tiempoTranscurrido += 50 // Incrementar el tiempo transcurrido por el intervalo
          // Reducir la velocidad con la aceleración y un factor de desaceleración gradual
          velocidad -= aceleracion * (1 - tiempoTranscurrido / duracionTotal)
        } else {
          // Detener la animación cuando se alcanza la duración total
          clearInterval(interval)
  
          // Realizar fade-out del sonido al finalizar la animación
          let fadeInterval = setInterval(() => {
            if (sonidoRuleta.volume > 0.05) {
              sonidoRuleta.volume -= 0.05
            } else {
              clearInterval(fadeInterval)
              sonidoRuleta.pause()
              sonidoRuleta.currentTime = 0
              sonidoRuleta.volume = 1
            }
          }, 100)
  
          this.girarRuleta()
          this.cambiarVista(this.ambitosSeleccionados[this.ambitosSeleccionados.length - 1])
        }
      }, 50)
    });
  }
  
  habilitarBoton() {
    this.button.disabled = false;
  }
  getPreguntasMostradas() {
    return this.preguntasMostradas;
}
  girarRuleta() {
    
    if (this.preguntasMostradas < 5) { // Cambiamos la condición para mostrar 5 preguntas en total
      // Lógica para obtener preguntas de cada ámbito
      let idAmbitoAleatorio;
      do {
        idAmbitoAleatorio = Math.floor(Math.random() * 5) + 1;
      } while (this.ambitosSeleccionados.includes(idAmbitoAleatorio));
  
      this.ambitosSeleccionados.push(idAmbitoAleatorio);
      this.preguntasMostradas++;
  
      fetch('./js/php/preguntas.php?id_ambito=' + idAmbitoAleatorio, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('ERROR EN LA CONEXION.');
        }
        return response.json();
      })
      .then(preguntas => {
        // Mostrar la pregunta obtenida
        this.mostrarPreguntas(idAmbitoAleatorio, preguntas);
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  }
  
  /**
   * Método para mostrar preguntas según el ámbito aleatorio.
   * @param {number} idAmbitoAleatorio - ID del ámbito seleccionado.
   * @param {object[]} preguntas - Array de preguntas asociadas al ámbito.
   */

  mostrarPreguntas(idAmbitoAleatorio, preguntas) {
    this.controlador.mostrarPreguntas(idAmbitoAleatorio, preguntas)
  }

  /**
   * Método para cambiar la vista del juego según el ámbito aleatorio.
   * @param {number} idAmbitoAleatorio - ID del ámbito seleccionado.
   */
  cambiarVista (idAmbitoAleatorio) {
        switch (idAmbitoAleatorio) {
          case 1:
            //this.controlador.verVista(Vista.vPartDemo)
            this.controlador.verVista(Vista.vpartdemo)
            this.habilitarBoton();
            break
          case 2:
            this.controlador.verVista(Vista.vjustsocial)
            this.habilitarBoton();
            break
          case 3:
            this.controlador.verVista(Vista.vdeshumano)
            this.habilitarBoton();
            break
          case 4:
            this.controlador.verVista(Vista.vinterculturalidad)
            this.habilitarBoton();
            break
          case 5:
            this.controlador.verVista(Vista.vequidadgenero)
            this.habilitarBoton();
            break
          default:
            console.log('Número no válido')
        }
      } 
    }