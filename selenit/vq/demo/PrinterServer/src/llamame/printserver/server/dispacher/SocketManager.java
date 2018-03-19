package llamame.printserver.server.dispacher;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.PrintStream;
import llamame.printserver.server.util.Configuration;

import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.ServerSocket;
import java.util.HashMap;

import org.apache.log4j.Logger;

/**
 *
 * @author rfernandez
 */
public class SocketManager {
    
    private static final Logger m_logger = Logger.getLogger("PrintServer");
    public static boolean CONTINUE = false;
    
    private HashMap<String,  DatagramSocket> socketList = new HashMap<String,  DatagramSocket>();

    private final static String strPort  = Configuration.getInstance().getProperty("llamame.PrintServer.server.port");
    private final static int thePort = new Integer(strPort);
    
    public void start() throws Exception {
        m_logger.debug("SocketManager:start");

        ServerSocket serverSocket = new ServerSocket(thePort);
        Socket clientSocket;
        try {

            SocketManager.CONTINUE = true;
            Program.debug("PrintServer init");

            Program.debug("PrintServer service is running in port " + thePort);
            while (SocketManager.CONTINUE) {
                clientSocket = serverSocket.accept();
                BufferedReader input = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
                PrintStream output = new PrintStream(clientSocket.getOutputStream());
                
                String line = input.readLine();
                try {
                    int position = line.indexOf(" ");
                    String command = line.substring(0, position);
                    String value = line.substring(position).trim();

                    if (command != null) {
                        switch (command) {
                            case Program.COMMAND_CONNECT:
                                //connect(value, socketUDP);
                                break;
                                
                            case Program.COMMAND_PRINT:
                                print(value);
                                break;
                        }
                    }

                } finally {
                    //socket.close();
                }
            }
        } catch (Exception e) {
            Program.error(e.getMessage(), e);
        } finally {
            if (clientSocket != null) {
                clientSocket.close();
            }
        }
    }
    
    private void connect(String line, DatagramSocket socketUDP){
        String usuario = "local";
        
        if(socketList.size() > 0){
            disconnect(usuario);
        }
        
        socketList.put(usuario, socketUDP);

    }
    
    private void disconnect(String usuario){
        try{
            socketList.get(usuario).close();
        }catch(Exception e){
            
        }
        
        socketList.clear();
    }
    
    private void print(String mensaje) throws Exception{
        String usuario = "local";
        DatagramSocket socketUDP = socketList.get(usuario);
        DatagramPacket peticion = new DatagramPacket(mensaje.getBytes(), mensaje.length());
        
        DatagramPacket respuestaOK = new DatagramPacket("OK".getBytes(), 2, peticion.getAddress(), peticion.getPort());
        socketUDP.send(respuestaOK);
        
    }

    

}
