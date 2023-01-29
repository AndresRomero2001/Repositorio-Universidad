package control.commands;

import model.Game;

public class UpdateCommand extends Command{
	
	final static String NAME = "none";
	final static String SHORTCOUT = "n";
	final static String DETAILS = "[n]one | []";
	final static String HELP = "update";
	
	public UpdateCommand()
	{
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}
	
	@Override
	public boolean execute(Game game) {
		game.doUpdate();
		return true;
	}

	@Override
	public Command parse(String[] commandWords) {
		if(commandWords[0].equalsIgnoreCase("")) return this;
		else return parseNoParamsCommand(commandWords);
	}

}
