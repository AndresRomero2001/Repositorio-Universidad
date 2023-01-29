package simulator.view;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;


import javax.swing.*;

import simulator.control.Controller;

public class MainWindow extends JFrame {
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	// Menu version
	Controller _ctrl;
	

	// componentes
	ControlPanel cp;
	BodiesTable panelBodiesTable;
	Viewer viewer;

	


	public MainWindow(Controller ctrl) {
		super("Physics Simulator");
		_ctrl = ctrl;
		this.initGUI();
	}

	private void initGUI() {

		JPanel mainPanel = new JPanel();
		mainPanel.setLayout(new BorderLayout());
		setContentPane(mainPanel);

//------Creamos la toolbar-----
		cp = new ControlPanel(_ctrl);
		mainPanel.add(cp, BorderLayout.PAGE_START);

//------Creamos panel central-----	
		JPanel centerElements = new JPanel();
		centerElements.setBackground(Color.white);
		centerElements.setLayout(new BoxLayout(centerElements, BoxLayout.Y_AXIS));

//------Creamos el panel de la tabla-----	
		panelBodiesTable = new BodiesTable(_ctrl);
		centerElements.add(panelBodiesTable);

//------Creamos viewer-----	
		viewer = new Viewer(_ctrl);
		centerElements.add(viewer);

		mainPanel.add(centerElements, BorderLayout.CENTER);

//------Creamos statusBar-----		
		StatusBar stB = new StatusBar(_ctrl);
		mainPanel.add(stB, BorderLayout.PAGE_END);

//------Ajustes ventana principal-----				
		this.setDefaultCloseOperation(JFrame.DO_NOTHING_ON_CLOSE);

		this.addWindowListener(new WindowListener() {

			@Override
			public void windowOpened(WindowEvent e) {
			}

			@Override
			public void windowClosing(WindowEvent e) {
				cp.exit();
			}

			@Override
			public void windowClosed(WindowEvent e) {
			}

			@Override
			public void windowIconified(WindowEvent e) {
			}

			@Override
			public void windowDeiconified(WindowEvent e) {
			}

			@Override
			public void windowActivated(WindowEvent e) {
			}

			@Override
			public void windowDeactivated(WindowEvent e) {
			}
		});


		this.setVisible(true);
		this.pack();
	}

	

}
