import { Vista } from './vista.js';

export class Configuracion extends Vista {
  constructor(controlador, base) {
    super(controlador, base);
    this.volverMenu = this.base.querySelectorAll('button')[1]

    this.volverMenu.onclick = this.pulsarVolverMenu.bind(this)

    // Obtén referencia al botón y al control de volumen del HTML
    const stopAudioBtnElement = this.base.querySelector('#stopAudioBtn');
    // Agrega eventos a los elementos correspondientes
    stopAudioBtnElement.addEventListener('click', () => {
      this.toggleAudio();
      this.updateAudioIcon(); 
    });
  }

  toggleAudio() {
    const audioElement = document.getElementById('audioElementId');
    if (audioElement.paused) {
      audioElement.play();
    } else {
      audioElement.pause();
    }
  }

  updateAudioIcon() {
    const audioElement = document.getElementById('audioElementId');
    const audioIcon = document.getElementById('audioIcon');

    if (audioElement.paused) {
      audioIcon.src = 'img/off.png';
    } else {
      audioIcon.src = 'img/on.png';
    }
  }
  changeVolume(vol) {
    this.controlador.changeVolume(vol);
  }

  pulsarVolverMenu () {
    this.controlador.verVista(Vista.vmenuinicial)
  }
}