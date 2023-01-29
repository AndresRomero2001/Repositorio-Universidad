package simulator.model;

import java.util.ArrayList;
import java.util.List;

import org.json.*;

public class PhysicsSimulator {

	private double deltaTime;
	
	private ForceLaws forceLaw;
	
	private List<Body> bodies;
	
	private double actualTime;
	
	//nuevos atributos
	ArrayList<SimulatorObserver> observersList;
	
	
	public PhysicsSimulator(double realTimePerStep, ForceLaws forceLaw)
	{
		
		if(realTimePerStep <= 0)
		{
			throw new IllegalArgumentException("Invalid value for real-time-per-step. Must be greater than 0");
		}
		if(forceLaw == null)
		{
			throw new IllegalArgumentException("Invalid value for force-law. Musn't be null");
		}
		this.deltaTime = realTimePerStep;
		this.forceLaw = forceLaw;
		actualTime = 0;
		
		bodies = new ArrayList<Body>();
		//observersList = new ArrayList<SimulatorObserver>();
		observersList = new ArrayList<>();
	}
	
	
	//avanza un paso de simulacion
	public void advance()
	{
		//reset de las fuerzas de todos los cuerpos
		for(Body b: bodies)
		{
			b.resetForce();
		}
		
		//aplicamos la fuerza definida a la lista de cuerpos
		forceLaw.apply(bodies);
		
		//movemos todos los cuerpos en base a las fuerzas que se les aplicaron
		for(Body b: bodies)
		{
			b.move(deltaTime);
		}
		
		//aumentamos el tiempo actual de simulacion
		actualTime += deltaTime;	
		
		//notificamos a todos los observadores del avance
		for(SimulatorObserver o: observersList)
		{
			o.onAdvance(bodies, actualTime);
		}
		
	}
	
	
	public void addBody(Body b)
	{
		//comprobamos que el cuerpo no estuviera ya en la lista (comprobandolo con su id que es unico (esto lo hace el metodo equals de body por usar contains))	
		
		if(bodies.contains(b))
		{
			throw new IllegalArgumentException("Invalid id " + b.getId() + " for one body. This id already exits.");
		}
		
		bodies.add(b);
		
		//notificamos a todos los observadores del cuerpo nuevo
		for(SimulatorObserver o: observersList)
		{
			o.onBodyAdded(bodies, b);
		}
		
	}
	
	public JSONObject getState()
	{
		JSONObject state = new JSONObject();
		
		JSONArray ja = new JSONArray();
		for(Body b: bodies)
		{
			ja.put(b.getState());
		}
		
		state.put("time", actualTime);
		state.put("bodies", ja);
		
		return state;	
	}
	
	public String toString()
	{
		return getState().toString();
	}
	
	//Nuevos metodos version 2
	
	public void reset()
	{
		bodies.clear();
		
		actualTime = 0.0;
		
		//notificamos a todos los observadores del reset
		for(SimulatorObserver o: observersList)
		{
			o.onReset(bodies, actualTime, deltaTime, forceLaw.toString());
		}
	}
	
	public void setDeltaTime(double dt) throws IllegalArgumentException
	{
		if(dt <= 0)
		{
			throw new IllegalArgumentException("Invalid value for delta-time. Must be positive");
		}
		
		deltaTime = dt;

		//notificamos a todos los observadores del cambio de delta-time
		for(SimulatorObserver o: observersList)
		{
			o.onDeltaTimeChanged(dt);
		}
	}
	
	public void setForceLaws(ForceLaws forceLaws)
	{
		if(forceLaws == null)
		{
			throw new IllegalArgumentException("Invalid value for force laws. Must no be null");
		}	
		
		this.forceLaw = forceLaws;
		
		//notificamos a todos los observadores del cambio de force-law
		for(SimulatorObserver o: observersList)
		{
			o.onForceLawsChanged(forceLaws.toString());
		}
		
	}
	
	
	public void addObserver(SimulatorObserver o)
	{
	//	if(!observersList.contains(o))//TODO probar
			observersList.add(o);
		
		//notificamos al observador que se ha metido correctamente, y se el pasan los datos para que actualice su informacion (estado actual del simulador)
		o.onRegister(bodies, actualTime, deltaTime, forceLaw.toString());
	}

	
	
}
