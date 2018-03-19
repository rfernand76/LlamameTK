/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package observador;

import java.io.DataOutputStream;
import java.io.ObjectInputStream;
import java.io.OutputStream;
import java.net.Socket;

/**
 *
 * @author selenit
 */
public class Observador {

    /**
     * @param args the command line arguments
     */
    
    public final static int COMMAND_OBSERVER = 50;
    public static void main(String[] args) throws Exception{
        String fila = "CL.SEL.01.A";
        Socket socket = new Socket("localhost", 10008);

        OutputStream out = socket.getOutputStream();
        DataOutputStream data = new DataOutputStream(out);

        data.writeInt(COMMAND_OBSERVER);
        data.writeUTF(fila);
        data.writeInt(5);

        out.flush();

        int responce = 0;
        boolean continuar = true;
        int i = 0;
        while( continuar ){
            ObjectInputStream ois = new ObjectInputStream(socket.getInputStream());
            responce = ois.readInt();
            System.out.println(responce);
            
            if(i == 3){
                continuar = false;
            }
            i++;
            
        }
    }
    
}
