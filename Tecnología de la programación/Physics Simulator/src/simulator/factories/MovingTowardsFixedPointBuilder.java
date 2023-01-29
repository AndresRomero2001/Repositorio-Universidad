package simulator.factories;

import org.json.*;

import simulator.misc.Vector2D;
import simulator.model.ForceLaws;
import simulator.model.MovingTowardsFixedPoint;

public class MovingTowardsFixedPointBuilder extends Builder<ForceLaws>{

	final static String MTCPTYPE = "mtfp";
	final static String MTCPDESC = "Moving towars fixed point force";

	//valores basura para create data
	final double DEFAULT_G = 9.81;
	final Vector2D DEFAULT_C = new Vector2D(0,0);
	
	final String DEFAULT_DATA_MSG_C = "the point towards which bodies move (a json list of 2 numbers, e.g., [100.0,50.0])";
	final String DEFAULT_DATA_MSG_G = "the length of the acceleration vector (a number)";
	
	
	public MovingTowardsFixedPointBuilder() {
		super(MTCPTYPE, MTCPDESC);
	}

	@Override
	public ForceLaws createTheInstance(JSONObject info) throws IllegalArgumentException {
		
		double auxG = DEFAULT_G;
		Vector2D auxC = new Vector2D(DEFAULT_C);
		
		if(info.has("c"))
		{
			if(info.getJSONArray("c").length() != 2)
			{
				throw new IllegalArgumentException("Invalid value for point (c) in JSON info for an object of type " + _type);
			}
			double x = info.getJSONArray("c").getDouble(0);
			double y = info.getJSONArray("c").getDouble(1);
			
			auxC = new Vector2D(x,y);
		}
		
		if(info.has("g"))
		{
			auxG = info.getDouble("g");
		}
		
		
		return new MovingTowardsFixedPoint(auxC, auxG);
	}
	
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		//data.put("g", DEFAULT_G);
		data.put("c", DEFAULT_DATA_MSG_C);

		//data.put("c", DEFAULT_C.asJSONArray());
		data.put("g", DEFAULT_DATA_MSG_G);
		
		
		return data;
	}

}
