package model;



import java.util.Random;


import model.GameObjects.BloodBank;
import model.GameObjects.Dracula;
import model.GameObjects.ExplosiveVampire;
import model.GameObjects.Slayer;
import model.GameObjects.Vampire;
import model.lists.GameObjectBoard;


import view.GamePrinter;
import view.IPrintable;


public class Game implements IPrintable{
	
	public static final String errorMsg = String.format("[ERROR]: ");
	public static final String invalidPositionMsg = String.format("Invalid position");
	public static final String notEnoughCoins = String.format("Not enough coins");
	public static final String notRemainingVampires = String.format("No more remaining vampires left");
	public static final String draculaAlreadyAlive = String.format("Dracula is already alive");
	
	
	final int COST_GARLIC_PUSH = 10;
	final int COST_LIGHT_FLASH = 50;
	
	
	Random rand;
	
	private GameObjectBoard gameObjectBoard;
	
	private GamePrinter gamePrinter;
	
	private Level level;
	
	private Player player;
	
	private int cycles;

	//variables para el rst y el exit
	private long seed;
	private boolean userExit = false;
	
	
	public Game(long seed, Level level)
	{
		this.level = level;
		this.seed = seed;
		gamePrinter = new GamePrinter(this, level.getDimX(), level.getDimY());//x numero columna, y numero de filas
		doReset();//inicializacion del resto de valores				
	}
	
	
	public void addCycles()
	{
		if(!isFinished())//para que en el ultimo ciclo no sume al contador
			cycles++;
	}
	
	
	
	public void addVampire()
	{
		
		if(Vampire.vampRemaining > 0)
		{			
			if(rand.nextDouble() < level.getVampireFrequency())
			{
				int y = rand.nextInt(level.getDimY());//fila
				int x = level.getDimX()-1;//columna
				if(gameObjectBoard.isPositionEmpty(x,y))
				{
					gameObjectBoard.addGameObject(new Vampire(x, y, this));
				}
			}
		}	
	}
	
	public boolean doUserAddVampire(int x, int y)
	{
		if(Vampire.vampRemaining > 0)
		{
			if(gameObjectBoard.isPositionEmpty(x,y) && positionInsideLimits(x, y)) 
			{
				gameObjectBoard.addGameObject(new Vampire(x, y, this));
				return true;
			}
			else {
				System.out.println(errorMsg + invalidPositionMsg);
			}
		}
		else {
			System.out.println(errorMsg + notRemainingVampires);
		}
		return false;
	}
	
	
	public void addDracula()
	{
		if(Vampire.vampRemaining > 0)
		{		
			if(!Dracula.DraculaAlive)
			{
				if(rand.nextDouble() < level.getVampireFrequency())
				{
					int y = rand.nextInt(level.getDimY());
					int x = level.getDimX()-1;
					if(gameObjectBoard.isPositionEmpty(x,y))
					{
						gameObjectBoard.addGameObject(new Dracula(x, y, this));
					}	
				}
			}
		}	
	}
	
	
	public boolean doUserAddDracula(int x, int y)
	{
		if(Vampire.vampRemaining > 0)
		{
			if(!Dracula.DraculaAlive)
			{
				if(gameObjectBoard.isPositionEmpty(x,y) && positionInsideLimits(x, y))
				{
					gameObjectBoard.addGameObject(new Dracula(x, y, this));
					return true;
				}
				else {
					System.out.println(errorMsg + invalidPositionMsg);
				}
			}
			else {
				System.out.println(errorMsg + draculaAlreadyAlive);
			}
		}
		else {
			System.out.println(errorMsg + notRemainingVampires);
		}
			
		return false;
	}
	
	public void addExplosiveVampire()
	{
		
		if(Vampire.vampRemaining > 0)
		{			
			if(rand.nextDouble() < level.getVampireFrequency())
			{
				int y = rand.nextInt(level.getDimY());
				int x = level.getDimX()-1;
				if(gameObjectBoard.isPositionEmpty(x,y))
				{
					gameObjectBoard.addGameObject(new ExplosiveVampire(x, y, this));
				}
			}
		}	
	}
	
	
	public boolean doUserAddExplosiveVampire(int x, int y)
	{
		if(Vampire.vampRemaining > 0)
		{
			if(gameObjectBoard.isPositionEmpty(x,y) && positionInsideLimits(x, y)) 
			{
				gameObjectBoard.addGameObject(new ExplosiveVampire(x, y, this));
				return true;
			}
			else {
				System.out.println(errorMsg + invalidPositionMsg);
			}
		}
		else {
			System.out.println(errorMsg + notRemainingVampires);
		}
		return false;
	}
	
	

	public boolean isFinished()
	{
		if(Vampire.vampRemaining == 0 && Vampire.vampOnBoard == 0)
		{
			return true;
		}
		if(Vampire.arriveFinal)
		{
			return true;
		}
		if(userExit)
		{
			return true;
		}
		
		return false;
	}
	
	//dada una posicion x, y devolvera el toString del objeto en dicha posicion
	public String getPositionToString(int x, int y)
	{		
		return gameObjectBoard.getPositionToString(x,y);
	}
	
	
	public String toString()
	{
		return gamePrinter.toString();
	}
	
	public String getMensajeGameOver()
	{
		if(Vampire.arriveFinal)
		{
			return "Vampires win!";
		}
		if(userExit)
		{
			return "Nobody wins...";
		}
		
		return "Player wins";
	}
	
	
	public void doExit() {
		
		userExit = true;
	}

	public void doReset() {
		
		Vampire.setVampRemaining(level.getNumberOfVampires());
		Vampire.setVampOnBoard(0);
		rand = new Random(seed);//creamos otra vez la misma secuencia de numeros aleatorios
		gameObjectBoard = new GameObjectBoard();
		player = new Player(rand);
		cycles = 0;	
		Dracula.setDraculaAlive(false);
	}

	public void doUpdate() {
			
		player.addAleatCoins();
		
		gameObjectBoard.moveObjects();
		gameObjectBoard.attack();
		
		addVampire();
		
		addDracula();
		addExplosiveVampire();
		
		gameObjectBoard.removeDeadObjects();
		addCycles();
		
	}


	public boolean doAddSlayer(int x, int y) {
		
		if(positionInsideLimits(x, y) && x < level.getDimX() -1 && isPositionEmpty(x, y))
		{
			if(player.enoughCoins(Slayer.COST_SLAYER))
			{
			gameObjectBoard.addGameObject(new Slayer(x, y, this));
			player.subCoins(Slayer.COST_SLAYER);
			
			doUpdate();
			return true;
			}
			else
			{
				System.out.println(errorMsg + notEnoughCoins);
			}
		}
		else
		{
			System.out.println(errorMsg + invalidPositionMsg);
		}
		
		return false;
	}


	public boolean isPositionEmpty(int x, int y) {		
		return gameObjectBoard.isPositionEmpty(x,y);
		
	}


	public boolean positionInsideLimits(int x, int y) {
		if( x < level.getDimX() && x >= 0 && y < level.getDimY() && y >= 0)
		{
		return true;
		}
		return false;
	}


public IAttack getAttackableInPosition(int x, int y) {
		
		return gameObjectBoard.getObjectInPosition(x, y); //"Cast" de gameObject a IAttack
	}


	public int getDimX() {
		
		return level.getDimX();
	}


	@Override
	public String getInfo() {
		String auxEnter= System.lineSeparator();
		
		String info = "Number of cycles: " + cycles + auxEnter + "Coins: " + player.getNumOfCoins() + auxEnter + "Remaining vampires: " + Vampire.vampRemaining + auxEnter + "Vampires on the board: " + Vampire.vampOnBoard + auxEnter;
		if(Dracula.DraculaAlive)
		{
			info += "Dracula is alive" + auxEnter;
		}
		return  info;
	}

	//necesario para el BloodBank
	public void addCoins(int coins) {
		player.addCoins(coins);
		
	}


	public boolean doAddBloodBank(int x, int y, int z) {
		
		if(positionInsideLimits(x, y) && x < level.getDimX() -1 && isPositionEmpty(x, y))
		{
			if(player.enoughCoins(z))
			{
			gameObjectBoard.addGameObject(new BloodBank(x, y, z, this));
			player.subCoins(z);
			
			doUpdate();
			return true;
			}
			else
			{
				System.out.println(errorMsg + notEnoughCoins);
			}
		}
		else
		{
			System.out.println(errorMsg + invalidPositionMsg);
		}
		
		return false;
		
		
	}



	public boolean doLightFlash() {
			
		if(player.enoughCoins(COST_LIGHT_FLASH))
		{
			gameObjectBoard.lightFlash();
			player.subCoins(COST_LIGHT_FLASH);
			
			doUpdate();
			return true;
		}
		else
		{
			System.out.println(errorMsg + notEnoughCoins);
		}
		return false;
	}


	public boolean doGarlicPush() {
		if(player.enoughCoins(COST_GARLIC_PUSH))
		{
			gameObjectBoard.GarlicPush();
			player.subCoins(COST_GARLIC_PUSH);
			
			doUpdate();	
			return true;
		}
		else
		{
			System.out.println(errorMsg + notEnoughCoins);
		}
		
		return false;
	}


	public void doSuperCoins(int coins) {
		player.addCoins(coins);
		
	}
	
	


	

}
