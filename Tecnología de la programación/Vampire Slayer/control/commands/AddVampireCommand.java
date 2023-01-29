package control.commands;

import model.Game;


public class AddVampireCommand extends Command {

	
	final static String NAME = "vampire";
	final static String SHORTCOUT = "v";
	final static String DETAILS = "[v]ampire [<type>] <x> <y>";
	final static String HELP = "Type = {\"\"|\"D\"|\"E\"}: add a vampire in position x, y";
	
	int x;
	int y;
	String type;
	
	private static final String[] VampireTypes = {
			"v",
			"e",
			"d"			
			};
	

	public AddVampireCommand() {
		super(NAME, SHORTCOUT, DETAILS, HELP);
		
	}

	@Override
	public boolean execute(Game game) {

		if(type.equals("v"))
		{
			return game.doUserAddVampire(x, y);
		}
		else if(type.equals("d"))
		{
			return game.doUserAddDracula(x, y);
		}
		else
		{
			return game.doUserAddExplosiveVampire(x, y);
		}
		
	}

	@Override
	public Command parse(String[] commandWords) {
	
		if (matchCommandName(commandWords[0])) {
			
			if (commandWords.length == 3)
			{
				type = VampireTypes[0];	//posicion 0 vampiro por defecto
				x = Integer.parseInt(commandWords[1]);
				y = Integer.parseInt(commandWords[2]);	
				return this;
				
			}
			else if  (commandWords.length == 4)
			{
				if(matchVampireType(commandWords[1]))
				{
					type = commandWords[1].toLowerCase();
					x = Integer.parseInt(commandWords[2]);
					y = Integer.parseInt(commandWords[3]);	
					return this;
				}
				else
				{
					System.err.println (incorrectType);
				}
			}
			else
			{
				System.err.println (incorrectArgsMsg);
				
			}
		}
	
		return null;
	}
	
	
	
	public boolean matchVampireType(String type)
	{
		for(String t: VampireTypes)
		{
			if(t.equalsIgnoreCase(type))
			{
				return true;
			}
		}	
		return false;
	}
	
		
}
