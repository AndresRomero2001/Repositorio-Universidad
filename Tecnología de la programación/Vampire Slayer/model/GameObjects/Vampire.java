package model.GameObjects;

import model.Game;
import model.IAttack;


public class Vampire extends GameObject{

	final int WAIT_TIME = 1; //el numero indica los turnos que esta parado
	final static int INITIAL_LIFE = 5;
	final static  int DAMAGE_VAMPIRE = 1;
	final String SYMBOL = "V";
	
	public static int vampOnBoard;
	public static int vampRemaining;
	public static boolean arriveFinal = false;
	
	int actWaitTime;
	
	
	public Vampire(int x, int y, Game game)
	{
		super(x,y, INITIAL_LIFE,DAMAGE_VAMPIRE, game);
		vampOnBoard++;
		vampRemaining--;
		actWaitTime = WAIT_TIME;
	}
	
	
	public static void setVampRemaining(int value)
	{
		vampRemaining = value;
	}
	
	public static void setVampOnBoard(int value)
	{
		vampOnBoard = value;
	}
	
	
	public void move()
	{
		if(actWaitTime > 0)
		{
			actWaitTime--;
		}
		else if (game.isPositionEmpty(x-1, y))//todo
		{
			x--;
			actWaitTime = WAIT_TIME;
			if(hasArrived())
			{
				arriveFinal = true;
			}
		}
		
	}
	
	
	public void attack()
	{
		if(isAlive())
		{
			IAttack other = game.getAttackableInPosition(x-1,y);
			if(other != null)
			{
				other.receiveVampireAttack(damage);
			}
		}
	}
	
	public boolean receiveSlayerAttack(int damage)
	{
		life -= damage;
		
		if(!isAlive())
		{
			vampOnBoard--;
		}		
		return true;
	}
	
	public boolean receiveLightFlash()
	{
		life = 0;
		vampOnBoard--;
		return true;
	}
	
	public boolean receiveGarlicPush()
	{
		if(game.isPositionEmpty(x+1, y))
		{
			x += 1;
			if(x == game.getDimX())
			{
				life = 0;
				vampOnBoard--;
			}
		}
		//solo se desplazan si la casilla anterior esta libre, pero siempre se aturden
		actWaitTime = WAIT_TIME;
			
		return true;
	}
	
	boolean hasArrived()
	{
		return x < 0;
	}
	
	public String getSymbol() {
		
		return SYMBOL;
	}
	
	
}
