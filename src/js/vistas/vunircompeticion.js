import { Vista } from './vista.js'

export class UnirCompeticion extends Vista {

  constructor (controlador, base) {
    super(controlador, base)
    this.unirCompeticion = this.base.querySelectorAll('button')[0]
    this.unirCompeticion = this.base.querySelectorAll('button')[1]

    this.unirCompeticion.onclick = this.pulsarunirCompeticion.bind(this)
  }

  pulsarunirCompeticion () {
    this.controlador.verVista(Vista.vmenuinicial)
  }
}
