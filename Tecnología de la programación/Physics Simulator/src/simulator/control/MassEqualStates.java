package simulator.control;


import org.json.*;


public class MassEqualStates implements StateComparator{
	
	public boolean equal(JSONObject s1, JSONObject s2) {
		
		//double time1 = s1.getDouble("time");
		//double time2 = s2.getDouble("time");
		
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
			
			//si no coinciden sus ids o su masa no son iguales y se devuelve false
			if(!(b1.getString("id").equals(b2.getString("id"))) || b1.getDouble("m") != b2.getDouble("m"))
			{
				return false;
			}
			
		}
		
		return true;
	}

}

