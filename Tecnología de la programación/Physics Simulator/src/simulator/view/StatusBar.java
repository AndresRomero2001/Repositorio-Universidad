package simulator.view;

import java.awt.Dimension;
import java.awt.FlowLayout;
import java.util.List;

import javax.swing.BorderFactory;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JSeparator;
import javax.swing.SwingConstants;

import simulator.control.Controller;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

public class StatusBar extends JPanel implements SimulatorObserver {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	// ...
	private JLabel _currTime; // for current time
	private JLabel _currLaws; // for gravity laws
	private JLabel _numOfBodies; // for number of bodies

	String DEFAULT_TIME_TEXT = "Time:";
	String DEFAULT_BODIES_TEXT = "Bodies:";
	String DEFAULT_LAWS_TEXT = "Laws:";

	StatusBar(Controller ctrl) {
		initGUI();
		ctrl.addObserver(this);
	}

	private void initGUI() {
		this.setLayout(new FlowLayout(FlowLayout.LEFT));// FLow para el alineamiento a la izq
//		this.setLayout( new BoxLayout( this, BoxLayout.X_AXIS ));
		this.setAlignmentX(LEFT_ALIGNMENT);
		this.setBorder(BorderFactory.createBevelBorder(1));

		_currTime = new JLabel(DEFAULT_TIME_TEXT);
		_numOfBodies = new JLabel(DEFAULT_BODIES_TEXT);
		_currLaws = new JLabel(DEFAULT_LAWS_TEXT);

		_currTime.setPreferredSize(new Dimension(100, 15));
		_currTime.setMaximumSize(new Dimension(100, 15));
		_currTime.setMinimumSize(new Dimension(100, 15));

		this.add(_currTime);
		JSeparator sep1 = new JSeparator(SwingConstants.VERTICAL);
		sep1.setPreferredSize(new Dimension(5, 15));// necesario preferredSize del separator, porque el por defecto que
													// le pone el flowLayout es tan pequenio que no se ve
		this.add(sep1);

		_numOfBodies.setPreferredSize(new Dimension(70, 15));
		_numOfBodies.setMaximumSize(new Dimension(70, 15));
		_numOfBodies.setMinimumSize(new Dimension(70, 15));

		this.add(_numOfBodies);
		JSeparator sep2 = new JSeparator(SwingConstants.VERTICAL);
		sep2.setPreferredSize(new Dimension(5, 15));
		this.add(sep2);

		_currLaws.setPreferredSize(new Dimension(370, 15));
		_currLaws.setMaximumSize(new Dimension(370, 15));
		_currLaws.setMinimumSize(new Dimension(370, 15));

		this.add(_currLaws);

	}

	// other private/protected methods
	// ...
	// SimulatorObserver methods
	// ...
	@Override
	public void onRegister(List<Body> bodies, double time, double dt, String fLawsDesc) {
		updateInfo(bodies, time, fLawsDesc);

	}

	@Override
	public void onReset(List<Body> bodies, double time, double dt, String fLawsDesc) {
		updateInfo(bodies, time, fLawsDesc);
	}

	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {
		_numOfBodies.setText(DEFAULT_BODIES_TEXT + " " + bodies.size());
	}

	@Override
	public void onAdvance(List<Body> bodies, double time) {
		_currTime.setText(DEFAULT_TIME_TEXT + " " + time);
	}

	@Override
	public void onDeltaTimeChanged(double dt) {
	}

	@Override
	public void onForceLawsChanged(String fLawsDesc) {
		_currLaws.setText(DEFAULT_LAWS_TEXT + " " + fLawsDesc);
	}

	private void updateInfo(List<Body> bodies, double time, String fLawsDesc) {
		_currTime.setText(DEFAULT_TIME_TEXT + " " + time);
		_numOfBodies.setText(DEFAULT_BODIES_TEXT + " " + bodies.size());
		_currLaws.setText(DEFAULT_LAWS_TEXT + " " + fLawsDesc);
	}

}
