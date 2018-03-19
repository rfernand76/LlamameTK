package gpchile.vadagu.server.dto;

import java.io.Serializable;

public class Point implements Serializable{
	private double latitud;
	private double longitud;
	
	public Point(){
		
	}
	
	public Point(double latitud, double longitud){
		this.latitud = latitud;
		this.longitud = longitud;

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

}
