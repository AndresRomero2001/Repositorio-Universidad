package model.lists;
import java.util.ArrayList;


import model.GameObjects.GameObject;

public class GameObjectList {

	
	private ArrayList<GameObject> gameObjects;
	
	public GameObjectList()
	{
		gameObjects = new ArrayList<GameObject>();
	}
	
	
	public void addGameObject(GameObject gameObject)
	{
		gameObjects.add(gameObject);	
	}


	public void moveObjects() {
		for(GameObject object : gameObjects)
		{
			object.move();
		}		
	}


	public GameObject getObjectInPosition(int x, int y) {
				
		for(GameObject object : gameObjects)
		{
			if(object.isObjectInPosition(x,y))
			{
				return object;
			}
		}
		
		return null;
	}


	public String getPositionToString(int x, int y) {
		
		 GameObject object = getObjectInPosition(x, y);
		
		 if(object != null)
		 {
			 return object.toString();
		 }
		 
		 return "";
	}


	public boolean isPositionEmpty(int x, int y) {
		
		for(GameObject object : gameObjects)
		{
			if(object.isObjectInPosition(x,y))
			{
				return false;
			}
		}
		
		return true;
	}


	public void attack() {
		for(GameObject object: gameObjects)
		{
			object.attack();
		}
		
	}


	public void removeDeadObjects() {
		
		ArrayList<GameObject> aux = gameObjects;		
		gameObjects = new ArrayList<GameObject>();
		
		for(GameObject object: aux)
		{
			if(object.isAlive())
			{
				gameObjects.add(object);
			}
		}
	}


	public void GarlicPush() {
		for(GameObject object: gameObjects)
		{
			object.receiveGarlicPush();
		}
		
	}


	public void lightFlash() {
		for(GameObject object: gameObjects)
		{
			object.receiveLightFlash();
		}
		
	}
	
	
}
