package control;

import java.util.Scanner;

import control.commands.Command;
import control.commands.CommandGenerator;
import model.Game;

public class Controller {

	
	public final String prompt = "Command > ";
	public static final String helpMsg = String.format(
			"Available commands:%n" +
			"[a]dd <x> <y>: add a slayer in position x, y%n" +
			"[h]elp: show this help%n" + 
			"[r]eset: reset game%n" + 
			"[e]xit: exit game%n"+ 
			"[n]one | []: update%n");
	
	
	public static final String debugMsg = String.format("[DEBUG] Executing:");
	public static final String unknownCommandMsg = String.format("Unknown command");
	public static final String invalidCommandMsg = String.format("Invalid command");
	
	
	public static final String gameOver = String.format("[Game over]");
	
	private boolean refreshDisplay;
	

    private Game game;
    private Scanner scanner;
    
    public Controller(Game game, Scanner scanner) {
	    this.game = game;
	    this.scanner = scanner;
	    refreshDisplay = true;
    }
    
    public void  printGame() {
   	 System.out.println(game);
   }
    
    
    public void run() {
    	
		while (!game.isFinished()){
			if (refreshDisplay ) printGame();
			refreshDisplay = false;
			System.out.println(prompt);
			String s = scanner.nextLine();
			String[] parameters = s.toLowerCase().trim().split(" ");
			System.out.println("[DEBUG] Executing: " + s);
			Command command = CommandGenerator.parse(parameters);
			if (command != null) {
			refreshDisplay = command.execute(game);
			}
			else {
			System.out.println("[ERROR]: "+ unknownCommandMsg);
			}
			}
		
		if (refreshDisplay ) printGame();
    	System.out.println(gameOver + " " + game.getMensajeGameOver());
    }
}
