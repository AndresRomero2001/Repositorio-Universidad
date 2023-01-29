package simulator.view;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;

import javax.swing.BorderFactory;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.border.TitledBorder;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.JTableHeader;

import simulator.control.Controller;

public class BodiesTable extends JPanel {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	JTable bodyInfoTable;
	BodyTableModel tableModel;

	public BodiesTable(Controller ctrl) {

		setLayout(new BorderLayout());
		setBorder(BorderFactory.createTitledBorder(BorderFactory.createLineBorder(Color.black, 2), "Bodies",
				TitledBorder.LEFT, TitledBorder.TOP));

		tableModel = new BodyTableModel(ctrl);
		bodyInfoTable = new JTable(tableModel);// tabla de bodies

		bodyInfoTable.setFillsViewportHeight(true);// espacio en blanco desde ultima fila hasta el final de la tabla
		bodyInfoTable.setShowGrid(false);// no mostrar recuadros de las casillas
		bodyInfoTable.getTableHeader().setReorderingAllowed(false);// no permitir mover las columnas

		// apariencia de la fila con los titulos de las columnas
		DefaultTableCellRenderer tcr = new DefaultTableCellRenderer();
		JTableHeader header = bodyInfoTable.getTableHeader();
		header.setDefaultRenderer(tcr);

		JScrollPane sp = new JScrollPane(bodyInfoTable, JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED,
				JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);

		// sp.setPreferredSize(new Dimension(700, 200));
		// sp.setMaximumSize(new Dimension(2000, 1000));
		this.add(sp);
		this.setPreferredSize(new Dimension(700, 200));
		this.setMaximumSize(new Dimension(2000, 1000));
		tableModel.fireTableStructureChanged();
	}

}
