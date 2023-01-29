package control.commands;

import model.Game;

public abstract class Command {
	protected final String name;
	protected final String shortcut;
	private final String details ;
	private final String help;
	
	protected static final String incorrectNumberOfArgsMsg = "Incorrect number of	arguments";
	protected static final String incorrectArgsMsg = "Incorrect arguments format";
	
	protected static final String incorrectType = "invalid type";
	
	public Command(String name, String shortcut, String details, String help){
	this.name = name;
	this. shortcut = shortcut;
	this.details = details;
	this.help = help;
	}
	
	public abstract boolean execute(Game game);
	
	public abstract Command parse(String[] commandWords);
	
	protected boolean matchCommandName(String name) {//true si el name(introducido por el usuario) o shortcut coincide con el comando
	return this.shortcut.equalsIgnoreCase(name) ||	this.name.equalsIgnoreCase(name);
	}
	
	protected Command parseNoParamsCommand(String[] words) {
	if (matchCommandName(words[0])) {
		if (words.length != 1) {
		System.err.println (incorrectArgsMsg);
		return null;
		}
		return this;//devuelve un objeto de la clase command, pero sabiendo cual es su hijo (que comando concreto)
	}
	return null;
	}
	
	public String helpText(){
	return details + ": " + help + "\n";
	}
}
