package control.commands;

import model.Game;

public class LightFlashCommand extends Command {
	
	final static String NAME = "light";
	final static String SHORTCOUT = "l";
	final static String DETAILS = "[l]ight";
	final static String HELP = "kills all the vampires";

	public LightFlashCommand() {
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {		
		return game.doLightFlash();
	}

	@Override
	public Command parse(String[] commandWords) {		
		return parseNoParamsCommand(commandWords);
	}

}
