package simulator.factories;

import org.json.JSONObject;

import simulator.misc.Vector2D;
import simulator.model.Body;
import simulator.model.MassLosingBody;

public class MassLosingBodyBuilder extends Builder <Body>{

	final static String MASSLOSIGTYPE = "mlb";
	final static String MASSLOSINGDESC = "Body that lose mass";
	
	//valores basura para el create data
	final String DEFAULT_ID = "b1";
	final Vector2D DEFAULT_POS = new Vector2D(0.0e00, 0.0e00);
	final Vector2D DEFAULT_VEL = new Vector2D(0.0e00, 0.0e00);
	final double DEFAULT_MASS =  5.97e24;
	
	final double FRECUENCY =  1e3;
	final double FACTOR = 1e-3;
	
	
	public MassLosingBodyBuilder() {
		super(MASSLOSIGTYPE, MASSLOSINGDESC);
	}

	@Override
	public Body createTheInstance(JSONObject info) throws IllegalArgumentException {
		
		JSONObject expectedData = new JSONObject();
		expectedData = createData();
		
		for (String key : expectedData.keySet()) {//recorre todas las key de la plantilla de este objeto
			
			if(!info.has(key))//si la informacion dada por el comando no tiene alguna key de las requeridas, lanza excepcion
			{
				throw new IllegalArgumentException("Missing key "+ key + " in JSON info for an object of type " + _type);
			}
		}
		
	
		
		//validacion datos numericos
		if(info.getDouble("m") < 0)
		{
			throw new IllegalArgumentException("Invalid value in mass (" + info.getDouble("m") +") in JSON info for an object of type " + _type);
		}
		if(info.getDouble("freq") <= 0)
		{
			throw new IllegalArgumentException("Invalid value in frecuency (" + info.getDouble("freq") +") in JSON info for an object of type " + _type);
		}
		if(info.getDouble("factor") < 0 || info.getDouble("factor") > 1)
		{
			throw new IllegalArgumentException("Invalid value in factor (" + info.getDouble("factor") +") in JSON info for an object of type " + _type);
		}
		
		//validacion y creacion de datos vectores
		double x, y;
		
		if(info.getJSONArray("v").length() != 2)//vector no 2d
		{
			throw new IllegalArgumentException("Invalid value for velocity in JSON info for an object of type " + _type);
		}
		
		x = info.getJSONArray("v").getDouble(0);
		y = info.getJSONArray("v").getDouble(1);
		Vector2D v = new Vector2D(x,y);
		
		if(info.getJSONArray("p").length() != 2)//vector no 2d
		{
			throw new IllegalArgumentException("Invalid value for position in JSON info for an object of type " + _type);
		}
		
		x = info.getJSONArray("p").getDouble(0);
		y = info.getJSONArray("p").getDouble(1);
		Vector2D p = new Vector2D(x,y);
		
	
		
		
		return new MassLosingBody(info.getString("id"), v, p, info.getDouble("m"), info.getDouble("factor"), info.getDouble("freq"));
	}
	
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		data.put("id", DEFAULT_ID);
		data.put("p", DEFAULT_POS);
		data.put("v", DEFAULT_VEL);
		data.put("m", DEFAULT_MASS);
		data.put("freq", FRECUENCY);
		data.put("factor", FACTOR);
	
		return data;
	}

}
