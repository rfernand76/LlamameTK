package gpchile.vadagu.server.dispacher;

import gpchile.vadagu.server.database.Bussines;
import gpchile.vadagu.server.dto.Actividad;
import gpchile.vadagu.server.dto.Atencion;
import gpchile.vadagu.server.dto.Pauta;
import gpchile.vadagu.server.dto.Point;
import gpchile.vadagu.server.dto.Sitio;
import gpchile.vadagu.server.dto.Vehiculo;
import gpchile.vadagu.server.exception.VDGException;
import gpchile.vadagu.server.figure.Drawing;
import gpchile.vadagu.server.util.Configuration;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileWriter;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import org.apache.log4j.Logger;

import com.google.gson.Gson;


public class PautaManager implements Runnable{
	public static final int ESTADO_INICIADO = 0;
	public static final int ESTADO_EN_PLANTA = 1;
	public static final int ESTADO_SALIO_PLANTA = 3;
	public static final int ESTADO_ENTRO_PTOATENCION = 4;
	public static final int ESTADO_ENTRO_PTOATENCIONVALIDADO = 5;
	public static final int ESTADO_SALIO_PTOATENCION = 6;
	public static final int ESTADO_FINALIZADA = 7;
	
	public static final String EVENTO_SALIDAPLANTA   = "0002";
	public static final String EVENTO_LLEGADACLIENTE = "0004";
	public static final String EVENTO_SALIDACLIENTE  = "0005";
	public static final String EVENTO_LLEGADAPLANTA  = "0007";
	
	
	public static final int ORIGEN_NORMAL = 1;
	public static final int ORIGEN_REPROCESO = 2;
	
	private static String path =  Configuration.getInstance().getProperty("gps.vadagu.persist.path.active");
	private static HashMap<Integer, Sitio> listSitios;
	private static HashMap<String, Vehiculo> listVehiculos;
	public static int gmt = -3;
	private static final Logger m_logger = Logger.getLogger("Vadagu");
	
	private Pauta pauta = null;
	private String fileName = "";
	private int tipoLista = 1;
	
	
	//El objetivo de este metodo es asignar todos los objetos estaticos que posee la clase, se debe ejecutar al inicializar el sistema desde la clase principal
	public static void init() throws VDGException{
		listSitios = Bussines.getSitios();
		listVehiculos = Bussines.getVehiculos();
		gmt = Bussines.getGmt();
		
    	//new Thread(new PautaManager(1)).start();	//invoca lectura de titios
		//new Thread(new PautaManager(2)).start();	//invoca lectura de vehiculos
	}
	
	
	public PautaManager(String value) throws Exception{
		this.pauta = Pauta.fromJSON(value);
	}
	
	
	public PautaManager(Pauta pauta) throws Exception{
		this.pauta = pauta;
		setFileName();
	}
	
	
	//Este metodo es provado ya que solo puede ser llamado para realizar invocaciones de tipo "lecturas estaticas" 
	private PautaManager(int tipo){
		this.tipoLista = tipo;
	}
	
	
	@Override
	public void run() {
		while(SocketManager.CONTINUE){
			String reprocesoTime = "";	//contendra la cantidad de minutos que debe esperar antes de ejecutar la proxima lectura
			
			try{
				if(tipoLista == 1){
					HashMap<Integer, Sitio> listSitiosAux = Bussines.getSitios();
					PautaManager.listSitios = listSitiosAux;
					reprocesoTime = Configuration.getInstance().getProperty("gps.vadagu.sitios.time"); 
					
				}else{
					HashMap<String, Vehiculo> listVehiculosAux = Bussines.getVehiculos();
					PautaManager.listVehiculos = listVehiculosAux;
					reprocesoTime = Configuration.getInstance().getProperty("gps.vadagu.vehiculos.time");
				}
				
				int sleep = Integer.parseInt(reprocesoTime)*1000;
				Thread.sleep(sleep);

			}catch(Exception e){
				m_logger.error("Ocurrio un problema al sincronizar la lista ", e);
			}			
		}
	}

	
	private void setFileName(){
		String tipo = "N";
		if(pauta.getOrigenPauta() == PautaManager.ORIGEN_REPROCESO){
			tipo = "R";
		}
		
		fileName = path + "/" + tipo + "_" + pauta.getCodRefPauta() + "_" + pauta.getVehiculo().getCod_vehiculoAVL2() + ".pauta";
	}


	public static HashMap<Integer, Sitio> getSitios(){
		return listSitios;
	}
	
	
	public static ArrayList<Sitio> getSitioRefSitio(String codRefSitio, Atencion at){
        Iterator it =  listSitios.entrySet().iterator();
        ArrayList<Sitio> sitios = new ArrayList<Sitio>();
        
        while (it.hasNext()) {
            Map.Entry pair = (Map.Entry)it.next();
            
            Sitio s = (Sitio)pair.getValue();
            try{
                if(s.getCod_RefSitioCliente().equals(codRefSitio)){
                	Sitio clon = s.clone();
                	
                	if(at != null){
                		clon.setCodRefAtencion(at.getCodRefAtencion());
                	}
                	sitios.add(clon);
                }
            }catch(Exception e){
            	
            }
            
        }
    	
    	return sitios;
	}
	
	
	public void setCodVehiloAVL(Vehiculo vehiculo){
		this.pauta.setVehiculo(vehiculo);
	}
	
	
	public Pauta getPauta(){
		return this.pauta;
	}
	
	
	public void create(){
		//fileName = path + "/" + pauta.getCodRefPauta() + "_" + pauta.getCod_vehiculoAVL() + ".pauta";
		setFileName();
		save();
	}
	
	
	public static HashMap<String, PautaManager> loadFromFiles(){
		File folder = new File(path);
		File[] listOfFiles = folder.listFiles();
		HashMap<String, PautaManager> lista = new HashMap<String, PautaManager>();
		
		if(listOfFiles != null){
			for (File file : listOfFiles) {
			    if (file.isFile()) {
			        if(file.getName().endsWith(".pauta")){
			        	String name = file.getName();
			        	try{
				        	
				        	String nameFisico = name.substring(0, name.indexOf("."));
				        	String s[] = nameFisico.split("_");
				        	
				        	PautaManager pm = load(nameFisico);
				        	if(pm != null){
				        		lista.put(s[2], pm);
			        			//pm.reprocesa();
				        	}
				        	
			        	}catch(Exception e){
			        		m_logger.error("Ocurrio un error al leer la pauta "+name, e);
			        	}
			        }
			    }
			}
		}
		
		return lista;
	}
	
	
	public static PautaManager load(String name){
		PautaManager pm = null;
		String fileName = path + "/" + name + ".pauta";
		
		FileInputStream fout = null;
		ObjectInputStream oos = null;
		
		try{
			fout = new FileInputStream(fileName);
			oos = new ObjectInputStream(fout);
			Pauta pauta = (Pauta)oos.readObject();
			pm = new PautaManager(pauta);

		}catch(Exception e){
			m_logger.error("No se pudo cargar la pauta: "+fileName, e);
		} finally {
			try{fout.close();}catch(Exception e){}
			try{oos.close();}catch(Exception e){}
		}
		
		return pm;
	}
	
	
	//Metodo que ejecuta cuando el vehiculo registra una nueva actividad
	public void onMessage(Actividad actividad){
		synchronized(this.pauta.getCodRefPauta()) {
			analizer(actividad);
			
			if(this.pauta.getEstado() != ESTADO_FINALIZADA){
				save();
				
			}else{
				end();
			}
		}
	}


	private void analizer(Actividad actividad){
		//seria interesante que valide que la actividad sea mayor a la ultima actividad procesada, de esta manera 
		//podria convivir el reproceso conel ingreso normaal.  La dificultad de esto es que el metodo normal tiene 
		//el correlativo de navman y el reproceso el codigo de integracion.
		//Se debe considerar y en lo posible aplicar como mejora.  Quizas una buena alternativa seria validarlo por la fechahora de la actividad
		
		//m_logger.debug("Procesando actividad:"+actividad.getNum_actividad() );
		switch(pauta.getOrigenPauta()){
			case PautaManager.ORIGEN_NORMAL:
				analizerNormal(actividad);
				break;
			case PautaManager.ORIGEN_REPROCESO:
				analizerReproceso(actividad);
				break;				
		}
	}


	private void analizerNormal(Actividad actividad){
		switch(pauta.getEstado()){
		case ESTADO_INICIADO:
			analizaNormalEntradaAPlata(actividad);
			break;
			
		case ESTADO_EN_PLANTA:
			analizaNormalSalidaPlanta(actividad);
			break;
			
		case ESTADO_SALIO_PLANTA:
			analizaNormalLLegadaSitio(actividad);
			break;
			
		case ESTADO_ENTRO_PTOATENCION:
			analizaNormalActividadesSitio(actividad);
			break;
			
		case ESTADO_ENTRO_PTOATENCIONVALIDADO:
			analizaNormalActividadesFueraSitio(actividad);
			break;
			
		case ESTADO_SALIO_PTOATENCION:
			analizaNormalVueltaCliente(actividad);
			break;
		}
	}
	
	private void analizerReproceso(Actividad actividad){
		switch(pauta.getEstado()){
		case PautaManager.ESTADO_INICIADO:
			break;
			
		case PautaManager.ESTADO_SALIO_PLANTA:
			break;
		}
	}


	private void analizaNormalEntradaAPlata(Actividad actividad){
		Sitio planta = this.pauta.getPlantaInicio();
		
		Drawing poly = planta.getPoligonoObject();
		Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
		if(poly.contains(test)){
			pauta.setEntradaPlanta(actividad.getFechaHoraActividad());
			pauta.setEstado(PautaManager.ESTADO_EN_PLANTA);
		}
	}
	
	private void analizaNormalSalidaPlanta(Actividad actividad){
		Sitio planta = this.pauta.getPlantaInicio();
		
		Drawing poly = planta.getPoligonoObject();
		Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
		if(!poly.contains(test)){
			pauta.setSalidaPlanta(actividad.getFechaHoraActividad());
			pauta.setEstado(PautaManager.ESTADO_SALIO_PLANTA);
			enviaEvento(EVENTO_SALIDAPLANTA, 
						this.getPauta().getCodRefPauta(), 
						null, 
						this.getVehiculo().getRefVehiculo(), 
						actividad.getFechaHoraActividad()
			);
		}
	}
	
	private void analizaNormalLLegadaSitio(Actividad actividad){
		
		boolean encontrado = false;
		int i=0;
		
		while(!encontrado &&i<this.getPauta().getSitiosDespacho().size()){
			Sitio sitio = this.getPauta().getSitiosDespacho().get(i);
			
			Drawing poly = sitio.getPoligonoObject();
			Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
			
			if(poly.contains(test)){
				sitio.setLlegadaPuntoAtencion(actividad.getFechaHoraActividad());
				
				pauta.setEstado(PautaManager.ESTADO_ENTRO_PTOATENCION);
				this.validaLLegadaPtoAtencion(actividad, sitio);
				
				encontrado = true;
				pauta.setRefSitioAnalizar(sitio);
			}
			
			i++;
		}
	}
	
	private void analizaNormalActividadesSitio(Actividad actividad){
		Sitio sitio = pauta.getRefSitioAnalizar();
		
		Drawing poly = sitio.getPoligonoObject();
		Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
		
		if(poly.contains(test)){
			//El vehiculo continua n el sitio
			this.validaLLegadaPtoAtencion(actividad, sitio);
		}else{
			pauta.setEstado(PautaManager.ESTADO_SALIO_PLANTA);
			pauta.setRefSitioAnalizar(null);
			analizaNormalLLegadaSitio(actividad);
		}

	}
	
	private void analizaNormalActividadesFueraSitio(Actividad actividad){
		Sitio sitio = pauta.getRefSitioAnalizar();
		
		Drawing poly = sitio.getPoligonoObject();
		Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
		
		if(!poly.contains(test)){
			pauta.setEstado(PautaManager.ESTADO_SALIO_PTOATENCION);
			
			enviaEvento(EVENTO_SALIDACLIENTE, 
					this.getPauta().getCodRefPauta(), 
					sitio.getCodRefAtencion(), 
					this.getVehiculo().getRefVehiculo(), 
					actividad.getFechaHoraActividad()
					);
		}
	}
	
	
	private void analizaNormalVueltaCliente(Actividad actividad){
		Sitio sitio = pauta.getPlantaFinal();
		
		Drawing poly = sitio.getPoligonoObject();
		Point test = new Point(actividad.getLatitud(), actividad.getLongitud());
		
		if(poly.contains(test)){
			pauta.setEstado(PautaManager.ESTADO_FINALIZADA);
			
			enviaEvento(EVENTO_LLEGADAPLANTA, 
					this.getPauta().getCodRefPauta(), 
					null, 
					this.getVehiculo().getRefVehiculo(), 
					actividad.getFechaHoraActividad()
					);
		}
		
	}
	
	
	private void validaLLegadaPtoAtencion(Actividad actividad, Sitio sitio ){
		if(Sitio.TIPO_EVENTO_ENTRADA.equals(sitio.getEventoFinAtencion())){
			Calendar c = Calendar.getInstance();
			c.setTime(sitio.getLlegadaPuntoAtencion());
			c.add(Calendar.MINUTE, sitio.getTiempoInicioAtencion());
			
			Calendar actual = Calendar.getInstance();
			actual.setTime(actividad.getFechaHoraActividad());
			
			if(c.compareTo(actual) < 0){
				//sitio.setLlegadaPuntoAtencion(actividad.getFechaHoraActividad());
				pauta.setEstado(ESTADO_ENTRO_PTOATENCIONVALIDADO);
				
				enviaEvento(EVENTO_LLEGADACLIENTE, 
						this.getPauta().getCodRefPauta(), 
						sitio.getCodRefAtencion(), 
						this.getVehiculo().getRefVehiculo(), 
						sitio.getLlegadaPuntoAtencion()
						);
			}
		}
	}
	
	private void enviaEvento(String evento, String refPauta, String atencio, String vehiculo, Date fechaHoraActividad){
		SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMddHHmmss");
		SimpleDateFormat sdf2 = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		String strFecha = sdf.format(fechaHoraActividad);
		String strFecha2 = sdf2.format(new Date());
		
		String log = "envia: {fecha:'"+strFecha2+"' evento: '"+evento + "', pauta:'"+refPauta+ "', atencio:'"+atencio+"', vehiculo:'"+vehiculo+"', fechaHoraActividad:'"+strFecha+"'}";
		
		System.out.println(log);
		m_logger.debug(log);
	}
	
	
	public void addSites(ArrayList<Sitio> sitiosDespacho){
		for(int i=0; i<sitiosDespacho.size(); i++){
			Sitio s = sitiosDespacho.get(i);
			this.pauta.addSite(s);
		}
		save();
	}
	
	
	/*
	 * Este metodo se encarga de bajar consistentemente la pauta.  Guarda el estado de la pauta en un archivo y indica cual es la ultima actividad leida
	 * para poder recuperarse al momento de subir nuevamente el proceso
	 */
	public void shutdown(){
		save();
	}
	
	
	/*
	 * Este metodo se encarga de subir consistentemente la pauta. Es el proceso inverso de shutdown y debe ser ejecutado cuando el sistema se 
	 * bajo y debe continuar con el analisis de las pautas
	 */
	public void initialice(){
		
	}


	public String getRefPauta(){
		return this.pauta.getCodRefPauta();
	}
	
	
	//realiza la persistencia de la pauta en disco
	public void save(){
		saveInText();
		//saveInBinary();
	}
	
	private void saveInText(){
		FileWriter fout = null;
		BufferedWriter oos = null;
		
		try {
			fout = new FileWriter(fileName);
			oos = new BufferedWriter(fout);
			Gson gson = new Gson();
			String writeTo = gson.toJson(pauta);
			oos.write(writeTo);
			oos.flush();
			
		}catch(Exception e){
			m_logger.error("Ocurrio un error al grabar la pauta "+fileName, e);
		} finally {
			try{fout.close();}catch(Exception e){}
			try{oos.close();}catch(Exception e){}
		}
	}
	
	private void saveInBinary(){
		FileOutputStream fout = null;
		ObjectOutputStream oos = null;
		
		try{
			fout = new FileOutputStream(fileName);
			oos = new ObjectOutputStream(fout);
			
			oos.writeObject(pauta);
		}catch(Exception e){
			m_logger.error("Ocurrio un error al grabar la pauta "+fileName, e);
		} finally {
			try{fout.close();}catch(Exception e){}
			try{oos.close();}catch(Exception e){}
		}
	}
	
	
	public void end(){
    	try{
    		save();
    		
    		Path movefrom = FileSystems.getDefault().getPath(fileName);
    		Path target = FileSystems.getDefault().getPath(Configuration.getInstance().getProperty("gps.vadagu.persist.path.close") +"/" + movefrom.getFileName());
    		
    		Files.move(movefrom, target, StandardCopyOption.REPLACE_EXISTING);
    		
    	}catch(Exception e){
    		m_logger.error("Ocurrio un problema al finalizar la pauta " + this.pauta.getCodRefPauta());
    	}
	}
	
	
    public static Vehiculo getVehiculoFromRefVehiculo(String refAcoplado){
    	
        Iterator it =  listVehiculos.entrySet().iterator();
        while (it.hasNext()) {
            Map.Entry pair = (Map.Entry)it.next();
            
            Vehiculo v = (Vehiculo)pair.getValue();
            if(v.getCod_RefAcoplado().equals(refAcoplado)){
            	return v;
            }
        }
    	
    	return null;
    }
    
    
    public boolean isReproceso(){
    	return (this.pauta.getOrigenPauta()==PautaManager.ORIGEN_REPROCESO);
    }
    
    
    public void reprocesa(){
    	m_logger.debug("Reporcesa pauta:" + this.pauta.getCodRefPauta() + " con " +this.pauta.getSitiosDespacho().size()+" sitios");
    	long ultimaActividadLeida = this.pauta.getUltimaActividadLeida();
    	
		synchronized(this.pauta.getCodRefPauta()) {
			int numPagina = 0;
			ArrayList<Actividad> list = Bussines.getActividadesPendiantes(this.pauta, ultimaActividadLeida, numPagina);
			
			while(list != null && list.size() > 0){
				for(int i=0; i<list.size(); i++){
					Actividad actividad = list.get(i);
					
					this.pauta.setUltimaActividadLeida(actividad.getNum_actividad());
					analizer(actividad);
				}
				
				numPagina=numPagina+list.size();
				list = Bussines.getActividadesPendiantes(this.pauta, ultimaActividadLeida, numPagina);
			}
		}
    }
    
    
    public void setVehiculo(Vehiculo v){
    	this.pauta.setVehiculo(v);
    }
    
    
    public Vehiculo getVehiculo(){
    	return this.pauta.getVehiculo();
    }
}
