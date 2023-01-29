package model;

import java.util.Random;

public class Player {
	
	public static final int INTIAL_COINS = 50;
	private static final float PROBABILITY = 0.5F;
	private static final int NUM_OF_ADD_COINS = 10;
	
	
	private int coins;
	private Random rand;
	
	
	public boolean enoughCoins(int coins)
	{
		return (this.coins >= coins);
	}
	
	
	public Player(Random rand)
	{
		coins = INTIAL_COINS;
		this.rand = rand;
	}
	
	public void addAleatCoins()
	{		
		if(rand.nextFloat() > PROBABILITY)
		{
			addCoins(NUM_OF_ADD_COINS);
		}
	}
	
	public void subCoins(int coins)
	{
		this.coins -= coins;
	}
	
	public int getNumOfCoins()
	{
		return coins;
	}
	
	public void setCoins(int coins)
	{
		this.coins = coins;
	}


	public void addCoins(int coins) {
		this.coins += coins;
		
	}
}
