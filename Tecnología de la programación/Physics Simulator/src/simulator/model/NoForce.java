package simulator.model;

import java.util.List;

public class NoForce implements ForceLaws{
	
	final String DESC = "No Force";
	
	@Override
	public void apply(List<Body> bs) {
	}

	
	public String toString()
	{
		return DESC;
	}
}
