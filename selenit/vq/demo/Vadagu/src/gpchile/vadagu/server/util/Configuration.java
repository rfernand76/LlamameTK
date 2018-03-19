package gpchile.vadagu.server.util;

import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.util.Date;
import java.util.Properties;
import org.apache.log4j.Logger;

/**
 *
 * @author rfernandez
 */
public final class Configuration {
    private static final Logger m_logger = Logger.getLogger("vadagu");
    private static Configuration instance = null;
    private static final String configurationFie = "config.properties";
    
    private final File f = new File(configurationFie);
    private Date dateLoad = null;
    private final Properties prop = new Properties();
    
    private Configuration(){
        load();
    }
    
    private void load(){
        try {
            final InputStream input = new FileInputStream(f);
            prop.load(input); 
            dateLoad = new Date();
            input.close();
            
        } catch (Exception e) {
        	System.out.println("An error occurred while reading the properties file " + f.getAbsolutePath());
        	e.printStackTrace();
            m_logger.error("An error occurred while reading the properties file " + f.getAbsolutePath(), e);
        }
    }
    
    public Date getModifiedDate(){
        return new Date(f.lastModified());
    }
    
    public static Configuration getInstance(){
        if(instance == null){
            instance = new Configuration();
        }else{
            if(instance.getModifiedDate().compareTo(instance.dateLoad)>0){
                instance.load();
            }
        }
        return instance;
    }
    
    public String getProperty(String key){
        return prop.getProperty(key);
    }
}