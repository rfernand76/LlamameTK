package gpchile.vadagu.server.dto;

import java.io.Serializable;

public class Vehiculo implements Serializable{
	private String cod_RefAcoplado;
	private String cod_vehiculoAVL2;
	private int cod_vehiculo;
	private String rego;
	private String refVehiculo;
	
	public String getCod_RefAcoplado() {
		return cod_RefAcoplado;
	}
	public void setCod_RefAcoplado(String cod_RefAcoplado) {
		this.cod_RefAcoplado = cod_RefAcoplado;
	}
	public String getCod_vehiculoAVL2() {
		return cod_vehiculoAVL2;
	}
	public void setCod_vehiculoAVL2(String cod_vehiculoAVL2) {
		this.cod_vehiculoAVL2 = cod_vehiculoAVL2;
	}
	public int getCod_vehiculo() {
		return cod_vehiculo;
	}
	public void setCod_vehiculo(int cod_vehiculo) {
		this.cod_vehiculo = cod_vehiculo;
	}
	public String getRego() {
		return rego;
	}
	public void setRego(String rego) {
		this.rego = rego;
	}
	public String getRefVehiculo() {
		return refVehiculo;
	}
	public void setRefVehiculo(String refVehiculo) {
		this.refVehiculo = refVehiculo;
	}
	
	
}
