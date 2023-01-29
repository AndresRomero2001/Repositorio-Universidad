package simulator.factories;

import org.json.JSONObject;

import simulator.model.ForceLaws;
import simulator.model.NoForce;

public class NoForceBuilder extends Builder<ForceLaws>{

	final static String NOFORCETYPE = "nf";
	final static String NOFORCEDESC = "No force";
	
	
	public NoForceBuilder() {
		super(NOFORCETYPE, NOFORCEDESC);
	}

	@Override
	public ForceLaws createTheInstance(JSONObject info) {
		return new NoForce();
	}
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		return data;
	}

}
