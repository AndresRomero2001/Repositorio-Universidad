package simulator.factories;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONObject;

public class BuilderBasedFactory<T> implements Factory<T> {

	List<Builder<T>> builders;
	
	List<JSONObject> list;
	
	public BuilderBasedFactory(List<Builder<T>> builders)
	{
		this.builders = builders;
		
		
		list = new ArrayList<JSONObject>();
		
		for(Builder<T> builder: builders)
		{
			list.add(builder.getBuilderInfo());
		}
		
	}
		

	@Override
	public T createInstance(JSONObject info) throws IllegalArgumentException {

		//recorre todos los builders del tipo T (o hijos de T) hasta que alguno pueda crear un objeto con la informacion dada
		for(Builder<T> builder: builders)
		{
			T object = builder.createInstance(info); //Puede lanzar excepciones si los datos de info no son correctos (la lanzan los buuilders)
			
			if(object != null)
			{
				return object;
			}
		}

		
		throw new IllegalArgumentException("Invalid input. No builder for some of the given data");
	}

	@Override
	public List<JSONObject> getInfo() {
		return list;
	}
	
	

}
