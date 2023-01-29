package control.commands;

import model.Game;

public class GarlicPushCommand extends Command{

	final static String NAME = "garlic";
	final static String SHORTCOUT = "g";
	final static String DETAILS = "[g]arlic";
	final static String HELP = "Pushes back vampires";
	
	public GarlicPushCommand() {
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {
		return game.doGarlicPush();
	}

	@Override
	public Command parse(String[] commandWords) {
		return parseNoParamsCommand(commandWords);
	}

}
