export class Vista {
  static {
    Vista.vmenuinicial = Symbol('Inicio')
    Vista.vruleta = Symbol('Ruleta')
    Vista.vmenucompeticion = Symbol('Menu Competicion')
    Vista.vcrearcompeticion = Symbol('Crear Competicion')
    Vista.vunircompeticion = Symbol('Unirse Competicion')
    Vista.vmenuranking = Symbol('Menu Ranking')
    Vista.vrankingglobal = Symbol('Ranking Global')
    Vista.vrankingcompeticion = Symbol('Ranking Competiciones')
    Vista.vpartdemo = Symbol('Participación Democrática')
    Vista.vjustsocial = Symbol('Justicia Social')
    Vista.vdeshumano = Symbol('Desarrollo Humano y Sostenible')
    Vista.vinterculturalidad = Symbol('Interculturalidad e Inclusión')
    Vista.vequidadgenero = Symbol('Equidad de género y Coeducación')
    Vista.vconfig = Symbol('Configuracion para PC')
    Vista.victoria = Symbol('Puntuacion')
  }

  constructor(controlador, base) {
    this.controlador = controlador
    this.base = base
  }

  mostrar(ver) {
    if (ver)
      this.base.style.display = 'block'
    else 
      this.base.style.display = 'none'
  }
}
