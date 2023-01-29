package simulator.control;


import org.json.JSONArray;
import org.json.JSONObject;

import simulator.misc.Vector2D;

public class EpsilonEqualStates implements StateComparator{

	private double eps;
	
	public EpsilonEqualStates(double eps) {
		this.eps = eps;
	}
	
	public boolean equal(JSONObject s1, JSONObject s2) {
				
	
		if(s1.getDouble("time") != s2.getDouble("time"))
		{
			return false;
		}
		
			
		JSONArray ja1 = s1.getJSONArray("bodies");//lista de json (bodies) del primer estado a comparar
		JSONArray ja2 = s2.getJSONArray("bodies");//lista de json (bodies) del segundo estado a comparar
		
		//no se si se puede dar el caso de ditintas longitudes pero se pone por si acaso
		if(ja1.length() != ja2.length())
		{
			return false;
		}
		
		for (int i = 0; i < ja1.length(); i++) {
			JSONObject b1;
			JSONObject b2;
			
			b1 = ja1.getJSONObject(i);//body i-esimo de la lista 1
			b2 = ja2.getJSONObject(i);//body i-esimo de la lista2
			
			//si no coinciden sus ids se devuelve false
			if(!(b1.getString("id").equals(b2.getString("id"))))
				{
					return false;
				}
			//comparamos masa//TODO revisar 
			if(!equalDoubleModEps(b1.getDouble("m"), b2.getDouble("m")))
			{
				return false;
			}
			
			//leyendo el JSON leemos el arrayJSON de los vectores, y formamos los vectores posicion, velocidad y fuerza de ambos estados para poder compararlos
			
			Vector2D b1Pos = new Vector2D(b1.getJSONArray("p").getDouble(0), b1.getJSONArray("p").getDouble(1));
			Vector2D b2Pos = new Vector2D(b2.getJSONArray("p").getDouble(0), b2.getJSONArray("p").getDouble(1));
			Vector2D b1Vel = new Vector2D(b1.getJSONArray("v").getDouble(0), b1.getJSONArray("v").getDouble(1));
			Vector2D b2Vel = new Vector2D(b2.getJSONArray("v").getDouble(0), b2.getJSONArray("v").getDouble(1));
			Vector2D b1For = new Vector2D(b1.getJSONArray("f").getDouble(0), b1.getJSONArray("f").getDouble(1));
			Vector2D b2For = new Vector2D(b2.getJSONArray("f").getDouble(0), b2.getJSONArray("f").getDouble(1));
			
			if(!equalVectorModEps(b1Pos, b2Pos) || !equalVectorModEps(b1Vel, b2Vel) || !equalVectorModEps(b1For, b2For) ) {		
				return false;
			}	
		
		}
		
		return true;
	}
	
	
	boolean equalDoubleModEps(double v1, double v2)
	{
		return Math.abs(v1-v2) <= eps;
	}
	
	boolean equalVectorModEps(Vector2D v1, Vector2D v2)
	{
		return v1.distanceTo(v2) <= eps;
	}
	
	//para testeos
	public String toString()
	{
		return Double.toString(eps);
	}
	
	
}
