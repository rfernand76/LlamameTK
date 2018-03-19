/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package llamame.printserver.client;

import org.apache.log4j.PropertyConfigurator;
import org.apache.log4j.Logger;

import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.Calendar;
import java.util.Date;

/**
 *
 * @author ricardo
 */
public class PrinterClient {

    /**
     * @param args the command line arguments
     */
    private static final Logger m_logger = Logger.getLogger("LLamamePrintManagement");
    
    public static void main(String[] args) throws Exception {
        PropertyConfigurator.configure("log4j.properties");
        
        while(true){
            
            try{
                DatagramSocket socketUDP = new DatagramSocket();

                InetAddress hostServidor = InetAddress.getByName("localhost");
                int puertoServidor = new Integer(2727);

                String writeTo = "usuario/password";
                String command = "connect " + writeTo;
                byte[] mensaje = command.getBytes();

                DatagramPacket peticion = new DatagramPacket(mensaje, command.length(), hostServidor, puertoServidor);
                socketUDP.send(peticion);

                byte[] bufer = new byte[10];
                DatagramPacket respuesta = new DatagramPacket(bufer, bufer.length);
                socketUDP.receive(respuesta);

                System.out.println(respuesta);
            }catch(Exception e){
                
            }
        }
        
        //byte[] bufer = new byte[10];
        //DatagramPacket respuesta = new DatagramPacket(bufer, bufer.length);
        //socketUDP.receive(respuesta);
    }
    
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
}
