package simulator.factories;

import org.json.JSONObject;


import simulator.model.ForceLaws;
import simulator.model.NewtonUniversalGravitation;

public class NewtonUniversalGravitationBuilder extends Builder<ForceLaws> {

	final static String NULGTYPE = "nlug";
	final static String NULGDESC = "Newton's law of universal gravitation";

	final double DEFAULT_G = 6.67E-11;
	
	final String DEFAULT_DATA_MSG = "the gravitational constant (a number)";
	
	public NewtonUniversalGravitationBuilder() {
		super(NULGTYPE, NULGDESC);
	}

	
	@Override
	public ForceLaws createTheInstance(JSONObject info) {
		
		if(info.has("G"))//JSON parte data con clave G
		{
			return new NewtonUniversalGravitation(info.getDouble("G"));			
		}
		else
		{
			return new NewtonUniversalGravitation(DEFAULT_G);
		}
		

	}
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		//data.put("G", DEFAULT_G);
		data.put("G", DEFAULT_DATA_MSG);
		
		return data;
	}
	
	

}
