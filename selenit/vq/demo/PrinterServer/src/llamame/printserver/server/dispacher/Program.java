package llamame.printserver.server.dispacher;

import org.apache.log4j.PropertyConfigurator;
import org.apache.log4j.Logger;

import com.google.gson.Gson;

import llamame.printserver.server.util.Configuration;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.io.PrintWriter;
import java.net.ConnectException;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Calendar;
import java.util.Date;


public class Program {
    public static final String COMMAND_START = "start";
    public static final String COMMAND_STOP = "stop";
    public static final String COMMAND_STATUS = "status";
    public static final String COMMAND_CONNECT = "connect";
    public static final String COMMAND_PRINT = "print";

    
    private static final Logger m_logger = Logger.getLogger("PrintServer");
    public static final String VERSION = "1.0";
    private static Date dateStart = null;
    
    public static void main(String [ ] args){
        PropertyConfigurator.configure("log4j.properties");
        
        if (args.length < 1) {
        	m_logger.debug("You must specify a command");
            return;
        }

        final String command = args[0];
        m_logger.debug("Command:" + command);
        switch (command) {
            case COMMAND_START:
		start(args);
                break;
            case COMMAND_STOP:
                stop(args);
                break;
            case COMMAND_STATUS:
                status(args);
                break;
            default:
            	m_logger.debug("Command [" + command + "] is not valid");
                break;
        }

        m_logger.debug("main:end");
    }

    public static void start(String[] args){
        SocketManager socket = new SocketManager();
        
        dateStart = new Date();
        try {
            socket.start();
	} catch (Exception e) {
            m_logger.debug("Start Problems: IOException: "+e.getMessage());
	}
        
        debug("Server is stop");
    }

    public static void stop(String[] args){
    	final String host = Configuration.getInstance().getProperty("llamame.PrintServer.server.host");
    	final String port = Configuration.getInstance().getProperty("llamame.PrintServer.server.port");
        
    	debug("stopping server "+host+":"+port);
    	Socket s = null;
    	
        try{
            for(int i=0; i<2; i++){
            try{
                s = new Socket(host, new Integer(port));
		final PrintWriter out = new PrintWriter(s.getOutputStream(), true);
		out.println(COMMAND_STOP);
		out.flush();
            }catch(Exception ee){
		if(i==0){
                    ee.printStackTrace();
                    return;
		}
            }
				
            Program.sleep(3000);
            if (s != null) {
		s.close();
            }
	}
			
	debug("Command stop is success");    
        }catch(ConnectException e){
        	debug("server ConnectException: "+host+":"+port);
        } catch (NumberFormatException e) {
            debug("server NumberFormatException: "+host+":"+port);
	} catch (UnknownHostException e) {
            debug("server UnknownHostException: "+host+":"+port);
	} catch (IOException e) {
            debug("server IOException: "+host+":"+port);
	}finally{
            try{s.close();}catch(Exception ee){}
	}
    }
    
    // este metodo estatico realiza la espera en intervalosde 1 segudo, la idea
    // es que si un se realiza el stop, el sleep termine
    // para que se pueda ejecutar el comando correctamente
    static public void sleep(long espera) {
        try {
            Date timeInitial = Calendar.getInstance().getTime();
            Date timeDuration = new Date(timeInitial.getTime() + espera);
            long sleep = 0;
            int intervalo = 1000; // un segundo

            boolean continua = true;
            Date timeCurrent;
            while (continua) {
                timeCurrent = Calendar.getInstance().getTime();
                if (timeCurrent.getTime() + intervalo > timeDuration.getTime()) {
                    sleep = timeDuration.getTime() - timeCurrent.getTime();

                    if(sleep > 0){
                        Thread.sleep(sleep);
                    }


                    continua = false;
                } else {
                    sleep = intervalo;
                    Thread.sleep(sleep);
                }
            }

        } catch (InterruptedException e) {
        m_logger.error("Thread sleep error", e);
        }
    }

    static public void debug(String mensaje){
        m_logger.debug(mensaje);
        System.out.println(mensaje);
    }

    static public void error(String mensaje, Throwable e){
        m_logger.error(mensaje, e);
        System.out.println(mensaje);
        e.printStackTrace();
    }

    public static void println(String str){
            final PrintStream p = System.out;
            if(p != null){
                    p.println(str);
            }
    }
	
    static public void sleep(String strEspera) {
	long espera = Long.parseLong(strEspera);
        sleep(espera);
    }
    
    public static void status(String[] args){
        final String host = Configuration.getInstance().getProperty("llamame.PrintServer.server.host");
        final String port = Configuration.getInstance().getProperty("llamame.PrintServer.server.port");
        
        debug("status server "+host+":"+port);
        try{
            final Socket s = new Socket(host, new Integer(port));
            final PrintWriter out = new PrintWriter(s.getOutputStream(), true);
            out.println(COMMAND_STATUS);
            
            final BufferedReader in = new BufferedReader(new InputStreamReader(s.getInputStream()));
            String respuesta = in.readLine();
            if(respuesta != null){
                respuesta = respuesta.replace("|", "\n");
                debug(respuesta);
            }else{
            	debug("Server not responding");
            }
            
            if(s != null){
            	s.close();
            }
            
            
        }catch(Exception e){
        	error("server "+host+":"+port + " is not running", e);
		}
    }
    
    static public Date getDateStart(){
    	return dateStart;
    }
    
    static public String readFile(String file) throws IOException{
    	File f = new File(file);
    	return readFile(f);
    }
    
    
    static public String readFile(File file) throws IOException{
    	BufferedReader br = new BufferedReader(new FileReader(file));
		String sCurrentLine = "";

		try {
			while ((sCurrentLine = br.readLine()) != null) {
				System.out.println(sCurrentLine);
			}
		} catch (IOException e) {
			throw e;
		}finally{
			br.close();
		}
		
		return sCurrentLine;
    }
    
    static Object readObjectFromFile(File file, Class c){
    	Object o = null;
    	try{
	    	String str = readFile(file);
	    	
	    	Gson gson = new Gson();
	    	o = gson.fromJson(str, c);
	    	
    	}catch(Exception e){
    		try{
    			o = c.newInstance();
    			
    		}catch(Exception ee){
    			
    		}
    	}
    	
    	return o;
    }
}
