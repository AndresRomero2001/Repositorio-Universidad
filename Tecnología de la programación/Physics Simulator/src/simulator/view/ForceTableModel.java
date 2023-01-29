package simulator.view;

import java.util.ArrayList;

import javax.swing.table.AbstractTableModel;

import org.json.JSONObject;

public class ForceTableModel extends AbstractTableModel {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String[] columns = { "Key", "Value", "Description" };
	private ArrayList<LawInfo> rows;
	// guardaremos la informacion como una lista de LawInfo (clase con los valores
	// key, value y desc)

	public ForceTableModel() {
		rows = new ArrayList<LawInfo>();
	}

	public void updateTable(JSONObject data) {
		rows.clear();

		for (String key : data.keySet()) {
			rows.add(new LawInfo(key, "", data.getString(key)));
		}
		// fireTableDataChanged(); Al poder cambiar el numero de filas necesario el otro
		// fire, ya que daria problemas al seleccionar una fila, cambiar de ley, y que
		// esa nueva no tenga esa fila
		fireTableStructureChanged();
	}

	public JSONObject getDataAsJSON() {

		StringBuilder s = new StringBuilder();
		s.append('{');

		for (LawInfo lawData : rows) {
			if (!lawData.getValue().equals("")) {
				s.append('"');
				s.append(lawData.getKey());
				s.append('"');
				s.append(':');
				s.append(lawData.getValue());
				s.append(',');
			}

		}
		if (s.length() > 1)
			s.deleteCharAt(s.length() - 1);
		s.append('}');

		JSONObject data = new JSONObject(s.toString());

		return data;
	}

	@Override
	public String getColumnName(int col) {
		return columns[col];
	}

	@Override
	public int getRowCount() {
		return rows.size();
	}

	@Override
	public int getColumnCount() {
		return columns.length;
	}

	@Override
	public boolean isCellEditable(int row, int col) {
		return col == 1;
	}

	@Override
	public Object getValueAt(int rowIndex, int columnIndex) {
		LawInfo selectRow = rows.get(rowIndex);

		String s = "";

		switch (columnIndex) {
		case 0: {
			s = selectRow.getKey();
			break;
		}
		case 1: {
			s = selectRow.getValue();
			break;
		}
		case 2: {
			s = selectRow.getDesc();
			break;
		}

		}

		return s;
	}

	@Override
	public void setValueAt(Object value, int row, int col) {
		LawInfo selectRow = rows.get(row);
		selectRow.setValue(value.toString());
	}

}
