package gpchile.vadagu.server.dispacher;

import gpchile.vadagu.server.dto.Stadistics;
import gpchile.vadagu.server.util.Configuration;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;

import org.apache.log4j.Logger;

import com.google.gson.Gson;

public class StadisticsManager {
	private static StadisticsManager instance = null;
	
	private static String stadisticsFile = "";
	private static File file = null;
	BufferedWriter bw = null;
	
	private static Stadistics data = null;
	
	private static final Logger m_logger = Logger.getLogger("Vadagu");
	
	public static StadisticsManager getInstance() throws Exception{
		if(instance ==null){
			instance = new StadisticsManager();
		}
		
		return instance;
	}
	
	private StadisticsManager() throws Exception{
		stadisticsFile = Configuration.getInstance().getProperty("gps.vadagu.persist.path.stadistics");
		file = new File(stadisticsFile);
		
		if(file.isFile()){
			data = (Stadistics)Program.readObjectFromFile(file, Stadistics.class);
			bw = new BufferedWriter(new FileWriter(file));
		}else{
			data = new Stadistics();
		}
	}
	
	public Stadistics getData(){
		return data;
	}
	
	public void update(Stadistics data){
		this.data = data;
		
		try{
	    	
	    	Gson gson = new Gson();
	    	String writeTo = gson.toJson(data);
	    	
	    	if(bw == null){
	    		bw = new BufferedWriter(new FileWriter(file));
	    	}
	    	
	    	bw.write(writeTo);
	    	bw.flush();
	    	
		}catch(Exception e){
			m_logger.error("Ocurrio un problema al grabar las estadisticas", e);
		} finally {

		}
	}
}
