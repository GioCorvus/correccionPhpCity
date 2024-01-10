class RespuestasIncorrectasManager {
    constructor() {
        this.contadorRespuestasIncorrectas = 3;
        this.container = document.getElementById('respuestas_incorrectas_container');
    }

    agregarRespuestaIncorrecta() {
        const label = document.createElement('label');
        label.setAttribute('for', 'texto_respuesta_incorrecta' + this.contadorRespuestasIncorrectas);
        label.textContent = 'Texto de la Respuesta Incorrecta ' + this.contadorRespuestasIncorrectas + ':';

        const input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('id', 'texto_respuesta_incorrecta' + this.contadorRespuestasIncorrectas);
        input.setAttribute('name', 'texto_respuesta_incorrecta' + this.contadorRespuestasIncorrectas);

        this.container.appendChild(label);
        this.container.appendChild(input);
        this.container.appendChild(document.createElement('br'));

        this.contadorRespuestasIncorrectas++;
    }

    eliminarRespuestaIncorrecta() {
        console.log("borrao")
        if (this.contadorRespuestasIncorrectas > 3) {
            this.contadorRespuestasIncorrectas--;

            this.container.removeChild(this.container.lastChild); // <br>
            this.container.removeChild(this.container.lastChild); // input
            this.container.removeChild(this.container.lastChild); // label
        } else {
            console.log("No puedo bajar de 3");
        }
    }
}

const respuestasManager = new RespuestasIncorrectasManager();

function agregarRespuestaIncorrecta() {
    respuestasManager.agregarRespuestaIncorrecta();
}

function eliminarRespuestaIncorrecta() {
    respuestasManager.eliminarRespuestaIncorrecta();
}
