package control.commands;

import model.Game;

public class ExitCommand extends Command{
	
	final static String NAME = "exit";
	final static String SHORTCOUT = "e";
	final static String DETAILS = "[e]xit";
	final static String HELP = "exit game";
	
	public ExitCommand()
	{
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {
		game.doExit();
		return false;
	}

	@Override
	public Command parse(String[] commandWords) {
		return parseNoParamsCommand(commandWords);
	}

}
