package gpchile.vadagu.server.database;

import gpchile.vadagu.server.dispacher.PautaManager;
import gpchile.vadagu.server.dispacher.SocketManager;
import gpchile.vadagu.server.dto.Actividad;
import gpchile.vadagu.server.dto.Pauta;
import gpchile.vadagu.server.dto.Point;
import gpchile.vadagu.server.dto.Sitio;
import gpchile.vadagu.server.dto.Vehiculo;
import gpchile.vadagu.server.exception.VDGException;
import gpchile.vadagu.server.figure.Circle;
import gpchile.vadagu.server.figure.Drawing;
import gpchile.vadagu.server.figure.Polygon;
import gpchile.vadagu.server.util.Configuration;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.sql.*;

import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;

public class Bussines {
	private static Bussines instance = null;
	private static final Logger m_logger = Logger.getLogger("Vadagu");
	private static final String path_sitios = Configuration.getInstance().getProperty("gps.vadagu.sitios.path");
	private static final String path_vehiculos = Configuration.getInstance().getProperty("gps.vadagu.vehiculos.path");
	
	private static Connection connIcapi = null;
	
	private Bussines(){
		
	}
	
	public static Bussines getInstance(){
		if(instance == null){
			PropertyConfigurator.configure("log4j.properties");
			instance = new Bussines();
		}
		
		return instance;
	}
	
	
	
	public static HashMap<String, Vehiculo> getVehiculos() throws VDGException{
		m_logger.debug("Bussines.getVehiculos start");
		
		HashMap<String, Vehiculo> vehiculos = new HashMap<String, Vehiculo>();
		Connection conn = null;
		ResultSet rs = null;
		Statement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.database.url");
		final String sql = Configuration.getInstance().getProperty("gps.vadagu.vehiculos.sql");

        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
        	
            conn = DriverManager.getConnection(database_url,
            		                           Configuration.getInstance().getProperty("gps.vadagu.database.user"),
            		                           Configuration.getInstance().getProperty("gps.vadagu.database.password")
            		                          );
            stmt = conn.createStatement();
            
 
            rs = stmt.executeQuery(sql);
            while ( rs.next() ) {
            	Vehiculo vehiculo = new Vehiculo();
            	vehiculo.setCod_RefAcoplado(rs.getString("cod_RefAcoplado"));
            	vehiculo.setCod_vehiculoAVL2(rs.getString("cod_VehiculoAVL2"));
            	vehiculo.setCod_vehiculo(rs.getInt("cod_Vehiculo"));
            	vehiculo.setRego(rs.getString("rego"));
            	vehiculo.setRefVehiculo(rs.getString("refVehiculo"));
            	
            	vehiculos.put(vehiculo.getCod_vehiculoAVL2(), vehiculo);
            }
            
            save(path_vehiculos, vehiculos);
            
        } catch (Exception e) {
        	m_logger.error("No se puede obtener la lista de sitios desde la base de datos, se obtiene de respaldo local ", e);
        	
        	
        	try{
        		vehiculos = (HashMap<String, Vehiculo>)load(path_vehiculos);
        	}catch(Exception ee){
        		throw new VDGException("No es posible continuar con el servicio, ya que el respaldo de sitios no esta disponible", ee);
        	}
        	
        	
        }finally{
        	try{rs.close();}catch(Exception e){}
        	try{stmt.close();}catch(Exception e){}
        	try{conn.close();}catch(Exception e){}
        	
        }
		m_logger.debug("Bussines.getVehiculos end");
		return vehiculos;
	}
	
	public static HashMap<Integer, Sitio> getSitios() throws VDGException{
		m_logger.debug("Bussines.getSitios start");
		
		HashMap<Integer, Sitio> sitios = new HashMap<Integer, Sitio>();
		Connection conn = null;
		ResultSet rs = null;
		Statement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.database.url");
		final String sql = Configuration.getInstance().getProperty("gps.vadagu.sitios.sql");

        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
        	 
            conn = DriverManager.getConnection(database_url,
            		                           Configuration.getInstance().getProperty("gps.vadagu.database.user"),
            		                           Configuration.getInstance().getProperty("gps.vadagu.database.password")
            		                          );
            stmt = conn.createStatement();
            
 
            rs = stmt.executeQuery(sql);
            while ( rs.next() ) {
            	Sitio sitio = new Sitio();
            	sitio.setCod_SitioCliente(rs.getInt("Cod_SitioCliente"));
            	sitio.setPoligono(rs.getString("Poligono"));
            	sitio.setCod_RefSitioCliente(rs.getString("Cod_RefSitioCliente"));
            	sitio.setEventoFinAtencion(rs.getString("EventoInicioAtencion"));
            	sitio.setRadio(rs.getFloat("Radio"));
            	
            	Drawing poly = null;
            	if(sitio.getRadio() == 0){
            		poly = new Polygon(sitio.getPoligono());
            	}else{
            		Point cordenadas = new Point();
            		cordenadas.setLatitud(rs.getDouble("Latitud"));
            		cordenadas.setLongitud(rs.getDouble("Longitud"));
            		poly = new Circle(sitio.getRadio(),cordenadas);
            	}
            	sitio.setPoligonoObject(poly);
            	
            	sitios.put(sitio.getCod_SitioCliente(), sitio);
            }
            
            save(path_sitios, sitios);
            
        } catch (Exception e) {
        	m_logger.error("No se puede obtener la lista de sitios desde la base de datos, se obtiene de respaldo local ", e);
        	
        	
        	try{
        		sitios = (HashMap<Integer, Sitio>)load(path_sitios);
        	}catch(Exception ee){
        		throw new VDGException("No es posible continuar con el servicio, ya que el respaldo de sitios no esta disponible", ee);
        	}
        	
        	
        }finally{
        	try{rs.close();}catch(Exception e){}
        	try{stmt.close();}catch(Exception e){}
        	try{conn.close();}catch(Exception e){}
        	
        }
		
        m_logger.debug("Bussines.getSitios end");
        return sitios;
	}
	
	public static void getTodasActividadesPendiantes(long ultimActividad, int inicio, int paginas){
		m_logger.debug("Bussines.getActividad start");
		
		ResultSet rs = null;
		PreparedStatement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.icapi.url");
		final String sql = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.getTodasActividadesPendiantes");
		String registrosXpagina = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.registrosXpagina");
		
		if(registrosXpagina == null || "".equals(registrosXpagina)){
			registrosXpagina = "100";
		}

        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");

        	m_logger.debug("sql:"+sql);
            m_logger.debug("---------------------");
            m_logger.debug("ultimActividad:"+ ultimActividad);
            m_logger.debug("inicio:"+ inicio);
            m_logger.debug("paginas:"+ paginas);
            
            //</solo>
            
            if(connIcapi == null){
	            connIcapi = DriverManager.getConnection(database_url,
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.user"),
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.password")
	            		);
            }
            

            stmt = connIcapi.prepareStatement(sql);
            stmt.setLong(1, ultimActividad);
            stmt.setInt(2, inicio);
            stmt.setInt(3, paginas);

            rs = stmt.executeQuery();
            while ( rs.next() ) {
            	Actividad actividad = new Actividad();
            	
            	actividad.setNum_actividad(rs.getLong("Num_actividad"));
            	actividad.setCod_tipoEvento(rs.getInt("Cod_tipoEvento"));
            	actividad.setFechaHoraActividad(new Date(rs.getDate("FechaHoraActividad").getTime()));
            	actividad.setIgnicion(rs.getInt("Ignicion"));
            	actividad.setLatitud(rs.getDouble("Latitud"));
            	actividad.setLongitud(rs.getDouble("Longitud"));
            	
            	PautaManager pautaManager = SocketManager.pautasList.get(actividad.getCod_vehiculoAVL2());
            	if(pautaManager != null){
            		pautaManager.onMessage(actividad);
            	}
            }
            
        } catch (Exception e) {
        	m_logger.error("No se puede obtener la lista de actividades", e);

        }finally{
        	try{rs.close();}catch(Exception e){}
        	try{stmt.close();}catch(Exception e){}
        	//try{connIcapi.close();}catch(Exception e){}
        	
        }
		
        m_logger.debug("Bussines.getActividad end");
		

	}
	
	public static ArrayList<Actividad> getActividadesPendiantes(Pauta pauta, long ultimActividad, int inicio){
		m_logger.debug("Bussines.getActividad start");
		
		ArrayList<Actividad> actividadesList = new ArrayList<Actividad>();
		
		ResultSet rs = null;
		PreparedStatement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.icapi.url");
		final String sql = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.getActividadesPendiantes");
		String registrosXpagina = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.registrosXpagina");
		
		if(registrosXpagina == null || "".equals(registrosXpagina)){
			registrosXpagina = "100";
		}

        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
        	 
            int tamanoPagina = Integer.parseInt(registrosXpagina);	//indica la cantidad de registros que debe paginar
            long gmt = PautaManager.gmt * 3600000; 			//indica ladiferencia que debe ejecutar en el servidor ICAPI para hacer la conversion a hora chilena
            long fin = Integer.parseInt(Configuration.getInstance().getProperty("gps.vadagu.analisis.duracion.time"))*(1000*3600);
            
            Date fechaInicio = new Date(pauta.getInicio().getTime()-gmt);
            Date fechaFin = new Date(fechaInicio.getTime()+fin);
            
            //<solo> para debug, de debe borrar
            java.sql.Date sqlDate = new java.sql.Date(fechaInicio.getTime());
            java.sql.Date sqlDateFin = new java.sql.Date(fechaFin.getTime());
            SimpleDateFormat utilDate = new SimpleDateFormat("yyyy/MM/dd hh:mm:ss");
            
            m_logger.debug("sql:"+sql);
            m_logger.debug("Fecha de creacion["+utilDate.format(pauta.getInicio()));
            m_logger.debug("---------------------");
            m_logger.debug("getCod_vehiculoAVL2:"+ pauta.getVehiculo().getCod_vehiculoAVL2());
            m_logger.debug("ultimActividad:"+ ultimActividad);
            m_logger.debug("sqlDate:"+ utilDate.format(sqlDate));
            m_logger.debug("sqlDateFin:"+ utilDate.format(sqlDateFin));
            m_logger.debug("inicio:"+ inicio);
            m_logger.debug("tamanoPagina:"+ tamanoPagina);
            
            //</solo>
            
            if(connIcapi == null){
	            connIcapi = DriverManager.getConnection(database_url,
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.user"),
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.password")
	            		);
	            
            }
            
            stmt = connIcapi.prepareStatement(sql);
            stmt.setString(1, pauta.getVehiculo().getCod_vehiculoAVL2());
            stmt.setLong(2, ultimActividad);
            stmt.setDate(3, sqlDate);
            stmt.setDate(4, sqlDateFin);
            stmt.setInt(5, inicio);
            stmt.setInt(6, tamanoPagina);

            rs = stmt.executeQuery();
            while ( rs.next() ) {
            	Actividad actividad = new Actividad();
            	
            	actividad.setNum_actividad(rs.getLong("Num_actividad"));
            	actividad.setCod_tipoEvento(rs.getInt("Cod_tipoEvento"));
            	actividad.setFechaHoraActividad(new Date(rs.getDate("FechaHoraActividad").getTime()));
            	actividad.setIgnicion(rs.getInt("Ignicion"));
            	actividad.setLatitud(rs.getDouble("Latitud"));
            	actividad.setLongitud(rs.getDouble("Longitud"));
            	
            	actividadesList.add(actividad);
            }
            
        } catch (Exception e) {
        	m_logger.error("No se puede obtener la lista de actividades para el vehiculo " + pauta.getVehiculo().getCod_vehiculoAVL2() + " (referecia"+ pauta.getVehiculo().getCod_RefAcoplado() +")", e);

        }finally{
        	try{rs.close();}catch(Exception e){}
        	try{stmt.close();}catch(Exception e){}
        	//try{connIcapi.close();}catch(Exception e){}
        	
        }
		
        m_logger.debug("Bussines.getActividad end");
		
		return actividadesList;
	}
	
	public static long getLastActivity() throws VDGException{
		m_logger.debug("Bussines.getLastActivity start");
		
		long lastActivity = 0;
		
		ResultSet rs = null;
		PreparedStatement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.icapi.url");
		final String sql = Configuration.getInstance().getProperty("gps.vadagu.icapi.aql.pendingCount");
		
        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
           
            if(connIcapi == null){
	            connIcapi = DriverManager.getConnection(database_url,
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.user"),
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.password")
	            		);
            }
            
            stmt = connIcapi.prepareStatement(sql);

            rs = stmt.executeQuery();
            if(rs.next()){
            	lastActivity = rs.getLong("c");
            }
            
        } catch (Exception e) {
        	m_logger.error("La utima actividad actual", e);
        	throw new VDGException("La utima actividad actual", e);
        	

        }finally{
        	try{rs.close();}catch(Exception e){}
        	try{stmt.close();}catch(Exception e){}      	
        }
		
        m_logger.debug("Bussines.getLastActivity end");
		
		return lastActivity;
	}
	
	public static int getGmt(){
		return Integer.parseInt(Configuration.getInstance().getProperty("gps.vadagu.gmt.zone"));
	}
	
	public static void save(String fileName, Object obj){
		FileOutputStream fout = null;
		ObjectOutputStream oos = null;
		
		try{
			fout = new FileOutputStream(fileName);
			oos = new ObjectOutputStream(fout);
			
			oos.writeObject(obj);
		}catch(Exception e){
			
		} finally {
			try{fout.close();}catch(Exception e){}
			try{oos.close();}catch(Exception e){}
		}
	}
	
	public static Object load(String fileName) throws VDGException{
		FileInputStream fout = null;
		ObjectInputStream oos = null;
		
		try{
			fout = new FileInputStream(fileName);
			oos = new ObjectInputStream(fout);
			Object ret = oos.readObject();
			return ret;

		}catch(Exception e){
			m_logger.error("No se pudo cargar la pauta: "+fileName, e);
			throw new VDGException("No es posible leer el archivo indicado", e);
		} finally {
			try{fout.close();}catch(Exception e){}
			try{oos.close();}catch(Exception e){}
		}
		
	}
	
	public static boolean inSite(double latitud, double longitud,  String sitio) {
		boolean ret = false;
	
		ResultSet rs = null;
		PreparedStatement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.icapi.url");
		final String sql = "select INTEGRACION.dbo.FNC_QRY_COORDENADAENPOLIGONO(?, ?, ?)";
		
        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
           
            if(connIcapi == null){
	            connIcapi = DriverManager.getConnection(database_url,
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.user"),
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.password")
	            		);
            }
            
            stmt = connIcapi.prepareStatement(sql);
            stmt.setDouble(1, latitud);
            stmt.setDouble(2, longitud);
            stmt.setString(3, sitio);

            rs = stmt.executeQuery();
            if(rs.next() ) {
            	int is = rs.getInt(1);
            	ret = is == 1;
            }else{
            	m_logger.error("No se pudo determinar si el punto pertenece al sitio - El procedimiento no retorno filas");
            }
            
        }catch(Exception e){
        	m_logger.error("No se pudo determinar si el punto pertenece al sitio", e);
        }finally{
        	try{stmt.close();}catch(Exception ee){};
        	try{rs.close();}catch(Exception ee){};
        }
		
		return ret;
	}
	
	
	public static boolean inCircle(double latatudCoordenada, double longitudCoordenada, double latitudPunto, double longitudPunto,  double radio) {
		boolean ret = false;
	
		ResultSet rs = null;
		PreparedStatement stmt = null;
		
		final String database_url = Configuration.getInstance().getProperty("gps.vadagu.icapi.url");
		final String sql = "select INTEGRACION.dbo.FNC_QRY_COORDENADAENCIRCULO(?, ?, ?, ?, ?)";
		
        try {
        	Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
           
            if(connIcapi == null){
	            connIcapi = DriverManager.getConnection(database_url,
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.user"),
	            		    Configuration.getInstance().getProperty("gps.vadagu.icapi.password")
	            		);
            }
            
            stmt = connIcapi.prepareStatement(sql);
            stmt.setDouble(1, latatudCoordenada);
            stmt.setDouble(2, longitudCoordenada);
            stmt.setDouble(3, latitudPunto);
            stmt.setDouble(4, longitudPunto);
            stmt.setDouble(5, radio);

            rs = stmt.executeQuery();
            if(rs.next() ) {
            	int is = rs.getInt(1);
            	ret = is == 1;
            }else{
            	m_logger.error("No se pudo determinar si el punto pertenece al sitio - El procedimiento no retorno filas");
            }
            
        }catch(Exception e){
        	m_logger.error("No se pudo determinar si el punto pertenece al sitio", e);
        }finally{
        	try{stmt.close();}catch(Exception ee){};
        	try{rs.close();}catch(Exception ee){};
        }
		
		return ret;
	}
	
	

}
