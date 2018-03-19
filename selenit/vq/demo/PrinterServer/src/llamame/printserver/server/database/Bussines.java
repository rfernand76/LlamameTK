package llamame.printserver.server.database;

import llamame.printserver.server.util.Configuration;

import java.sql.*;

import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;

public class Bussines {

    private static Bussines instance = null;
    private static final Logger m_logger = Logger.getLogger("printServer");

    private Bussines() {

    }

    public static Bussines getInstance() {
        if (instance == null) {
            PropertyConfigurator.configure("log4j.properties");
            instance = new Bussines();
        }

        return instance;
    }

    public static int getGmt() {
        return Integer.parseInt(Configuration.getInstance().getProperty("llamame.PrintServer.gmt.zone"));
    }


}
