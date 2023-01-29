package simulator.model;

import simulator.misc.Vector2D;

public class MassLosingBody extends Body{

	double lossFactor;
	double lossFrequency;
	
	double c;
	
	//datos ya validados en los builders
	public MassLosingBody(String id, Vector2D velocity, Vector2D position, Double mass, Double lossFactor, double lossFrecuency) {
		super(id, velocity, position, mass);
		this.lossFactor = lossFactor;
		this.lossFrequency = lossFrecuency;
		c = 0.0;
	}
	
	public void move(double t)
	{
		super.move(t);
		c += t;
		
		if(c >= lossFrequency)
		{
			mass = mass * (1 - lossFactor);
			c = 0.0;
		}
		
		
	}
	

}
