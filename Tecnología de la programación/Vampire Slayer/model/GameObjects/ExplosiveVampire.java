package model.GameObjects;

import model.Game;
import model.IAttack;

public class ExplosiveVampire extends Vampire{

	final String SYMBOL = "EV";
	
	public ExplosiveVampire(int x, int y, Game game) {
		super(x, y, game);

	}
	
	
	public boolean receiveSlayerAttack(int damage)
	{
		life -= damage;
		
		if(!isAlive())
		{
			vampOnBoard--;
			explosion();
		}		
		return true;
	}
	
	
	void explosion()
	{
		IAttack other;
		for(int i = x-1; i <= x +1; i++)
		{
			for(int j = y -1; j <= y +1; j++)
			{
				other = game.getAttackableInPosition(i, j);
				if(other != null && other != this) //other != this, para evitar que se intente atacar asi mismo. Sino entrario en un bucle infinito, porque estaria explotando infinitamente
				{
					other.receiveSlayerAttack(damage);	
				}
			}
		}
	}
	
	@Override
	public String getSymbol() {
		
		return SYMBOL;
	}

}
