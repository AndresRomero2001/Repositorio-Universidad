package simulator.model;

import java.util.List;

import simulator.misc.Vector2D;

public class MovingTowardsFixedPoint implements ForceLaws {

	Vector2D c;
	double g;
	
	public MovingTowardsFixedPoint(Vector2D c, double g)
	{
		this.c = c;
		this.g = g;
	}
	
	@Override
	public void apply(List<Body> bs) {
		
		for(Body body: bs)
		{
			body.addForce(c.minus(body.getPosition()).direction().scale(g*body.getMass()));
		}	
	}
	
	
	public String toString()
	{
		return "Moving towards " + c + " with constant aceleration " + g;
	}
	
	

}
