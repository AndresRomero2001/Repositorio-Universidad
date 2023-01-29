package model.GameObjects;

import model.Game;

public class BloodBank extends Slayer{

	final String SYMBOL = "B";
	
	public BloodBank(int x, int y, int costCoins, Game game) {
		super(x, y, costCoins, game);

	}
	
	
	@Override
	public void move() {
			int coins = (int) (life * 0.1f);
			
			game.addCoins(coins);
	}
	
	@Override
	public void attack()
	{
		
	}
	
	@Override
	 public boolean receiveVampireAttack(int damage)
	 {
		 life = 0;
		 return true;
	 }

	@Override
	public String getSymbol() {
		
		return SYMBOL;
	}
	

}
