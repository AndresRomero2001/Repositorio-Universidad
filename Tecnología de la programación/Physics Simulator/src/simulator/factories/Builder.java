package simulator.factories;
import org.json.*;


public abstract class Builder<T> {
	
	protected String _type;
	protected String _desc;
	
	
	public Builder (String type, String desc)
	{
		_type = type;
		_desc = desc;
	}
	
	public T createInstance(JSONObject info) throws IllegalArgumentException
	{
		//1 leer tipo
		//2 crear objeto builder en funcion del tipo
		//funcion de crear instancia de ese builder concreto
		
		//solo comprobar con su id
		JSONObject template = new JSONObject();
		
		template = getBuilderInfo();
		
		if(!info.has("type"))//JSON sin clave type
		{
			return null;
		}
		
		if(!info.getString("type").equals(template.getString("type"))) //JSON no coincide con el type del builder concreto que se esta usando
		{
			return null;
		}
		
		//se entiende que si no tiene campo data, es un error del tipo data, y por tanto lanza excepcion
		if(!info.has("data"))//JSON sin clave data
		{
			throw new IllegalArgumentException("Missing data key in JSON info for an object of type " + template.getString("type"));
		}
		
		return  createTheInstance(info.getJSONObject("data")); //create the instance puede lanzar excepcion, que sera relanzada a la clase invocadora
	}
	
	
	//devuelve un objeto JSON que sirve de plantilla para el correspondiente constructor, i.e.,
	//un valor válido para el parámetro de
	//createInstance (ver getInfo() de Factory<T>).
	public JSONObject getBuilderInfo()
	{
		JSONObject info = new JSONObject();
		
		info.put("type", _type);
		
		info.put("data", createData());
		
		info.put("desc", _desc);
		
		return info;
	}
	
	
	public abstract JSONObject createData();
	
	
	public abstract T createTheInstance(JSONObject info);
	
		
	

}
