package simulator.view;

import java.awt.Dimension;
import java.awt.Frame;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.util.List;

import javax.swing.*;

import simulator.control.Controller;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

public class ControlPanel extends JPanel
							implements SimulatorObserver {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Controller _ctrl;
	
	//componentes
	JButton fileChooserButton;
	JButton forceLawsButton;
	JButton playButton;
	JButton stopButton;
	JButton exitButton;
	JSpinner stepsSpinner;
	JTextField deltaTime;
	
	private boolean _stopped;
	
	ForceLawsDialog forceLawsDialog;
	JFileChooser fileChooser;
	
	public ControlPanel(Controller ctrl) {
		this._ctrl = ctrl;
		initGUI();
		_ctrl.addObserver(this);
	}
	 
	private void initGUI() {
		
	//this.setLayout((new FlowLayout(FlowLayout.LEFT)));//al poner este panel como flow, permite ponerle el alineamineto a la izq, y que no se
		//mueva la tooBar al hacer resize. Pero tampoco reescala para hacerse mas grande, por tanto se usa un Box para que reescale bien
		
		JToolBar toolBar = new JToolBar();
		
		this.setLayout(new BoxLayout(this, BoxLayout.X_AXIS));
		
		toolBar.setFloatable(false);
		
//------File Chooser Button		
		fileChooserButton = createFileChooserButton();
		toolBar.add(fileChooserButton);
		toolBar.addSeparator();
		
//------Force Laws Button				
		forceLawsButton = createForceLawsButton();
		toolBar.add(forceLawsButton);
		toolBar.addSeparator();
		
//------Play Button			
		playButton = createPlayButton();
		toolBar.add(playButton);
		
//------Stop Button			
		stopButton = createStopButton();
		toolBar.add(stopButton);	
		
//------Step Spinner	
		toolBar.add(Box.createRigidArea(new Dimension(5,0)));
		JLabel spinnerStepsText = new JLabel();
		spinnerStepsText.setText("Steps: ");
		stepsSpinner = createStepsSpinner();
		toolBar.add(spinnerStepsText);
		toolBar.add(stepsSpinner);
		
//------Delta time field	
		toolBar.add(Box.createRigidArea(new Dimension(5,0)));
		JLabel deltaTimeText = new JLabel();
		deltaTimeText.setText("Delta-Time: ");
		deltaTime = createDeltaTimeTexField();
		toolBar.add(deltaTimeText);
		toolBar.add(deltaTime);			
		
//-----Exit Button
		toolBar.add(Box.createGlue());//para pegar el boton a la dcha
		toolBar.addSeparator();
		
		exitButton = createExitButton();
		toolBar.add(exitButton);	
		
		this.add(toolBar);
		
	}
	
	private JButton createFileChooserButton()
	{
		JButton fileChooserButton = new JButton();
		fileChooserButton.setIcon(new ImageIcon("resources/icons/open.png"));
		fileChooserButton.addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				loadBodiesFile();
			}		
		});
		return fileChooserButton;
	}
	
	private JButton createForceLawsButton()
	{
		JButton forceLawsButton = new JButton();
		forceLawsButton.setIcon(new ImageIcon("resources/icons/physics.png"));
		
		forceLawsButton.addActionListener(new ActionListener()
			{
			@Override
			public void actionPerformed(ActionEvent e) {
				chooseForce();
			}

			});
		return forceLawsButton;
	}
	
	private JButton createPlayButton()
	{
		JButton playButton = new JButton();
		playButton.setIcon(new ImageIcon("resources/icons/run.png"));
		playButton.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {	
				play();
			}	
		});
		return playButton;
	}
	
	private JButton createStopButton()
	{
		JButton stopButton = new JButton();
		stopButton.setIcon(new ImageIcon("resources/icons/stop.png"));
		stopButton.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				stop();		
			}	
		});
		return stopButton;
	}
	
	private JButton createExitButton()
	{
		JButton exitButton = new JButton();
		exitButton.setIcon(new ImageIcon("resources/icons/exit.png"));
		exitButton.addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {	
				exit();
			}		
		});
		return exitButton;
	}
	
	private JTextField createDeltaTimeTexField()
	{
		JTextField deltaTime= new JTextField();
		
		
		deltaTime.setPreferredSize(new Dimension(70, 40));
		deltaTime.setMinimumSize(new Dimension(70, 40));
		deltaTime.setMaximumSize(new Dimension(200, 40));
		deltaTime.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				try {
				_ctrl.setDeltaTime(Double.parseDouble(deltaTime.getText()));
				}
				catch(Exception ex)
				{															//Necesario el ControlPanel.this, por estar la funcion en una clase anonima
					JOptionPane.showMessageDialog((Frame) SwingUtilities.getWindowAncestor(ControlPanel.this), ex.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
					//si se ha introducido un valor negativo, se setea automaticamente a uno para evitar funcionamientos incorrectos
					deltaTime.setText("1.0");
					_ctrl.setDeltaTime(Double.parseDouble(deltaTime.getText()));
				}
				
			}
		});
		return deltaTime;
	}
	
	private JSpinner createStepsSpinner()
	{
		JSpinner stepsSpinner = new JSpinner(new SpinnerNumberModel(10000, 1, 100000, 100 ));//value, min, max, step
		
		stepsSpinner.setPreferredSize(new Dimension(70, 40));
		stepsSpinner.setMinimumSize(new Dimension(70, 40));
		stepsSpinner.setMaximumSize(new Dimension(200, 40));
		
		return stepsSpinner;
	}
	
	
	public void setEnableButtons(Boolean enable)
	{
		fileChooserButton.setEnabled(enable);
		forceLawsButton.setEnabled(enable);
		playButton.setEnabled(enable);
		exitButton.setEnabled(enable);
	}

	public void setEnableTextFields(Boolean enable)
	{
		stepsSpinner.setEnabled(enable);
		deltaTime.setEnabled(enable);	
	}
	
	
	public int getSteps()
	{
		return Integer.parseInt(stepsSpinner.getValue().toString());
	}
	
	private void run_sim(int n) {// funcion recursiva. De forma que si cambia por pulsar un boton el valor de
		// _stopped, o porque se han ejecutado todos los pasos, no se hacen mas llamadas
		// recursivas
		if (n > 0 && !_stopped) {
			
			try {
				_ctrl.run(1);
			} catch (Exception e) {
				JOptionPane.showMessageDialog((Frame) SwingUtilities.getWindowAncestor(this), e.getMessage(), "Error",
				JOptionPane.ERROR_MESSAGE);
				
				_stopped = true;
				setEnableButtons(true);
				setEnableTextFields(true);
				return;
			}
			
			SwingUtilities.invokeLater(new Runnable() {
			@Override
			public void run() {
				run_sim(n - 1);
			}
			});
		}
		else {
			_stopped = true;
		
			// TODO enable all buttons
		
			setEnableButtons(true);
			setEnableTextFields(true);
		}
	}
	
	public void loadBodiesFile() {
		if (fileChooser == null)// Solo creamos el dialogo una vez
		{
			fileChooser = new JFileChooser();
			fileChooser.setCurrentDirectory(new File("resources/examples"));
		}
		
		int selection = fileChooser.showOpenDialog(null);
		
		if (selection == JFileChooser.APPROVE_OPTION) {
			File file = fileChooser.getSelectedFile();
			InputStream is;
			try {
				is = new FileInputStream(file);// puede generar excepcion de ruta no encontrada
				_ctrl.reset();
				_ctrl.loadBodies(is);// puede generar excepcion si ids iguales
			
			} catch (Exception e) {
				JOptionPane.showMessageDialog((Frame) SwingUtilities.getWindowAncestor(this), e.getMessage(), "Error",
				JOptionPane.ERROR_MESSAGE);
			}
		}
	
	}
	
	public void exit() {
		int option = JOptionPane.showConfirmDialog(null, "Do you want to to exit?");
		
		if (option == 0) {
			System.exit(0);
		}
	}
	
	public void chooseForce() {
		if (forceLawsDialog == null)// Solo creamos el dialogo una vez
		{
			// forceLawsDialog = new ForceLawsDialog( (Frame)
			// SwingUtilities.getWindowAncestor(this), _ctrl.getForceLawsInfo());
			//forceLawsDialog = new ForceLawsDialog(this, _ctrl.getForceLawsInfo());
			forceLawsDialog = new ForceLawsDialog((Frame) SwingUtilities.getWindowAncestor(this), _ctrl.getForceLawsInfo());
		}
		
		int status = forceLawsDialog.open();
		
		// 0 cancel
		if (status == 1)// ok
		{
			try {
				_ctrl.setForceLaws(forceLawsDialog.getSelectedForceAsJSON());
			} catch (Exception e) {
				JOptionPane.showMessageDialog((Frame) SwingUtilities.getWindowAncestor(this), e.getMessage(), "Error",
						JOptionPane.ERROR_MESSAGE);
			}
		}
		// -1 cerrar
	}
		
	public void stop() {
		_stopped = true;
		setEnableButtons(true);
		setEnableTextFields(true);
	}
	
	public void play() {
		_stopped = false;
		setEnableButtons(false);
		setEnableTextFields(false);
		
		run_sim(getSteps());
	}
	
	// SimulatorObserver methods
	// ...
	@Override
	public void onRegister(List<Body> bodies, double time, double dt, String fLawsDesc) {
		//el unico dato que muestra controlPane que cambia en el simulador es el delta time. De los bodies se encarga el modelo de la tabla, y de time y flawDesc el statusBar (ambos observadores) 
		deltaTime.setText(Double.toString(dt));	
	}
	@Override
	public void onReset(List<Body> bodies, double time, double dt, String fLawsDesc) {
		deltaTime.setText(Double.toString(dt));	
	}
	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {		
	}
	@Override
	public void onAdvance(List<Body> bodies, double time) {	
	}
	@Override
	public void onDeltaTimeChanged(double dt) {
		deltaTime.setText(Double.toString(dt));	
	}
	@Override
	public void onForceLawsChanged(String fLawsDesc) {
	}
}
