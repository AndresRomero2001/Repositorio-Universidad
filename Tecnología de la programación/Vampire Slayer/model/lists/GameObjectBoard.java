package model.lists;

import model.GameObjects.GameObject;

public class GameObjectBoard {
	
	
	GameObjectList gameObjectList;
	
	public GameObjectBoard()
	{
		gameObjectList = new GameObjectList();
	}
	
	
	public void addGameObject(GameObject gameObject)
	{
		gameObjectList.addGameObject(gameObject);
	}
	

	public void moveObjects() {
		gameObjectList.moveObjects();
		
	}


	public GameObject getObjectInPosition(int x, int y) {
		
		return gameObjectList.getObjectInPosition(x,y);
	}


	public String getPositionToString(int x, int y) {
	
		return gameObjectList.getPositionToString(x,y);
	}


	public boolean isPositionEmpty(int x, int y) {
		
		return gameObjectList.isPositionEmpty(x, y);
	}


	public void attack() {
		gameObjectList.attack();		
	}


	public void removeDeadObjects() {
		gameObjectList.removeDeadObjects();	
	}


	public void lightFlash() {
		gameObjectList.lightFlash();
		
	}


	public void GarlicPush() {
		gameObjectList.GarlicPush();
		
	}
	
	
}
