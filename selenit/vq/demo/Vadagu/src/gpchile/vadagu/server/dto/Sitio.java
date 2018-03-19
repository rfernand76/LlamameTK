package gpchile.vadagu.server.dto;

import gpchile.vadagu.server.figure.Circle;
import gpchile.vadagu.server.figure.Drawing;
import gpchile.vadagu.server.figure.Polygon;

import java.io.Serializable;
import java.util.Date;

public class Sitio implements Serializable, Cloneable{
	public static final String TIPO_EVENTO_ENTRADA = "E";
	public static final String TIPO_EVENTO_DETENCION = "D";
	
	private int		cod_SitioCliente;
	private String	id_Cliente;
	private String	cod_RefSitioCliente="";
	private String	id_ClienteInterno;
	private String	cod_RefSitioClienteInterno;
	private String	nomSitioCliente;
	private String	dirSitioCliente;
	private int		cod_Comuna;
	private int		cod_Ciudad;
	private float	latitud;
	private float	longitud;
	private float	radio;
	private String	poligono;
	private float	areaPoligono;
	private String	cuadrante;
	private int		cod_TipoSitioCliente;
	private int		tiempoInicioAtencion;
	private String	eventoInicioAtencion;
	private int		tiempoMaximoDetencion;
	private String	eventoFinAtencion;
	private int		valorEventoFinAtencion;
	private String	informacionAdicional;
	private int		cod_EstadoSitioCliente;
	private int		cod_CategoriaSitioCliente;
	private String	ins_Id;
	private Date	ins_Dt;
	private String	mod_Id;
	private Date	mod_Dt;
	
	private Drawing poligonoObject = null;
	private Date llegadaPuntoAtencion = null;
	private Date salidaPuntoAtencion = null;
	private String codRefAtencion;
	
	
	public Sitio clone() throws CloneNotSupportedException {
        return (Sitio)super.clone();
    }
	

	public int getCod_SitioCliente() {
		return cod_SitioCliente;
	}

	public void setCod_SitioCliente(int cod_SitioCliente) {
		this.cod_SitioCliente = cod_SitioCliente;
	}

	public String getId_Cliente() {
		return id_Cliente;
	}

	public void setId_Cliente(String id_Cliente) {
		this.id_Cliente = id_Cliente;
	}

	public String getCod_RefSitioCliente() {
		return cod_RefSitioCliente;
	}

	public void setCod_RefSitioCliente(String cod_RefSitioCliente) {
		this.cod_RefSitioCliente = cod_RefSitioCliente;
	}

	public String getId_ClienteInterno() {
		return id_ClienteInterno;
	}

	public void setId_ClienteInterno(String id_ClienteInterno) {
		this.id_ClienteInterno = id_ClienteInterno;
	}

	public String getCod_RefSitioClienteInterno() {
		return cod_RefSitioClienteInterno;
	}

	public void setCod_RefSitioClienteInterno(String cod_RefSitioClienteInterno) {
		this.cod_RefSitioClienteInterno = cod_RefSitioClienteInterno;
	}

	public String getNomSitioCliente() {
		return nomSitioCliente;
	}

	public void setNomSitioCliente(String nomSitioCliente) {
		this.nomSitioCliente = nomSitioCliente;
	}

	public String getDirSitioCliente() {
		return dirSitioCliente;
	}

	public void setDirSitioCliente(String dirSitioCliente) {
		this.dirSitioCliente = dirSitioCliente;
	}

	public int getCod_Comuna() {
		return cod_Comuna;
	}

	public void setCod_Comuna(int cod_Comuna) {
		this.cod_Comuna = cod_Comuna;
	}

	public int getCod_Ciudad() {
		return cod_Ciudad;
	}

	public void setCod_Ciudad(int cod_Ciudad) {
		this.cod_Ciudad = cod_Ciudad;
	}

	public float getLatitud() {
		return latitud;
	}

	public void setLatitud(float latitud) {
		this.latitud = latitud;
	}

	public float getLongitud() {
		return longitud;
	}

	public void setLongitud(float longitud) {
		this.longitud = longitud;
	}

	public float getRadio() {
		return radio;
	}

	public void setRadio(float radio) {
		this.radio = radio;
	}

	public String getPoligono() {
		return poligono;
	}

	public void setPoligono(String poligono) {
		if(this.radio == 0){
			this.poligonoObject = new Polygon(poligono);
		}else{
			Point p = new Point(this.latitud, this.longitud);
			this.poligonoObject = new Circle(this.radio, p);
		}
		this.poligono = poligono;
	}

	public float getAreaPoligono() {
		return areaPoligono;
	}

	public void setAreaPoligono(float areaPoligono) {
		this.areaPoligono = areaPoligono;
	}

	public String getCuadrante() {
		return cuadrante;
	}

	public void setCuadrante(String cuadrante) {
		this.cuadrante = cuadrante;
	}

	public int getCod_TipoSitioCliente() {
		return cod_TipoSitioCliente;
	}

	public void setCod_TipoSitioCliente(int cod_TipoSitioCliente) {
		this.cod_TipoSitioCliente = cod_TipoSitioCliente;
	}

	public int getTiempoInicioAtencion() {
		return tiempoInicioAtencion;
	}

	public void setTiempoInicioAtencion(int tiempoInicioAtencion) {
		this.tiempoInicioAtencion = tiempoInicioAtencion;
	}

	public String getEventoInicioAtencion() {
		return eventoInicioAtencion;
	}

	public void setEventoInicioAtencion(String eventoInicioAtencion) {
		this.eventoInicioAtencion = eventoInicioAtencion;
	}

	public int getTiempoMaximoDetencion() {
		return tiempoMaximoDetencion;
	}

	public void setTiempoMaximoDetencion(int tiempoMaximoDetencion) {
		this.tiempoMaximoDetencion = tiempoMaximoDetencion;
	}

	public String getEventoFinAtencion() {
		return eventoFinAtencion;
	}

	public void setEventoFinAtencion(String eventoFinAtencion) {
		this.eventoFinAtencion = eventoFinAtencion;
	}

	public int getValorEventoFinAtencion() {
		return valorEventoFinAtencion;
	}

	public void setValorEventoFinAtencion(int valorEventoFinAtencion) {
		this.valorEventoFinAtencion = valorEventoFinAtencion;
	}

	public String getInformacionAdicional() {
		return informacionAdicional;
	}

	public void setInformacionAdicional(String informacionAdicional) {
		this.informacionAdicional = informacionAdicional;
	}

	public int getCod_EstadoSitioCliente() {
		return cod_EstadoSitioCliente;
	}

	public void setCod_EstadoSitioCliente(int cod_EstadoSitioCliente) {
		this.cod_EstadoSitioCliente = cod_EstadoSitioCliente;
	}

	public int getCod_CategoriaSitioCliente() {
		return cod_CategoriaSitioCliente;
	}

	public void setCod_CategoriaSitioCliente(int cod_CategoriaSitioCliente) {
		this.cod_CategoriaSitioCliente = cod_CategoriaSitioCliente;
	}

	public String getIns_Id() {
		return ins_Id;
	}

	public void setIns_Id(String ins_Id) {
		this.ins_Id = ins_Id;
	}

	public Date getIns_Dt() {
		return ins_Dt;
	}

	public void setIns_Dt(Date ins_Dt) {
		this.ins_Dt = ins_Dt;
	}

	public String getMod_Id() {
		return mod_Id;
	}

	public void setMod_Id(String mod_Id) {
		this.mod_Id = mod_Id;
	}

	public Date getMod_Dt() {
		return mod_Dt;
	}

	public void setMod_Dt(Date mod_Dt) {
		this.mod_Dt = mod_Dt;
	}

	public Drawing getPoligonoObject() {
		return poligonoObject;
	}

	public void setPoligonoObject(Drawing poligonoObject) {
		this.poligonoObject = poligonoObject;
	}

	public Date getLlegadaPuntoAtencion() {
		return llegadaPuntoAtencion;
	}

	public void setLlegadaPuntoAtencion(Date llegadaPuntoAtencion) {
		this.llegadaPuntoAtencion = llegadaPuntoAtencion;
	}

	public Date getSalidaPuntoAtencion() {
		return salidaPuntoAtencion;
	}

	public void setSalidaPuntoAtencion(Date salidaPuntoAtencion) {
		this.salidaPuntoAtencion = salidaPuntoAtencion;
	}

	public String getCodRefAtencion() {
		return codRefAtencion;
	}

	public void setCodRefAtencion(String codRefAtencion) {
		this.codRefAtencion = codRefAtencion;
	}
}
	