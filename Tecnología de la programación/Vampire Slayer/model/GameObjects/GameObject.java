package model.GameObjects;

import model.Game;
import model.IAttack;

public abstract class GameObject implements IAttack {
	
	protected int x;
	protected int y;
	
	protected int life;
	protected int damage;
	protected Game game;
	
	public GameObject(int x, int y, int life, int damage, Game game)
	{
		this.x = x;
		this.y = y;
		this.life = life;
		this.damage = damage;
		this.game = game;
	}
	
	public abstract void move();
	
	
	public boolean isObjectInPosition(int x2, int y2)
	{
		if(x == x2 && y == y2)
		{
			return true;
		}
		return false;
	}
	
	public String toString()
	{
		return (getSymbol() + "[" + life +"]");
		
	}
	
	public abstract String getSymbol();

	public boolean isAlive()
	{
		return life > 0;
	}
	
	
	

}
