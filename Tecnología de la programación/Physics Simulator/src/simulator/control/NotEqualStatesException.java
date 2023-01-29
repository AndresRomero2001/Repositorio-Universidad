package simulator.control;

import org.json.JSONObject;

public class NotEqualStatesException extends RuntimeException{

	private static final long serialVersionUID = 1L;
	
	public NotEqualStatesException(JSONObject expected, JSONObject actual, int step) 
	{
		super("States are different at step " + step + System.lineSeparator() 
				+ "Actual state:   " + actual + System.lineSeparator() 
				+ "Expected state: " + expected);	
	}
	

}
