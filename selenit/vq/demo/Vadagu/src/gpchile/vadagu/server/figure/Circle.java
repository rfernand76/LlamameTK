package gpchile.vadagu.server.figure;

import gpchile.vadagu.server.database.Bussines;
import gpchile.vadagu.server.dto.Point;

import java.awt.geom.Ellipse2D;
import java.io.Serializable;

public class Circle implements Serializable, Drawing{
	private float radio;
	private Point cordenadas;
	
	public Circle(float radio, Point cordenadas){
		this.radio = radio;
		this.cordenadas = cordenadas;
	}
	
	
	@Override
	public boolean contains(Point test) {
		//return liesInCircle(test.getLatitud(), test.getLongitud(), cordenadas.getLatitud(), cordenadas.getLongitud(), radio);
		//return liesInCircle(cordenadas.getLatitud(), cordenadas.getLatitud(), test.getLongitud(), test.getLatitud(), radio);
		
		//return distancia(test);
		return Bussines.inCircle(test.getLatitud(), test.getLongitud(), cordenadas.getLatitud(), cordenadas.getLongitud(), this.radio);
	}
	
	public static boolean liesInCircle(double x, double y, double cX, double cY, double r)
	{
	   double dx = x - cX;
	   double dy = y - cY;
	   return dx * dx + dy * dy <= r * r;
	} 
	
    public boolean distancia(Point p2){
    	//return Math.sqrt(Math.pow(p2.x-this.x,2) + Math.pow(p2.y-this.y,2));
    	Double distancia = Math.sqrt(Math.pow(p2.getLatitud()-cordenadas.getLatitud(),radio) + Math.pow(p2.getLongitud() -cordenadas.getLongitud(),radio));
    	
    	return distancia > radio;
    }
}
