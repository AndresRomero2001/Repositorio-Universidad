package model.GameObjects;

import model.Game;
import model.IAttack;

public class Dracula extends Vampire {

	final String SYMBOL = "D";
	
	public static boolean DraculaAlive;
	
	
	public Dracula(int x, int y, Game game) {
		super(x, y, game);
		DraculaAlive = true;
	}
	
	
	@Override
	public void attack()
	{
		if(isAlive())
		{

			IAttack other = game.getAttackableInPosition(x-1,y);
			if(other != null)
			{
				other.receiveDraculaAttack();
			}
		}
	}
	
	@Override 
	public boolean receiveSlayerAttack(int damage)
	{
		super.receiveSlayerAttack(damage);	
		if(!isAlive())
		{
			DraculaAlive = false;
		}		
		return true;
	}
	
	@Override
	public boolean receiveLightFlash()
	{
		return false;
	}
	
	@Override
	public boolean receiveGarlicPush()
	{
		super.receiveGarlicPush();
		if(x == game.getDimX())
		{
			DraculaAlive = false;
		}
		return true;
	}
		
	@Override
	public String getSymbol() {
		
		return SYMBOL;
	}

	public static void setDraculaAlive(boolean value) {
		DraculaAlive = value;
		
	}

}
