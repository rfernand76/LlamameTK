package gpchile.vadagu.server.dto;

import java.io.IOException;
import java.io.Serializable;
import java.util.Date;

import com.google.gson.Gson;

public class Actividad implements Serializable{
	private long num_actividad;
	private String cod_vehiculoAVL2;
	private int cod_tipoEvento;
	private Date fechaHoraActividad;
	private double latitud;
	private double longitud;
	private int ignicion;
	
	public Actividad(){
		
	}
	
	public static Actividad fromJSON(String strObject) throws IOException{
		Gson gson = new Gson();
		Actividad p = gson.fromJson(strObject, Actividad.class);
	    
		return p;
	}
	
	public long getNum_actividad() {
		return num_actividad;
	}
	public void setNum_actividad(long num_actividad) {
		this.num_actividad = num_actividad;
	}
	public String getCod_vehiculoAVL2() {
		return cod_vehiculoAVL2;
	}
	public void seCod_vehiculoAVL2(String cod_vehiculoAVL2) {
		this.cod_vehiculoAVL2 = cod_vehiculoAVL2;
	}
	public int cod_vehiculoAVL2() {
		return cod_tipoEvento;
	}
	public void setCod_tipoEvento(int cod_tipoEvento) {
		this.cod_tipoEvento = cod_tipoEvento;
	}
	public Date getFechaHoraActividad() {
		return fechaHoraActividad;
	}
	public void setFechaHoraActividad(Date fechaHoraActividad) {
		this.fechaHoraActividad = fechaHoraActividad;
	}
	public double getLatitud() {
		return latitud;
	}
	public void setLatitud(double latitud) {
		this.latitud = latitud;
	}
	public double getLongitud() {
		return longitud;
	}
	public void setLongitud(double longitud) {
		this.longitud = longitud;
	}
	public int getIgnicion() {
		return ignicion;
	}
	public void setIgnicion(int ingencion) {
		this.ignicion = ingencion;
	}
	
}
