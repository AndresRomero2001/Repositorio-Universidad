package control.commands;

public class CommandGenerator {//clase utilidad: todos los metodos son estaticos

	private static Command[] availableCommands = {
			new AddCommand(),
			new HelpCommand(),
			new ResetCommand(),
			new ExitCommand(),
			new UpdateCommand(),
			new GarlicPushCommand(),
			new LightFlashCommand(),
			new AddBloodBankCommand(),			
			new SuperCoinsCommand(),
			new AddVampireCommand()
			};

	
	public static Command parse(String[] commandWords)//dado un comando escrito por el usuario devuelve el comando con el que coincide (parseando la entrada respecto a cada comando concreto). Si no hay ninguno, null
	{
		for(Command c: availableCommands)
		{
			Command parsedCommand = c.parse(commandWords);
			if(parsedCommand != null)
			{
				return parsedCommand;
			}
		}
		
		return null;
	}
	
	public static String commandHelp()
	{
		String helpText= "";
		for(Command c: availableCommands)
		{
			helpText = helpText + c.helpText();			
		}
		return "Available commands:"+ "\n" + helpText;
	}
	
}
