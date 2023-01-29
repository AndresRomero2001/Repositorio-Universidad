package control.commands;

import model.Game;

public class ResetCommand extends Command {
	
	final static String NAME = "reset";
	final static String SHORTCOUT = "r";
	final static String DETAILS = "[r]eset";
	final static String HELP = "reset game";
	
	public ResetCommand()
	{
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {
		game.doReset();	
		return true;
	}

	@Override
	public Command parse(String[] commandWords) {		
		return parseNoParamsCommand(commandWords);
	}

}
