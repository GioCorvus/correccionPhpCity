import {Modelo} from './modelos/modelo.js'
import {Vista} from './vistas/vista.js'
import {MenuInicial} from './vistas/vmenuinicial.js'
import {Ruleta} from './vistas/vruleta.js' //SERGIO
import {MenuCompeticion} from './vistas/vmenucompeticion.js'
import {CrearCompeticion} from './vistas/vcrearcompeticion.js' //SERGIO
// import {UnirCompeticion} from './vistas/vunircompeticion.js'
import {MenuRanking} from './vistas/vmenuranking.js'  //SERGIO
import {RankingGlobal} from './vistas/vrankingglobal.js' //SERGIO
import {RankingCompeticion} from './vistas/vrankingcompeticion.js'  //SERGIO
import {PartDemo} from './vistas/vpartdemo.js'
import {JustSocial} from './vistas/vjustsocial.js'
import {DesHumano} from './vistas/vdeshumano.js'
import {Interculturalidad} from './vistas/vInterculturalidad.js'
import {EquidadGenero} from './vistas/vequidadgenero.js'
import { Victoria } from './vistas/victoria.js'
import { Configuracion } from './vistas/vconfig.js'
import { Personajes } from './vistas/vpersonajes.js'

/**
 * Clase Controlador para gestionar la lógica y negociaciones del juego.
 */
class Controlador {
  /*
	 * Inicializa los atributos del Controlador.
	 * Coge las referencias del interfaz.
	 */
  vistas = new Map();
  indicePregunta =0;
  respuestaBtn
  preguntasCorrectas = 0

  constructor () {
    this.modelo = new Modelo()
    this.preguntasCorrectas =0;
    this.puntuacion = 0;

    //conseguimos la referencia de la interface
    const divMenuInicial = document.getElementById('divMenuInicial')
    const divRuleta = document.getElementById('divRuleta') //SERGIO
    const divMenuCompeticion = document.getElementById('divMenuCompeticion')
    const divCrearCompeticion = document.getElementById('divCrearCompeticion') //SERGIO
    // const divUnirCompeticion = document.getElementById('divUnirCompeticion')
    const divMenuRanking = document.getElementById('divMenuRanking')  //SERGIO
    const divRankingGlobal = document.getElementById('divRankingGlobal') //SERGIO
    const divRankingCompeticion = document.getElementById('divRankingCompeticion')  //SERGIO
    const divPartDemo = document.getElementById('divPartDemo')
    const divJustSocial = document.getElementById('divJustSocial')
    const divDesHumano = document.getElementById('divDesHumano')
    const divInterculturalidad = document.getElementById('divInterculturalidad')
    const divEquidadGenero = document.getElementById('divEquidadGenero')
    const divVictoria = document.getElementById('divVictoria')
    const divConfig = document.getElementById('divConfig')
    const divPersonajes = document.getElementById('divPersonajes')


    //Creamos las vistas 
    this.vistas.set(Vista.vmenuinicial, new MenuInicial(this, divMenuInicial))
    this.vistas.set(Vista.vruleta, new Ruleta(this, divRuleta)); //SERGIO
    this.vistas.set(Vista.vmenucompeticion, new MenuCompeticion(this, divMenuCompeticion))
    this.vistas.set(Vista.vcrearcompeticion, new CrearCompeticion(this, divCrearCompeticion)) //SERGIO
    // this.vistas.set(Vista.vunircompeticion, new UnirCompeticion(this, divUnirCompeticion))
    this.vistas.set(Vista.vmenuranking, new MenuRanking(this, divMenuRanking)) //SERGIO
    this.vistas.set(Vista.vrankingglobal, new RankingGlobal(this, divRankingGlobal)) //SERGIO
    this.vistas.set(Vista.vrankingcompeticion, new RankingCompeticion(this, divRankingCompeticion)) //SERGIO
    this.vistas.set(Vista.vpartdemo, new PartDemo(this, divPartDemo))
    this.vistas.set(Vista.vjustsocial, new JustSocial(this, divJustSocial))
    this.vistas.set(Vista.vdeshumano, new DesHumano(this, divDesHumano))
    this.vistas.set(Vista.vinterculturalidad, new Interculturalidad(this, divInterculturalidad))
    this.vistas.set(Vista.vequidadgenero, new EquidadGenero(this, divEquidadGenero))
    this.vistas.set(Vista.victoria, new Victoria(this, divVictoria));
    this.vistas.set(Vista.vconfig, new Configuracion(this, divConfig))
    this.vistas.set(Vista.vpersonajes, new Personajes(this, divPersonajes))

    this.verVista(Vista.vmenuinicial)
  }

  /**
   * Detiene o reproduce el elemento de audio según su estado actual.
   */
stopAudio() {
  const audioElement = document.getElementById('audioElementId');
  if (audioElement.paused) {
    audioElement.play();
  } else {
    audioElement.pause();
  }
 }

obtenerPuntuacion() {
  return this.puntuacion;
}

incrementarPuntuacion() {
  const puntosASumar = 20;
  this.puntuacion += puntosASumar;
}



mostrarPuntuacion() {
  console.log('Tu puntuación actual es: ' + this.obtenerPuntuacion());
}
mostrarPreguntas(ambito, datosPreguntas) {
  const instanciaRuleta = this.vistas.get(Vista.vruleta);
  const preguntasMostradas = instanciaRuleta.getPreguntasMostradas();

  const preguntaTexto = document.getElementById('preguntaTexto' + ambito);
  const respuestasArea = document.getElementById('respuestas' + ambito);
  const divPReguntas = document.getElementsByClassName('divPregunta');
  console.log('PREGUNTAS MOSTRADAS: ' + preguntasMostradas);

  if (datosPreguntas.length > 0) {
    const indiceAleatorio = Math.floor(Math.random() * datosPreguntas.length);
    const preguntaAleatoria = datosPreguntas[indiceAleatorio];

    preguntaTexto.textContent = preguntaAleatoria.pregunta;
    const respuestasAleatorias = preguntaAleatoria.respuestas.sort(() => Math.random() - 0.5);

    respuestasAleatorias.forEach((opcion) => {
      const respuestaBtn = document.createElement('button');
      respuestaBtn.textContent = opcion.texto_respuesta;
      respuestaBtn.classList.add('respuestaBtn');
      respuestaBtn.addEventListener('click', () => {
        // Deshabilitar todos los botones de respuesta después del clic
        const botonesRespuesta = respuestasArea.querySelectorAll('.respuestaBtn');
        botonesRespuesta.forEach((btn) => {
          btn.disabled = true;
        });

        const divRespuesta = document.createElement('div');
        const textoRespuesta = document.createElement('p');
        const botonSiguienteTirada = document.createElement('button');
        botonSiguienteTirada.classList.add('btnSiguienteTiradas');

        if (opcion.num_respuesta === 1) {
          this.incrementarPuntuacion();
          divRespuesta.style.display = 'block';
          textoRespuesta.textContent = '¡CORRECTO!';
          textoRespuesta.style.animation = 'popIn 0.5s ease-out';
          textoRespuesta.style.textShadow = '0 0 30px #00ff00'; 
        } else {
          divRespuesta.style.display = 'block';
          textoRespuesta.textContent = 'INCORRECTO';
          textoRespuesta.style.animation = 'popIn 0.5s ease-out';
          textoRespuesta.style.textShadow = '0 0 20px red';
        }

        divRespuesta.appendChild(textoRespuesta);

        if (preguntasMostradas === 5) {
          botonSiguienteTirada.style.display = 'none';
        } else {
          botonSiguienteTirada.textContent = 'Seguir Jugando';
          botonSiguienteTirada.addEventListener('click', () => {
            divRespuesta.style.display = 'none';
            this.verVista(Vista.vruleta);
          });
          divRespuesta.appendChild(botonSiguienteTirada);
        }

        respuestasArea.appendChild(divRespuesta);
      });

      respuestasArea.appendChild(respuestaBtn);
    });

    if (preguntasMostradas === 5) {
      respuestasAleatorias.forEach((pregunta) => {
        const respuestaBtn = Array.from(respuestasArea.getElementsByClassName('respuestaBtn')).find(
          (btn) => btn.textContent === pregunta.texto_respuesta
        );

        respuestaBtn.addEventListener('click', () => {
          const esCorrecta = pregunta.num_respuesta === 1;
          if (esCorrecta) {
            this.incrementarPuntuacion();
          }
          const puntuacionActual = this.obtenerPuntuacion();
          this.verVista(Vista.victoria, puntuacionActual);
          this.mostrarPuntuacion();
        });
      });
    }
  } else {
    preguntaTexto.textContent = 'No hay preguntas disponibles en este momento.';
  }
}


verVista (vista) {
  this.ocultarVistas()
  this.vistas.get(vista).mostrar(true)

  if (vista === Vista.vrankingglobal) {
    this.obtenerRankingGlobal();
  }
  if (vista === Vista.victoria) {
    const puntuacionActual = this.obtenerPuntuacion();
    this.vistas.get(vista).crearInterfaz2(puntuacionActual); // Pasar la puntuación a la vista Victoria
    this.vistas.get(vista).mostrar(true); // Mostrar la vista Victoria
  } else {
    this.vistas.get(vista).mostrar(true);
  }
}

  /**
   * Oculta todas las vistas del juego.
   */
  ocultarVistas(){
		for(const vista of this.vistas.values())
			vista.mostrar(false)
	}


  /**
   * Obtiene el ranking global mediante una solicitud AJAX.
   */
  obtenerRankingGlobal() {
    fetch('./js/php/ranking.php', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al obtener el ranking');
        }
        return response.json();
      })
      .then(data => {
        this.vistas.get(Vista.vrankingglobal).mostrarRankingGlobal(data);
      })
      .catch(error => console.error('Error:', error));
  }


}

/**
 * Función que se ejecuta al cargar la página para inicializar el juego.
 */
window.onload = () => {new Controlador()}