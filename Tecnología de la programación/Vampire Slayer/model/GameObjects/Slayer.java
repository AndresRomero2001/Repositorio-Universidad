package model.GameObjects;

import model.Game;
import model.IAttack;

public class Slayer extends GameObject{

	public static final int COST_SLAYER = 50;
	
	final static int INITIAL_LIVE = 3;

	final static int DAMAGE_SLAYER = 1;
	
	final String SYMBOL = "S";


	public Slayer(int x, int y, Game game)
	{
		super(x, y, INITIAL_LIVE, DAMAGE_SLAYER, game);

	}

	public Slayer(int x, int y, int vida, Game game)
	{
		super(x, y, vida, DAMAGE_SLAYER, game);

	}

	@Override
	public void move() {
			
	}
	
	
	public void attack()
	{
		if(isAlive())
		{
			IAttack other;
			for(int i = x+1; i < game.getDimX(); i++)
			{
				other = game.getAttackableInPosition(i, y);
				if(other != null) 
				{
					if(other.receiveSlayerAttack(damage))//solo daña al primero que encuentra
					break;
				}
			}
			
		}
	}
	
	 public boolean receiveVampireAttack(int damage)
	 {
		 life -= damage;
		 return true;
	 }
	 
	 public boolean receiveDraculaAttack()
	 {
		 life = 0;
		 return true;
	 }


	@Override
	public String getSymbol() {
		
		return SYMBOL;
	}
	
	
}
