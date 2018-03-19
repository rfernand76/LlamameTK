package gpchile.vadagu.server.dispacher;

import gpchile.vadagu.server.database.Bussines;
import gpchile.vadagu.server.dto.Actividad;
import gpchile.vadagu.server.dto.Atencion;
import gpchile.vadagu.server.dto.Pauta;
import gpchile.vadagu.server.dto.Sitio;
import gpchile.vadagu.server.dto.Stadistics;
import gpchile.vadagu.server.dto.Vehiculo;
import gpchile.vadagu.server.exception.VDGException;
import gpchile.vadagu.server.util.Configuration;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.PrintWriter;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.net.MulticastSocket;
import java.net.ServerSocket;
import java.net.Socket;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import org.apache.log4j.Logger;

import com.google.gson.Gson;


/**
 *
 * @author rfernandez
 */
public class SocketManager {
    private static final Logger m_logger = Logger.getLogger("Vadagu");
    public static boolean CONTINUE = false;
    public static HashMap<String, PautaManager> pautasList = new HashMap<String, PautaManager>();
    
    private static long lastActivity = 0;
    public final static int port = new Integer(Configuration.getInstance().getProperty("gps.vadagu.server.port"));
    
    public void start2() throws Exception {
    	
        
    	DatagramSocket socketUDP = new DatagramSocket(port);
        while (true) {
        		byte[] bufer = new byte[1000];
        		// Construimos el DatagramPacket para recibir peticiones
        		DatagramPacket peticion =  new DatagramPacket(bufer, bufer.length);
	
        		socketUDP.receive(peticion);
        		String message = new String(bufer);
          
        		System.out.println(message );
          
        }
    }
    
    public void start() throws Exception {
        m_logger.debug("SocketManager:start");
         
        DatagramSocket socketUDP = new DatagramSocket(port);
        try {
            String port = Configuration.getInstance().getProperty("gps.vadagu.server.port");
            //listener = new ServerSocket(new Integer(port));
            
            SocketManager.CONTINUE = true;
            Program.debug("Vadagu init");
            PautaManager.init();
            
            Program.debug("Vadagu read pending ");
            pautasList = PautaManager.loadFromFiles();
            Program.debug("Vadagu pending programming size: " + pautasList.size());
            //loadPendingData();
            Program.debug("Vadagu read pending is OK");
            
            Program.debug("Vadagu service is running in port " + port);
            while (SocketManager.CONTINUE) {
            	byte[] bufer = new byte[1500];
        		DatagramPacket peticion =  new DatagramPacket(bufer, bufer.length);
	
        		socketUDP.receive(peticion);
        		String line = new String(bufer);
                try {
                    int position = line.indexOf(" ");
                    String command = line.substring(0, position);
                    String value = line.substring(position).trim();
                    
                    if(command != null){
	                	switch (command) {
	                    case Program.COMMAND_STOP:
	                    	stop();
	                        break;
	                            
	                    case Program.COMMAND_STATUS:
	                    	status();
	                    	break;
	                           
	                    case Program.COMMAND_ADD_PAUTA:
	                    	addPauta(value);
	                    	break;
	                        	
	                    case Program.COMMAND_ADD_ATENCION:
	                    	addAtencion(value);
	                    	break;
	                        	
	                    case Program.COMMAND_ACTIVITY:
	                    	activity(value);
	                    	break;
	                    }
                    }
                    
                    DatagramPacket respuestaOK =  new DatagramPacket("OK".getBytes(), 2, peticion.getAddress(), peticion.getPort());
                    socketUDP.send(respuestaOK);
                    
                } finally {
                    //socket.close();
                }
            }
        }catch(Exception e){
        	Program.error(e.getMessage(), e);
        }
        finally {
            if(socketUDP != null){
            	socketUDP.close();
            }
        }
    }
    
	private void loadPendingData() throws VDGException {
		try {
			if (StadisticsManager.getInstance().getData().getLastActivity() > 0) {
				String registrosXpagina = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.registrosXpagina");
				
				if (registrosXpagina == null || "".equals(registrosXpagina)) {
					registrosXpagina = "100";
				}
				
				int tamanoPagina = Integer.parseInt(registrosXpagina); //indica la cantidad de registros que debe paginar
				long ultimaActividadActual = Bussines.getLastActivity();
				long diferencia = StadisticsManager.getInstance().getData().getLastActivity() - ultimaActividadActual;
				int paginas = (int) (diferencia / tamanoPagina);

				for (int i = 0; i < paginas; i++) {
					Bussines.getTodasActividadesPendiantes(StadisticsManager.getInstance().getData().getLastActivity(), i, paginas);
				}
			}

		} catch (Exception e) {
			throw new VDGException("Ocurrio un error al leer las pautas penientes", e);
		}
	}
    
    private void status() {
        try{
            m_logger.debug("SocketManager:status");
            
            /*String port = Configuration.getInstance().getProperty("gps.vadagu.server.port");
            SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
            String ountput = "Server is ruuning"+
                             "|Version............: "+ Program.VERSION+
                             "|Inet Address.......: "+ s.getInetAddress()+
                             "|Port...............: "+ port+
                             "|Server Start.......: "+ sdf.format(Program.getDateStart())+
                             "|Pautas List size...: "+ pautasList.size()+
                             ""
                             ;

            PrintWriter out = new PrintWriter(s.getOutputStream(), true);
            out.println(ountput);
            out.flush();*/
        }catch(Exception e){
            m_logger.error("status error", e);
        }
    }
    
    private void stop(){
    	SocketManager.CONTINUE = false;
    }
    
    private void addPauta(String value){
    	PautaManager pautaManager = null;
    	
    	try{
    		pautaManager = new PautaManager(value);
    		
    	}catch(Exception e){
    		m_logger.error("SocketManager:addPauta ERROR, no es posible leer la pauta desde el mensaje:"+value, e);
    		return;
    	}
    	
    	if(pautaManager != null ){
	    	synchronized("pautasList") {
	    		Pauta p = pautaManager.getPauta();
	    		
	    		Vehiculo v = PautaManager.getVehiculoFromRefVehiculo(p.getVehiculo().getCod_RefAcoplado());
	    		if(v == null){
	    			m_logger.error("Se recivio una pauta con un codigo de vehiculo que no existe en elregistro");
	    			return;
	    		}
	    		
	    		PautaManager p2 = pautasList.get(v.getCod_vehiculoAVL2());
	    		
	    		if(p2 != null){
	    			//Si existe una pauta abierta con el cidigo de vehiculo se debe cerrar y luego crear la nueva pauta
	    			p2.end();
	    			pautasList.remove(v.getCod_vehiculoAVL2());
	    			
	    		}
	    		pautaManager.setVehiculo(v); //copleta la informacion del vehiculo
	    		pautaManager.create();
	    			
	    		pautasList.put(v.getCod_vehiculoAVL2(), pautaManager);
	    		if(pautaManager.isReproceso()){
	    			//si es un reproceso esperara 10 minutos y ejecutara 
	    			Reprocesa rp = new Reprocesa();
	    			rp.execute(pautaManager);
	    		}
	    	}
    	}
    }
    
    private void addAtencion(String value){
    	try{
	    	Atencion at = Atencion.fromJSON(value);
	    	
	    	if(at == null){
	    		m_logger.error("SocketManager:addAtencion ERROR, no es posible leer la atencion desde el mensaje:"+value);
	    		return;
	    	}
	    	
	    	//Sitio s = PautaManager.getSitioRefSitio(at.getCodRefPuntoServicio());
	    	ArrayList<Sitio> listSitios = PautaManager.getSitioRefSitio(at.getCodRefPuntoServicio(), at);
	    	
	    	if(listSitios == null || listSitios.size() == 0){
	    		m_logger.error("SocketManager:addAtencion ERROR, el sitio indicado no existe:"+value);
	    		return;
	    	}
	    	
	    	PautaManager pautaManager = getFromRefPauta(at.getCod_refPauta());
	    	if(pautaManager == null){
	    		m_logger.error("SocketManager:addAtencion ERROR, el codigo de referencia no es valido:"+value);
	    		return;
	    	}
    	
	    	pautaManager.addSites(listSitios);
	    	
	    	
    	}catch(Exception e){
    		m_logger.error("SocketManager:Ocurrio un problema al agregar la atencion a la pauta:"+value, e);
    	}
    }
    
	//debe preguntar si el proceso de la pauta esta listo para recibir mensajes, ya que si se realiza un shutdown y luego un initialice
	//estara listo para recibir mensajes hasta que lea completamente las actividades de la base de dato
    private void activity(String value){

    	
    	Actividad actividad =null;
    	
    	try{
    		actividad = Actividad.fromJSON(value);
    		//System.out.println(value);
    		
    	}catch(Exception e){
    		m_logger.error("SocketManager:activity ERROR, no es posible leer la actividad desde el mensaje:"+value, e);
    		return;
    	}
    	
    	//actualizaEstaditicas(actividad);
    	PautaManager pautaManager = pautasList.get(actividad.getCod_vehiculoAVL2());
    	if(pautaManager == null){
    		return;
    	}
    	
    	if(pautaManager != null){
	    	pautaManager.onMessage(actividad);
	    	
	    	if(pautaManager.getPauta().getEstado() == PautaManager.ESTADO_FINALIZADA){
	    		pautasList.remove(actividad.getCod_vehiculoAVL2());
	    	}
    	}
    }


    /*public static void removePauta(PautaManager p){
    	if(p != null && p.getCod_vehiculo() != 0){
	    	synchronized(pautasList) {
	    		PautaManager p2 = pautasList.get(p.getCod_vehiculo());
	    		
	    		if(p2 == null){
	    			pautasList.remove(p.getCod_vehiculo());
	    		}
	    	}
    	}
    }*/


    public static void actualizaEstaditicas(Actividad actividad){
		synchronized("estadisticas") {
			
			try{
				Stadistics data = StadisticsManager.getInstance().getData();
				
				if(data.getLastActivity() < actividad.getNum_actividad()){
					data.setLastActivity(actividad.getNum_actividad());
					StadisticsManager.getInstance().update(data);
				}
			}catch(Exception e){
				m_logger.error("SocketManager:actualizaEstaditicas, no fue posible actualizr las estadisticas", e);
			}
		}
    }


    private PautaManager getFromRefPauta(String refPuta){
    	
        Iterator it = pautasList.entrySet().iterator();
        while (it.hasNext()) {
            Map.Entry pair = (Map.Entry)it.next();
            
            PautaManager p = (PautaManager)pair.getValue();
            if(p.getRefPauta().equals(refPuta)){
            	return p;
            }
        }
    	
    	return null;
    }
    
}
