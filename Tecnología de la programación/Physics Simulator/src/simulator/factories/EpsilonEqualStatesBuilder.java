package simulator.factories;

import org.json.JSONObject;

import simulator.control.EpsilonEqualStates;
import simulator.control.StateComparator;

public class EpsilonEqualStatesBuilder extends Builder<StateComparator> {

	final static String EPSEQTYPE = "epseq";
	final static String EPSEQDESC = "State comparator using diference less than epsilon";
	
	//valor basura para el create data
	final double DEFAULT_EPS =   0.0;
	
	
	public EpsilonEqualStatesBuilder() {
		super(EPSEQTYPE, EPSEQDESC);
	}

	@Override
	public StateComparator createTheInstance(JSONObject info) throws IllegalArgumentException {
		
		if(info.has("eps"))//data tenia la clave eps
		{
			//epsilon no puede ser negativo
			if(info.getDouble("eps") < 0)
			{
				throw new IllegalArgumentException("Invalid value for epsilon (must greater or equal than 0) in JSON info for an object of type" + _type);
			}
			
			return new EpsilonEqualStates(info.getDouble("eps"));
		}
		else
		{
			return new EpsilonEqualStates(DEFAULT_EPS);
		}
		
	}
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		data.put("eps", DEFAULT_EPS);
		
		return data;
	}
	

}
