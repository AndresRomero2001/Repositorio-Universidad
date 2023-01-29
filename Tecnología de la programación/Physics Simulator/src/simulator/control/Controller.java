package simulator.control;


import simulator.model.PhysicsSimulator;
import simulator.model.SimulatorObserver;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.PrintStream;
import java.util.List;

import org.json.*;

import simulator.factories.Factory;
import simulator.model.Body;
import simulator.model.ForceLaws;

public class Controller {
	
	PhysicsSimulator simulator;
	Factory<Body> bodyFactory;
	Factory<ForceLaws> forceLawsFactory;
	
	public Controller(PhysicsSimulator simulator, Factory<Body> bodyFactory, Factory<ForceLaws> forceLawsFactory)
	{
		this.simulator = simulator;
		this.bodyFactory = bodyFactory;
		this.forceLawsFactory = forceLawsFactory;
	}
	
	public void loadBodies(InputStream in)//se asume in como json de la forma { "bodies": [bb1,...,bbn] }
	{
		
		//transforma la entrada JSON (que entra como InputStream) en un objeto JSONObject (que contiene un array de JSON)
		JSONObject jsonInupt = new JSONObject(new JSONTokener(in));	
		
		JSONArray JsonBodyList = jsonInupt.getJSONArray("bodies");
		
		for (int i = 0; i < JsonBodyList.length(); i++) {
			simulator.addBody(bodyFactory.createInstance(JsonBodyList.getJSONObject(i)));
		}
	}
	
	public void run(Integer n, OutputStream out, InputStream expOut, StateComparator cmp) throws NotEqualStatesException
	{

		
		JSONArray JsonExpOutList = new JSONArray();
		
		//solo se comprueba expOut != null y no el cmp != null, ya que si hay expOut, y no cmp, se usa por defecto el epsilon con eps=0
		if(expOut != null)
		{
			JSONObject jsonExpOut = new JSONObject(new JSONTokener(expOut));	
			
			JsonExpOutList = jsonExpOut.getJSONArray("states");
		}
		
		PrintStream p = new PrintStream(out);
		p.println("{");
		p.println("\"states\": [");
		
		// run the sumulation n steps , etc.
	
		//caso especial n = 0
		//primer caso especial aqui, en vez de un if en el bucle, evita hacer la comprobacion del if n veces en el bucle innecesariamente
		//haria falta un if en el bucle, para poner la coma para el formato adecuado, no poniendola delante del primer elemento
		if(expOut != null)
		{
			if(!cmp.equal(simulator.getState(), JsonExpOutList.getJSONObject(0)))
			{
				throw new NotEqualStatesException(JsonExpOutList.getJSONObject(0), simulator.getState(), 0);
			}
		}
		
		p.println(simulator);//llama a toString, que a su vez llamara a getState
		simulator.advance();
		
		
		for(Integer i = 1; i <= n; i++)
		{
			if(expOut != null)
			{
				if(!cmp.equal(simulator.getState(), JsonExpOutList.getJSONObject(i)))
				{
					throw new NotEqualStatesException(JsonExpOutList.getJSONObject(i), simulator.getState(), i);
				}
			}
			p.print(",");
			p.println(simulator);

			simulator.advance();
		}
		
		p.println("]");
		p.println("}");
		
		
	}
	
	
	//nuevos metodos
	
	public void reset()
	{
		simulator.reset();
	}
	
	public void setDeltaTime(double dt)
	{
		simulator.setDeltaTime(dt);
	}
	
	public void addObserver(SimulatorObserver o)
	{
		simulator.addObserver(o);
	}
	

	public void run(int n)
	{
		OutputStream out = new OutputStream() {
			@Override
			public void write(int b) throws IOException {
			};
			};
			
		run(n,out, null, null);		
	}
	
	public List<JSONObject>getForceLawsInfo()
	{
		return forceLawsFactory.getInfo();
	}
	
	public void setForceLaws(JSONObject info) throws IllegalArgumentException
	{
		simulator.setForceLaws(forceLawsFactory.createInstance(info));
	}
	
	

}
