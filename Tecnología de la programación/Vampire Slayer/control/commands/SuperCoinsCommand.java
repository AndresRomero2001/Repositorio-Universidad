package control.commands;

import model.Game;

public class SuperCoinsCommand extends Command {
	
	final static String NAME = "coins";
	final static String SHORTCOUT = "c";
	final static String DETAILS = "[c]oins";
	final static String HELP = "add 1000 coins";
	
	final int COINS = 1000;

	public SuperCoinsCommand() {
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {		
		game.doSuperCoins(COINS);
		return true;
	}

	@Override
	public Command parse(String[] commandWords) {		
		return parseNoParamsCommand(commandWords);
	}

}
