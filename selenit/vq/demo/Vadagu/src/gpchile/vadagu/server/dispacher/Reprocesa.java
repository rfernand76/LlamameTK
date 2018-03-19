package gpchile.vadagu.server.dispacher;

import gpchile.vadagu.server.util.Configuration;

import org.apache.log4j.Logger;

public class Reprocesa implements Runnable{
	private static final Logger m_logger = Logger.getLogger("Vadagu");
	
	private PautaManager pm = null;
	
    public void execute(PautaManager pautaManager){
    	this.pm = pautaManager;
    	
    	Thread th = new Thread(this);
    	th.start();
    }
	
    
	@Override
	public void run() {

		try{
	    	String reprocesoTime = Configuration.getInstance().getProperty("gps.vadagu.reproceso.time"); //minutos que debe esperar
			int sleep = Integer.parseInt(reprocesoTime)*1000;
			
			Thread.sleep(sleep);
			m_logger.debug("Tiempo de espera transcurrido, se ejecuta lectura de actividades para el reproceso de la pauta");
			pm.reprocesa();
			
		}catch(Exception e){
			m_logger.error("Ocurrio un un error ejecutar el reproceso", e);
		}
	}
}
