import { Vista } from './vista.js'

export class MenuInicial extends Vista {

  constructor (controlador, base) {
    super(controlador, base)

    // Coger referencias del interfaz
    this.config = this.base.querySelectorAll('button')[0]
    this.iniciarPartida = this.base.querySelectorAll('button')[1]
    this.menuCompeticion = this.base.querySelectorAll('button')[2]
    this.verRanking = this.base.querySelectorAll('button')[3]
    this.verPersonajes = this.base.querySelectorAll('button')[4]

    // Asociar eventos
    this.iniciarPartida.onclick = this.pulsarIniciarPartida.bind(this)
    this.iniciarPartida.onmouseover = (event) => { this.mensajeCursor(event) }
    this.iniciarPartida.onmouseout = () => { this.eliminarMensaje() }
    this.config.onclick = this.pulsarConfig.bind(this)
    this.menuCompeticion.onclick = this.pulsarMenuCompeticion.bind(this)
    this.verRanking.onclick = this.pulsarVerRanking.bind(this)
    this.verPersonajes.onclick = this.pulsarVerPersonajes.bind(this)
  }

  mensajeCursor (event) {
    event.preventDefault()
    this.pDialogo = document.createElement('p')
    this.base.appendChild(this.pDialogo)
    this.pDialogo.textContent = 'Al pulsar este boton, se iniciará la partida'
    this.pDialogo.className = 'mensajeInf'
  }

  eliminarMensaje () {
    if (this.pDialogo) {
      this.base.removeChild(this.pDialogo)
      this.pDialogo = null
    }
  }

  pulsarConfig(){
    this.controlador.verVista(Vista.vconfig)
  }

  pulsarIniciarPartida () {
    this.controlador.verVista(Vista.vruleta)
  }

  pulsarMenuCompeticion () {
    this.controlador.verVista(Vista.vmenucompeticion)
  }

  pulsarVerRanking () {
    this.controlador.verVista(Vista.vmenuranking)
  }

  pulsarVerPersonajes(){
    this.controlador.verVista(Vista.vpersonajes)
  }
}
