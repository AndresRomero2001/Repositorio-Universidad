package simulator.factories;

import org.json.JSONObject;

import simulator.misc.Vector2D;
import simulator.model.Body;

public class BasicBodyBuilder extends Builder<Body>{
	
	final static String BASICBODYTYPE = "basic";
	final static String BASICBODYDESC = "Basic body";
	
	//datos basura para el create data
	final String DEFAULT_ID = "b1";
	final Vector2D DEFAULT_POS = new Vector2D(0.0e00, 0.0e00);
	final Vector2D DEFAULT_VEL = new Vector2D(0.0e00, 0.0e00);
	final double DEFAULT_MASS =  5.97e24;

	public BasicBodyBuilder()
	{
		super(BASICBODYTYPE, BASICBODYDESC);
	}
	
	@Override
	public Body createTheInstance(JSONObject info) throws IllegalArgumentException {


		String id;
		double v1, v2;
		
		Vector2D velocity; 
	 
		Vector2D position; 
		Double mass;
		
		
		JSONObject expectedData = new JSONObject();
		expectedData = createData();
		
		for (String key : expectedData.keySet()) {//recorre todas las key de la plantilla de este objeto
			
			if(!info.has(key))//si la informacion dada por el comando no tiene alguna key de las requeridas, lanza excepcion
			{
				throw new IllegalArgumentException("Missing key "+ key + " in JSON info for an object of type " + _type);
			}
		}

		
		id = info.getString("id");
		
		if(info.getDouble("m") < 0)
		{
			throw new IllegalArgumentException("Invalid value for mass (must be greater or equal than 0) in JSON info for an object of type " + _type);
		}
		mass = info.getDouble("m");
		
		
		if(info.getJSONArray("p").length() != 2)
		{
			throw new IllegalArgumentException("Invalid value for position in JSON info for an object of type " + _type);
		}
		
		v1 = info.getJSONArray("p").getDouble(0);
		v2 = info.getJSONArray("p").getDouble(1);
		position = new Vector2D(v1, v2);
		
		
		if(info.getJSONArray("v").length() != 2)
		{
			throw new IllegalArgumentException("Invalid value for velocity in JSON info for an object of type " + _type);
		}
		
		
		v1 = info.getJSONArray("v").getDouble(0);
		v2 = info.getJSONArray("v").getDouble(1);
		velocity = new Vector2D(v1, v2);
		
		
		
		return new Body(id, velocity, position, mass);
	}
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		data.put("id", DEFAULT_ID);
		data.put("p", DEFAULT_POS);
		data.put("v", DEFAULT_VEL);
		data.put("m", DEFAULT_MASS);
	
		return data;
	}

}
