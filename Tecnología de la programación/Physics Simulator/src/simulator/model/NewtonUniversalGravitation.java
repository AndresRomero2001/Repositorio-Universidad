package simulator.model;

import java.util.List;

import simulator.misc.Vector2D;

public class NewtonUniversalGravitation implements ForceLaws{

	private double G;
	
	final String DESC = "Newton’s Universal Gravitation with G= ";
	
	public NewtonUniversalGravitation(double G)
	{
		this.G = G;
	}
	
	@Override
	public void apply(List<Body> bs) {
		
		for(Body body: bs)//ej Bi  cuerpo que recibira la accion de una fuerza
		{
			if(body.getMass() != 0)//si el cuerpo tiene masa 0, ya se pondra en move la aceleracion y velocidad a 0. No es necesario recorrer el segundo bucle
			{
				for(Body b: bs)//ej Bj Resto de cuerpos que aplican fuerzas sobre Bi
				{
					if(!b.equals(body))//no se puede aplicar fuerzas a si mismo
					{
						body.addForce(force(body,b));		
					}
				}
			
			}
		}
	}
	
	private Vector2D force(Body a, Body b) {
	    Vector2D delta = b.getPosition().minus(a.getPosition());
	    double dist = delta.magnitude();
	    double magnitude = dist>0 ? (G * a.getMass() * b.getMass()) / (dist * dist) : 0.0;
	    return delta.direction().scale(magnitude);
	}
	
	

	public String toString()
	{
		return DESC + G;
	}

}
