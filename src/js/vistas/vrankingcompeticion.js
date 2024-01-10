import { Vista } from './vista.js'

export class RankingCompeticion extends Vista {

  constructor (controlador, base) {
    super(controlador, base)

    this.btnVerRankings = this.base.querySelectorAll('button')[1]

    this.btnVerRankings.onclick = this.pulsarbtnVerRankings.bind(this)
  }

  pulsarbtnVerRankings () {
    this.controlador.verVista(Vista.vmenuinicial)
  }
}
