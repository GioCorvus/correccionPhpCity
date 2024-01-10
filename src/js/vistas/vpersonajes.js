import { Vista } from './vista.js'

export class Personajes extends Vista {

  constructor (controlador, base) {
    super(controlador, base)
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
}
