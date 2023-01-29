package control.commands;

import model.Game;

public class AddBloodBankCommand extends Command {

	final static String NAME = "bank";
	final static String SHORTCOUT = "b";
	final static String DETAILS = "[b]ank <x> <y> <z>";
	final static String HELP = "add a blood bank with cost z in position x, y";
	
	int x;
	int y;
	int z;
	
	public AddBloodBankCommand() {
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}

	@Override
	public boolean execute(Game game) {
		
		return game.doAddBloodBank(x, y, z); //solo si se añade correctamente devuelve true para que se actualice la pantalla
	}

	@Override
	public Command parse(String[] commandWords) {
		
		if (matchCommandName(commandWords[0])) {
			if (commandWords.length != 4) {
			System.err.println (incorrectArgsMsg);
			return null;
			}
			
			x = Integer.parseInt(commandWords[1]);
			y = Integer.parseInt(commandWords[2]);
			z = Integer.parseInt(commandWords[3]);
			return this;
		}

		return null;
	}

}
