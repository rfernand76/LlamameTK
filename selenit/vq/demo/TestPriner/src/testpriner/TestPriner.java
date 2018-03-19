/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package testpriner;

import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;

/**
 *
 * @author ricardo
 */
public class TestPriner {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws Exception{
        DatagramSocket socketUDP = new DatagramSocket();

        InetAddress hostServidor = InetAddress.getByName("localhost");
        int puertoServidor = new Integer(2727);

        String writeTo = "hola mundo";
        String command = "print " + writeTo;
        byte[] mensaje = command.getBytes();
        
        DatagramPacket peticion = new DatagramPacket(mensaje, command.length(), hostServidor, puertoServidor);
        socketUDP.send(peticion);
        
        
    }
    
}
