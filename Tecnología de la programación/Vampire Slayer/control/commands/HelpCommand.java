package control.commands;

import model.Game;

public class HelpCommand extends Command {

	final static String NAME = "help";
	final static String SHORTCOUT = "h";
	final static String DETAILS = "[h]elp";
	final static String HELP = "show this help";
	
	public HelpCommand()
	{
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}
	
	@Override
	public boolean execute(Game game) {
		System.out.println(CommandGenerator.commandHelp());
		return false;
	}

	@Override
	public Command parse(String[] commandWords) {	
		return parseNoParamsCommand(commandWords);
	}

}
