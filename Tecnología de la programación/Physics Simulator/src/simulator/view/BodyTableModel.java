package simulator.view;

import java.util.ArrayList;
import java.util.List;

import javax.swing.table.AbstractTableModel;

import simulator.control.Controller;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

public class BodyTableModel extends AbstractTableModel implements SimulatorObserver {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	List<Body> bodyList;// Usaremos un arrayList de bodies para almacenar la informacion de la tabla
	String[] columnNames = { "Id", "Mass", "Position", "Velocity", "Force" };

	public BodyTableModel(Controller ctrl) {
		bodyList = new ArrayList<Body>();
		ctrl.addObserver(this);
	}

	@Override
	public boolean isCellEditable(int rowIndex, int columnIndex) {
		return false;
	}

	@Override
	public String getColumnName(int col) {
		return columnNames[col];
	}

	@Override
	public int getRowCount() {
		return bodyList.size();
	}

	@Override
	public int getColumnCount() {
		return columnNames.length;
	}

	@Override
	public Object getValueAt(int rowIndex, int columnIndex) {
		Body b = bodyList.get(rowIndex);
		Object o;

		switch (columnIndex) {
		case 0: {
			o = b.getId();
			break;
		}
		case 1: {
			o = b.getMass();
			break;
		}
		case 2: {
			o = b.getPosition();
			break;
		}
		case 3: {
			o = b.getVelocity();
			break;
		}
		default: {
			o = b.getForce();
			break;
		}

		}

		return o;
	}

	@Override
	public void onRegister(List<Body> bodies, double time, double dt, String fLawsDesc) {
		updateData(bodies);
	}

	@Override
	public void onReset(List<Body> bodies, double time, double dt, String fLawsDesc) {
		updateData(bodies);
	}

	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {
		updateData(bodies);
	}

	@Override
	public void onAdvance(List<Body> bodies, double time) {
		updateData(bodies);
	}

	@Override
	public void onDeltaTimeChanged(double dt) {
	}

	@Override
	public void onForceLawsChanged(String fLawsDesc) {
	}

	private void updateData(List<Body> bodies) {
		this.bodyList = bodies;
		// fireTableDataChanged();
		fireTableStructureChanged();// ya que puede cambiar el numero de filas
	}

}
