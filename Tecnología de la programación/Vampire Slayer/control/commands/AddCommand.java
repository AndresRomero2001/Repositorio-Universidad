package control.commands;

import model.Game;

public class AddCommand extends Command {

	final static String NAME = "add";
	final static String SHORTCOUT = "a";
	final static String DETAILS = "[a]dd <x> <y>";
	final static String HELP = "add a slayer in position x, y";
	
	int x;
	int y;
	
	public AddCommand()
	{
		super(NAME, SHORTCOUT, DETAILS, HELP);
	}
	
	@Override
	public boolean execute(Game game) {
		
	return	game.doAddSlayer(x,y);//devolvera false si la posicion era invalida o no tenia monedas

	}

	@Override
	public Command parse(String[] commandWords) {
		
		if (matchCommandName(commandWords[0])) {
			if (commandWords.length != 3) {
			System.err.println (incorrectArgsMsg);
			return null;
			}
			
			x = Integer.parseInt(commandWords[1]);
			y = Integer.parseInt(commandWords[2]);
			return this;
		}

		return null;
	}

}
