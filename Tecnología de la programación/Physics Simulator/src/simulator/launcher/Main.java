package simulator.launcher;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;

import org.apache.commons.cli.CommandLine;
import org.apache.commons.cli.CommandLineParser;
import org.apache.commons.cli.DefaultParser;
import org.apache.commons.cli.HelpFormatter;
import org.apache.commons.cli.Option;
import org.apache.commons.cli.Options;
import org.apache.commons.cli.ParseException;
import org.json.JSONObject;

import simulator.control.Controller;
import simulator.control.StateComparator;
import simulator.factories.BasicBodyBuilder;
import simulator.factories.Builder;
import simulator.factories.BuilderBasedFactory;
import simulator.factories.EpsilonEqualStatesBuilder;
import simulator.factories.Factory;
import simulator.factories.MassEqualStatesBuilder;
import simulator.factories.MassLosingBodyBuilder;
import simulator.factories.MovingTowardsFixedPointBuilder;
import simulator.factories.NewtonUniversalGravitationBuilder;
import simulator.factories.NoForceBuilder;
import simulator.model.Body;
import simulator.model.ForceLaws;
import simulator.model.PhysicsSimulator;
import simulator.view.MainWindow;

public class Main {

	// default values for some parameters
	//
	private final static Double _dtimeDefaultValue = 2500.0;
	private final static String _forceLawsDefaultValue = "nlug";
	private final static String _stateComparatorDefaultValue = "epseq";
	
	
	private final static Integer DEFAULT_STEPS = 150;
	
	//posibles opciones de visualizacion del programa
	private final static Integer CONSOLE_MODE = 0;
	private final static Integer GUI_MODE = 1;

	// some attributes to stores values corresponding to command-line parameters
	//
	private static Double _dtime = null;
	private static String _inFile = null;
	private static JSONObject _forceLawsInfo = null;
	private static JSONObject _stateComparatorInfo = null;
	
	//variables nuevas definidas
	private static String outFile = null;
	private static String expOutFile = null;
	
	private static Integer steps = null;
	
	//modo por defecto por consola
	private static Integer mode = CONSOLE_MODE;

	//factories
	private static Factory<Body> _bodyFactory;
	private static Factory<ForceLaws> _forceLawsFactory;
	private static Factory<StateComparator> _stateComparatorFactory;

	private static void init() {
		// TODO initialize the bodies factory
		
		ArrayList<Builder<Body>> bodyBuilders = new ArrayList<>();
		bodyBuilders.add(new BasicBodyBuilder());
		bodyBuilders.add(new MassLosingBodyBuilder());
		_bodyFactory = new BuilderBasedFactory<Body>(bodyBuilders);
		
		
		// TODO initialize the force laws factory

		ArrayList<Builder<ForceLaws>> forceBuilders = new ArrayList<>();
		forceBuilders.add(new NewtonUniversalGravitationBuilder());
		forceBuilders.add(new MovingTowardsFixedPointBuilder());
		forceBuilders.add(new NoForceBuilder());
		_forceLawsFactory = new BuilderBasedFactory<ForceLaws>(forceBuilders);
		
		// TODO initialize the state comparator
		
		ArrayList<Builder<StateComparator>> comparatorBuilders = new ArrayList<>();
		comparatorBuilders.add(new EpsilonEqualStatesBuilder());
		comparatorBuilders.add(new MassEqualStatesBuilder());
		_stateComparatorFactory = new BuilderBasedFactory<StateComparator>(comparatorBuilders);
	}

	private static void parseArgs(String[] args) {

		// define the valid command line options
		//
		Options cmdLineOptions = buildOptions();

		// parse the command line as provided in args
		//
		CommandLineParser parser = new DefaultParser();
		try {
			CommandLine line = parser.parse(cmdLineOptions, args);

			parseHelpOption(line, cmdLineOptions);
			parseInFileOption(line);
			// TODO add support of -o, -eo, and -s (define corresponding parse methods)

			parseOutFileOption(line);
			
			parseExpOutOption(line);
			
			parseStepsOption(line);
			
			
			parseDeltaTimeOption(line);
			parseForceLawsOption(line);
			parseStateComparatorOption(line);
			
			parseModeOption(line);

			// if there are some remaining arguments, then something wrong is
			// provided in the command line!
			//
			String[] remaining = line.getArgs();
			if (remaining.length > 0) {
				String error = "Illegal arguments:";
				for (String o : remaining)
					error += (" " + o);
				throw new ParseException(error);
			}

		} catch (ParseException e) {
			System.err.println(e.getLocalizedMessage());
			System.exit(1);
		}

	}

	private static Options buildOptions() {
		Options cmdLineOptions = new Options();

		// help
		cmdLineOptions.addOption(Option.builder("h").longOpt("help").desc("Print this message.").build());

		// input file
		cmdLineOptions.addOption(Option.builder("i").longOpt("input").hasArg().desc("Bodies JSON input file.").build());

		// TODO add support for -o, -eo, and -s (add corresponding information to
		// cmdLineOptions)
		
		//output (where output is written)
		cmdLineOptions.addOption(Option.builder("o").longOpt("output").hasArg().desc("Output file, where output is written. "
				+ "Default value: the standard output.").build());
		
		//expected output
		cmdLineOptions.addOption(Option.builder("eo").longOpt("expected-output").hasArg().desc("The expected output file. If not provided "
				+	"no comparison is applied").build());
		
		//steps for simulation
		cmdLineOptions.addOption(Option.builder("s").longOpt("steps").hasArg().desc("An integer representing the number of "
				+ "simulation steps. Default value: "+ DEFAULT_STEPS + ".").build());
		

		// delta-time
		cmdLineOptions.addOption(Option.builder("dt").longOpt("delta-time").hasArg()
				.desc("A double representing actual time, in seconds, per simulation step. Default value: "
						+ _dtimeDefaultValue + ".")
				.build());

		// force laws
		cmdLineOptions.addOption(Option.builder("fl").longOpt("force-laws").hasArg()
				.desc("Force laws to be used in the simulator. Possible values: "
						+ factoryPossibleValues(_forceLawsFactory) + ". Default value: '" + _forceLawsDefaultValue
						+ "'.")
				.build());

		// gravity laws
		cmdLineOptions.addOption(Option.builder("cmp").longOpt("comparator").hasArg()
				.desc("State comparator to be used when comparing states. Possible values: "
						+ factoryPossibleValues(_stateComparatorFactory) + ". Default value: '"
						+ _stateComparatorDefaultValue + "'.")
				.build());
		//mode
		cmdLineOptions.addOption(Option.builder("m").longOpt("mode").hasArg()
				.desc("Execution Mode. Possible values: ’batch’ (Batch mode), ’gui’ (Graphical User " 
						+ "Interface mode). Default value: ’batch’.")
				.build());

		return cmdLineOptions;
	}

	public static String factoryPossibleValues(Factory<?> factory) {
		if (factory == null)
			return "No values found (the factory is null)";

		String s = "";

		for (JSONObject fe : factory.getInfo()) {
			if (s.length() > 0) {
				s = s + ", ";
			}
			s = s + "'" + fe.getString("type") + "' (" + fe.getString("desc") + ")";
		}

		s = s + ". You can provide the 'data' json attaching :{...} to the tag, but without spaces.";
		return s;
	}

	private static void parseHelpOption(CommandLine line, Options cmdLineOptions) {
		if (line.hasOption("h")) {
			HelpFormatter formatter = new HelpFormatter();
			formatter.printHelp(Main.class.getCanonicalName(), cmdLineOptions, true);
			System.exit(0);
		}
	}

	private static void parseInFileOption(CommandLine line) throws ParseException {
		_inFile = line.getOptionValue("i");//hasta que no se sepa si el modo es gui o consola, el parametro i es opcional (se lanzara excepcion mas adelante si al final es modo es consola e i es null)
		/**if (_inFile == null) {
			throw new ParseException("In batch mode an input file of bodies is required");
		}*/
	}
	
	//nueva
	private static void parseOutFileOption(CommandLine line)
	{
		if(line.hasOption("o"))
		{
			outFile = line.getOptionValue("o");
		}		
	}
	
	//nueva
	private static void parseExpOutOption(CommandLine line)
	{
		if(line.hasOption("eo"))
		{
			expOutFile = line.getOptionValue("eo");
		}	
	}
	
	//nueva
	private static void parseStepsOption(CommandLine line) throws ParseException
	{
		String st = line.getOptionValue("s", DEFAULT_STEPS.toString());
		try {
			steps = Integer.parseInt(st);
			assert (steps > 0);
		} catch (Exception e) {
			throw new ParseException("Invalid steps value: " + st);
		}	
	}
	
	private static void parseDeltaTimeOption(CommandLine line) throws ParseException {
		String dt = line.getOptionValue("dt", _dtimeDefaultValue.toString());
		try {
			_dtime = Double.parseDouble(dt);
			assert (_dtime > 0);
		} catch (Exception e) {
			throw new ParseException("Invalid delta-time value: " + dt);
		}
	}
	
	//nueva -m
	private static void parseModeOption(CommandLine line) throws ParseException
	{
		if(line.hasOption("m"))//el modo por defecto es consola (incializado en la declaracion de la variable)
		{
			String m;		
			m = line.getOptionValue("m").toLowerCase();
			if(m.equals("batch"))
			{
				mode = CONSOLE_MODE;
			}
			else if(m.equals("gui"))
			{
				mode = GUI_MODE;
			}
			else
			{
				throw new ParseException("Invalid mode: " + m + ". Must be batch or gui");
			}	
		}
	}

	private static JSONObject parseWRTFactory(String v, Factory<?> factory) {

		// the value of v is either a tag for the type, or a tag:data where data is a
		// JSON structure corresponding to the data of that type. We split this
		// information
		// into variables 'type' and 'data'
		//
		int i = v.indexOf(":");
		String type = null;
		String data = null;
		if (i != -1) {
			type = v.substring(0, i);
			data = v.substring(i + 1);
		} else {
			type = v;
			data = "{}";
		}

		// look if the type is supported by the factory
		boolean found = false;
		for (JSONObject fe : factory.getInfo()) {
			if (type.equals(fe.getString("type"))) {
				found = true;
				break;
			}
		}

		// build a corresponding JSON for that data, if found
		JSONObject jo = null;
		if (found) {
			jo = new JSONObject();
			jo.put("type", type);
			jo.put("data", new JSONObject(data));
		}
		return jo;

	}

	private static void parseForceLawsOption(CommandLine line) throws ParseException {
		String fl = line.getOptionValue("fl", _forceLawsDefaultValue);
		_forceLawsInfo = parseWRTFactory(fl, _forceLawsFactory);
		if (_forceLawsInfo == null) {
			throw new ParseException("Invalid force laws: " + fl);
		}
	}

	private static void parseStateComparatorOption(CommandLine line) throws ParseException {
		String scmp = line.getOptionValue("cmp", _stateComparatorDefaultValue);
		_stateComparatorInfo = parseWRTFactory(scmp, _stateComparatorFactory);
		if (_stateComparatorInfo == null) {
			throw new ParseException("Invalid state comparator: " + scmp);
		}
	}

	private static void startBatchMode() throws Exception {
		
		//configuramos entrada y salida
		if (_inFile == null) {
			throw new ParseException("In batch mode an input file of bodies is required");
		}
		InputStream is = new FileInputStream(new File(_inFile));
		OutputStream os = outFile == null ?
				System.out : new FileOutputStream(new File(outFile));
	
		//creamos el simulador
		PhysicsSimulator simulator = new PhysicsSimulator(_dtime, _forceLawsFactory.createInstance(_forceLawsInfo));
		
		//configuramos si hay fichero de comparacion y el tipo de comparacion
		InputStream expOut = null;
		StateComparator cmp = null;
		
		//al hacer el parseStatecomparator, si no hay ninguno, se fija por defecto epsilon con 0.0 
		//Por tanto, si hay fichero de salida, pero no hay especificado comparador, se usa ese por defecto
		if(expOutFile != null)
		{
			expOut = new FileInputStream(new File(expOutFile));
			cmp = _stateComparatorFactory.createInstance(_stateComparatorInfo);
		}
		
		//creamos el controlador
		Controller controller = new Controller(simulator, _bodyFactory, _forceLawsFactory);
			
		//cargamos los cuerpos
		controller.loadBodies(is);
		//ejecutamos la simulacion. Puede generar excepcion (se capturaria en main)
		controller.run(steps, os, expOut, cmp);
	}
	
private static void startGUIMode() throws Exception {
		
		
	//creamos el simluador
	//nota. Al ser nlug la fuerza por defecto, si no se habia escrito ninguna se cargara esa en el modleo y en la interfaz grafica
		PhysicsSimulator simulator = new PhysicsSimulator(_dtime, _forceLawsFactory.createInstance(_forceLawsInfo));
		
		//creamos el controlador
		Controller controller = new Controller(simulator, _bodyFactory, _forceLawsFactory);
		
		//creamos la ventana
		MainWindow mw = new MainWindow(controller);
		
		mw.setBounds(500, 300, 600, 800);
		Dimension dimension = Toolkit.getDefaultToolkit().getScreenSize(); // para centrar la ventana 
	    int x = (int) ((dimension.getWidth() - mw.getWidth()) / 2);
	    int y = (int) ((dimension.getHeight() - mw.getHeight()) / 2);
	    mw.setLocation(x, y);
		mw.setVisible(true);
		
		//cargamos los cuerpos si se habia introducido la opcion
		if (_inFile != null) {
			InputStream is = new FileInputStream(new File(_inFile));
			controller.loadBodies(is);// puede lanzar excepcion. Se capturaria en main
		}

	}

	private static void start(String[] args) throws Exception {
		parseArgs(args);
		if(mode == CONSOLE_MODE)
			startBatchMode();
		else
			startGUIMode();
	}

	public static void main(String[] args) {
		try {
			init();
			start(args);
		} catch (Exception e) {
			System.err.println("Something went wrong ...");
			System.err.println();
			e.printStackTrace();
		}
	}
}
