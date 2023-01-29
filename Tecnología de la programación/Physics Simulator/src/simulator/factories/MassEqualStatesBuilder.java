package simulator.factories;

import org.json.JSONObject;

import simulator.control.MassEqualStates;
import simulator.control.StateComparator;

public class MassEqualStatesBuilder extends Builder<StateComparator>{

	final static String MASSEQTYPE = "masseq";
	final static String MASSEQDESC = "State comparator using mass";
	
	
	public MassEqualStatesBuilder() {
		super(MASSEQTYPE, MASSEQDESC);
	}

	@Override
	public StateComparator createTheInstance(JSONObject info) {
		
		return new MassEqualStates();
	}
	
	@Override
	public JSONObject createData()
	{
		JSONObject data = new JSONObject();
		
		return data;
	}

}
