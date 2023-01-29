package simulator.model;

import org.json.*;

import simulator.misc.Vector2D;

public class Body {
		
	protected String id;
	protected Vector2D velocity; 
	protected Vector2D force; 
	protected Vector2D position; 
	protected Double mass;
	
	public Body(String id, Vector2D velocity, Vector2D position, Double mass)
	{
		this.id = id;
		this.velocity = velocity;
		this.position = position;
		this.mass = mass;
		resetForce();// pone la fuerza a 0,0
		
	}
	
	public String getId()
	{
		return id;
	}
	
	public Vector2D getVelocity()
	{
		return velocity;
	}
	
	public Vector2D getForce()
	{
		return force;
	}
	
	public Vector2D getPosition()
	{
		return position;
	}
	
	public double getMass()
	{
		return mass;
	}
	
	
	void addForce(Vector2D f)
	{
		force = force.plus(f);
		//o asi force.plus(f); necesario el otro, el metodo plus no cambia los valores de sus variables, solo devuelve un resultado
	}
	
	void resetForce()
	{
		force = new Vector2D(0, 0);
	}
	
	void move(double t)
	{	
		Vector2D acc = new Vector2D();// 0,0 por defecto 

		if(mass != 0)
		{
			 acc = force.scale(1.0 / mass);
		}
		 position = position.plus(velocity.scale(t).plus(acc.scale(0.5 * t * t)));
		 velocity = velocity.plus(acc.scale(t));	
	}
	
	public JSONObject getState()
	{
		JSONObject state = new JSONObject();
		
		state.put("id", id);
		state.put("m", mass);
		state.put("p", position.asJSONArray());
		state.put("v", velocity.asJSONArray());
		state.put("f", force.asJSONArray());
		
		return state;	
	}
	
	public String toString()
	{
		return getState().toString();
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
	//	if (getClass() != obj.getClass())//-Comentado ya que un cuerpo Basic, y MassLossing, con mismo id, aunque sean clases diferentes, se entiende que son iguales por tener el mismo id
	//		return false;
		Body other = (Body) obj;
		if (id == null) {
			if (other.id != null)
				return false;
		} else if (!id.equals(other.id))
			return false;
		return true;
	}
	
	
	

	
}
