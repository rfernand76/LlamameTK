package gpchile.vadagu.server.dto;

import java.io.IOException;
import java.io.Serializable;
import java.util.Date;

import com.google.gson.Gson;

public class Atencion implements Serializable{
	private String cod_refPauta;
	private int puntoServicio;
	private String codRefPuntoServicio;
	private String codRefAtencion;
	
	public static Atencion fromJSON(String strObject) throws IOException{
		Gson gson = new Gson();
		Atencion p = gson.fromJson(strObject, Atencion.class);
	    
		return p;
	}
	
	public String getCod_refPauta() {
		return cod_refPauta;
	}
	public void setCod_refPauta(String cod_refPauta) {
		this.cod_refPauta = cod_refPauta;
	}
	
	public int getPuntoServicio() {
		return puntoServicio;
	}
	public void setPuntoServicio(int puntoServicio) {
		this.puntoServicio = puntoServicio;
	}

	public String getCodRefPuntoServicio() {
		return codRefPuntoServicio;
	}
	public void setCodRefPuntoServicio(String codRefPuntoServicio) {
		this.codRefPuntoServicio = codRefPuntoServicio;
	}

	public String getCodRefAtencion() {
		return codRefAtencion;
	}

	public void setCodRefAtencion(String codRefAtencion) {
		this.codRefAtencion = codRefAtencion;
	}
	
}
