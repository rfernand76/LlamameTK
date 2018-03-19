package gpchile.vadagu.server.figure;

import gpchile.vadagu.server.database.Bussines;
import gpchile.vadagu.server.dto.Point;

import java.io.Serializable;
import java.util.ArrayList;

public class Polygon implements Serializable, Drawing {
	// private Point[] points = null; // Puntos que cotiene e poligono
	private ArrayList<Point> points = new ArrayList<Point>();
	private String poligono;

	public Polygon(String poligono) {
		this.poligono = poligono;

		// Si es de tipo poligono
		if (poligono != null && !poligono.equals("")) {
			String[] p = poligono.split(",");

			for (int i = 0; i < p.length; i = i + 2) {
				Point punto = new Point();
				punto.setLatitud(Double.parseDouble(p[i]));
				punto.setLongitud(Double.parseDouble(p[i + 1]));

				points.add(punto);
			}
		}
	}

	@Override
	public boolean contains(Point test) {
		//return Bussines.inSite(test.getLatitud(), test.getLongitud(), this.poligono);
		int i;
		int j;
		boolean result = false;
		for (i = 0, j = points.size() - 1; i < points.size(); j = i++) {
			if ((points.get(i).getLatitud() > test.getLatitud()) != (points.get(j).getLatitud() > test.getLatitud()) && (test.getLongitud() < (points.get(j).getLongitud() - points.get(i).getLatitud())	* (test.getLatitud() - points.get(i).getLatitud()) / (points.get(j).getLongitud() - points.get(i).getLatitud()) + points.get(i).getLongitud())) {
				result = !result;
			}
		}
		return result;
	}

}
