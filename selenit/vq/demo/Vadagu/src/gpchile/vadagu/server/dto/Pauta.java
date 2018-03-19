package gpchile.vadagu.server.dto;

import gpchile.vadagu.server.dispacher.PautaManager;

import java.io.IOException;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Date;

import com.google.gson.Gson;



public class Pauta implements Serializable {
	//private int cod_vehiculo;
	private int num_pauta;
	
	private String id_Cliente1;
	private String codRefPauta;
	private int cod_Ruta1;
	private String fechaPauta;
	//private int cod_Vehiculo1;
	private int cod_Acoplado1;
	private int cod_PuntoInicio1;
	private String llegadaPuntoInicio1;
	private String inicioProg;
	private int cod_PuntoTermino1;
	private String terminoProg;
	private int cod_Conductor1;
	//private String cod_refVehiculo;
	private String refPuntoInicio;
	private String refPuntoTermino;
	
	
	private Date inicio = null;    							//indica la fecha de creacion del objeto Pauta
	private Date fin    = null;    							//indica la fecha maxima de ejecucion, si llegada esta hora la pauta no ha finalizado, el hilo se finalizara automaticamente
	private int estado  = PautaManager.ESTADO_INICIADO;     //indica el estado actual de la pauta
	private Sitio plantaInicio = null;						//Punto inicio de la pauta (la planta de la cual saldra el despacho)
	private Sitio plantaFinal  = null;	    				//Punto final de la pauta (la planta donde debe llegar el camion cuando se termine el despacho)
	private ArrayList<Sitio> sitiosDespacho = new ArrayList<Sitio>();	 //lista de sitios donde se debe dirigir el vehiculo para realizar el despacho
	private int origenPauta = PautaManager.ORIGEN_NORMAL;	//Indica si la pauta fue creada por el WS normal o de reproceso
	private long ultimaActividadLeida = 0;					//indica cual fue el ultimo codigo de actividad que se leyo desde la base
	//private String cod_vehiculoAVL;
	private Vehiculo vehiculo = null;
	
	private Date entradaPlanta;
	private Date salidaPlanta;
	private Sitio refSitioAnalizar = null;					//Contiene una refereia hacia el sitio en el que se encuetra actulmente el vehiculo
	
	
	public static Pauta fromJSON(String strObject) throws IOException{
		Gson gson = new Gson();
		
		Pauta p = gson.fromJson(strObject, Pauta.class);
		p.plantaInicio = PautaManager.getSitioRefSitio(p.getRefPuntoInicio(), null).get(0);
		p.plantaFinal = PautaManager.getSitioRefSitio(p.getRefPuntoTermino(), null).get(0);
		p.inicio = new Date();
	    
		return p;
	}

	

	public int getNum_pauta() {
		return num_pauta;
	}

	public void setNum_pauta(int num_pauta) {
		this.num_pauta = num_pauta;
	}


	public String getId_Cliente1() {
		return id_Cliente1;
	}


	public void setId_Cliente1(String id_Cliente1) {
		this.id_Cliente1 = id_Cliente1;
	}


	public String getCodRefPauta() {
		return codRefPauta;
	}


	public void setCodRefPauta(String codRefPauta) {
		this.codRefPauta = codRefPauta;
	}


	public int getCod_Ruta1() {
		return cod_Ruta1;
	}


	public void setCod_Ruta1(int cod_Ruta1) {
		this.cod_Ruta1 = cod_Ruta1;
	}


	public String getFechaPauta() {
		return fechaPauta;
	}


	public void setFechaPauta(String fechaPauta) {
		this.fechaPauta = fechaPauta;
	}


	/*public int getCod_Vehiculo1() {
		return cod_Vehiculo1;
	}


	public void setCod_Vehiculo1(int cod_Vehiculo1) {
		this.cod_Vehiculo1 = cod_Vehiculo1;
	}*/


	public int getCod_Acoplado1() {
		return cod_Acoplado1;
	}


	public void setCod_Acoplado1(int cod_Acoplado1) {
		this.cod_Acoplado1 = cod_Acoplado1;
	}


	public int getCod_PuntoInicio1() {
		return cod_PuntoInicio1;
	}


	public void setCod_PuntoInicio1(int cod_PuntoInicio1) {
		this.cod_PuntoInicio1 = cod_PuntoInicio1;
	}


	public String getLlegadaPuntoInicio1() {
		return llegadaPuntoInicio1;
	}


	public void setLlegadaPuntoInicio1(String llegadaPuntoInicio1) {
		this.llegadaPuntoInicio1 = llegadaPuntoInicio1;
	}


	public String getInicioProg() {
		return inicioProg;
	}


	public void setInicioProg(String inicioProg) {
		this.inicioProg = inicioProg;
	}


	public int getCod_PuntoTermino1() {
		return cod_PuntoTermino1;
	}


	public void setCod_PuntoTermino1(int cod_PuntoTermino1) {
		this.cod_PuntoTermino1 = cod_PuntoTermino1;
	}


	public String getTerminoProg() {
		return terminoProg;
	}


	public void setTerminoProg(String terminoProg) {
		this.terminoProg = terminoProg;
	}


	public int getCod_Conductor1() {
		return cod_Conductor1;
	}


	public void setCod_Conductor1(int cod_Conductor1) {
		this.cod_Conductor1 = cod_Conductor1;
	}


	public Date getInicio() {
		return inicio;
	}


	public void setInicio(Date inicio) {
		this.inicio = inicio;
	}


	public Date getFin() {
		return fin;
	}


	public void setFin(Date fin) {
		this.fin = fin;
	}


	public int getEstado() {
		return estado;
	}


	public void setEstado(int estado) {
		this.estado = estado;
	}


	public Sitio getPlantaInicio() {
		return plantaInicio;
	}


	public void setPlantaInicio(Sitio plantaInicio) {
		this.plantaInicio = plantaInicio;
	}


	public Sitio getPlantaFinal() {
		return plantaFinal;
	}


	public void setPlantaFinal(Sitio plantaFinal) {
		this.plantaFinal = plantaFinal;
	}


	public ArrayList<Sitio> getSitiosDespacho() {
		return sitiosDespacho;
	}
	
	public void setSitiosDespacho(ArrayList<Sitio> sitiosDespacho) {
		this.sitiosDespacho = sitiosDespacho;
	}


	public void addSite(Sitio sitiosDespacho) {
		this.sitiosDespacho.add(sitiosDespacho);
	}


	public int getOrigenPauta() {
		return origenPauta;
	}


	public void setOrigenPauta(int origenPauta) {
		this.origenPauta = origenPauta;
	}


	public static int getEstadoIniciado() {
		return PautaManager.ESTADO_INICIADO;
	}


	/*public String getCod_refVehiculo() {
		return cod_refVehiculo;
	}


	public void setCod_refVehiculo(String cod_refVehiculo) {
		this.cod_refVehiculo = cod_refVehiculo;
	}*/


	public long getUltimaActividadLeida() {
		return ultimaActividadLeida;
	}


	public void setUltimaActividadLeida(long ultimaActividadLeida) {
		this.ultimaActividadLeida = ultimaActividadLeida;
	}


	/*public String getCod_vehiculoAVL() {
		return cod_vehiculoAVL;
	}


	public void setCod_vehiculoAVL(String cod_vehiculoAVL) {
		this.cod_vehiculoAVL = cod_vehiculoAVL;
	}*/


	public String getRefPuntoInicio() {
		return refPuntoInicio;
	}


	public void setRefPuntoInicio(String refPuntoInicio) {
		this.refPuntoInicio = refPuntoInicio;
	}


	public String getRefPuntoTermino() {
		return refPuntoTermino;
	}


	public void setRefPuntoTermino(String refPuntoTermino) {
		this.refPuntoTermino = refPuntoTermino;
	}


	public Vehiculo getVehiculo() {
		return vehiculo;
	}


	public void setVehiculo(Vehiculo vehiculo) {
		this.vehiculo = vehiculo;
	}


	public Date getEntradaPlanta() {
		return entradaPlanta;
	}


	public void setEntradaPlanta(Date entradaPlanta) {
		this.entradaPlanta = entradaPlanta;
	}


	public Date getSalidaPlanta() {
		return salidaPlanta;
	}
	

	public void setSalidaPlanta(Date salidaPlanta) {
		this.salidaPlanta = salidaPlanta;
	}


	public Sitio getRefSitioAnalizar() {
		return refSitioAnalizar;
	}


	public void setRefSitioAnalizar(Sitio refSitioAnalizar) {
		this.refSitioAnalizar = refSitioAnalizar;
	}
	
}
