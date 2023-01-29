package simulator.view;

import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.Frame;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;
import java.util.List;

import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.TableColumnModel;

import org.json.JSONObject;

public class ForceLawsDialog extends JDialog {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	private int status;
	List<JSONObject> forceLawsList;
	// tabla
	JTable table;
	ForceTableModel forceTableModel;
	// comboBox
	JComboBox<String> comboBox;
	String forceOptions[];

	public ForceLawsDialog(Frame parent, List<JSONObject> forceLawsList) {
		super(parent, true);
		this.forceLawsList = forceLawsList;
		initGUI();
	}

	private void initGUI() {
		status = 0;
		this.setTitle("Force Laws Selection");

		JPanel mainPanel = new JPanel();
		mainPanel.setLayout(new BoxLayout(mainPanel, BoxLayout.Y_AXIS));
		setContentPane(mainPanel);

//-----Creamos la etiqueta de la info del dialogo
		JLabel help = new JLabel(
				"<html><p>Select a force law and provide values for the parametes in the <b>Value column</b> (default values are used for parametes with no value).</p></html>");
		help.setAlignmentX(CENTER_ALIGNMENT); // sin esto sale pegado a la derecha
		mainPanel.add(help);

		mainPanel.add(Box.createRigidArea(new Dimension(0, 10)));

//------Creamos el modelo y la tabla-----
		forceTableModel = new ForceTableModel();
		forceTableModel.updateTable(forceLawsList.get(0).getJSONObject("data"));
		table = new JTable(forceTableModel);
		JScrollPane sp = new JScrollPane(table);
		sp.setPreferredSize(new Dimension(530, 100));

		mainPanel.add(sp);
		// ajustes de la tabla
		table.setFillsViewportHeight(true);
		table.setShowGrid(false);// no mostrar recuadros de las casillas
		table.getTableHeader().setReorderingAllowed(false);
		table.getTableHeader().setDefaultRenderer(new DefaultTableCellRenderer());

		// solo funciona una vez
		setTableColumnSize();

//------Creamos comboBox con su panel-----
		// metemos las descripciones de las fuerzas de nuestro simulador, como opciones
		// del comboBox
		JPanel comboPanel = new JPanel(new FlowLayout());
		comboBox = new JComboBox<String>();
		for (JSONObject lawInfo : forceLawsList) {
			comboBox.addItem(lawInfo.getString("desc"));
		}

		comboBox.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				// actualizamos la informacion de la tabla cambiando la ley que muestra
				// le pasamos por parametro el JSONObject "data" de la fuerza seleccionada en el
				// comboBox (esta se corresponde con la posicion del array de info de fuerzas,
				// que es el mismo que el indice seleccionado del comboBox )
				forceTableModel.updateTable(forceLawsList.get(comboBox.getSelectedIndex()).getJSONObject("data"));
				setTableColumnSize();// necesario volver a establecerlo
			}
		});

		comboPanel.add(new JLabel("Force Law: "));
		comboPanel.add(comboBox);

		mainPanel.add(comboPanel);
		mainPanel.add(Box.createRigidArea(new Dimension(0, 10)));

		mainPanel.add(Box.createRigidArea(new Dimension(0, 10)));
//------Creamos botones-----

		JPanel buttonsPanel = new JPanel();
		buttonsPanel.setAlignmentX(CENTER_ALIGNMENT);

		mainPanel.add(buttonsPanel);

		JButton cancelButton = new JButton("Cancel");
		cancelButton.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				status = 0;
				ForceLawsDialog.this.setVisible(false);
			}
		});
		buttonsPanel.add(cancelButton);

		JButton okButton = new JButton("OK");
		okButton.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				status = 1;
				ForceLawsDialog.this.setVisible(false);
			}
		});
		buttonsPanel.add(okButton);

		this.addWindowListener(new WindowListener() {

			@Override
			public void windowOpened(WindowEvent e) {
			}

			@Override
			public void windowClosing(WindowEvent e) {
				status = -1;// cerrado por pulsar el aspa
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

		this.setPreferredSize(new Dimension(570, 350));
		this.setMaximumSize(new Dimension(570, 350));
		this.setMinimumSize(new Dimension(570, 350));
		setVisible(false); // we will show it only when open is called

	}

	private void setTableColumnSize() {
		TableColumnModel columnModel = table.getColumnModel();
		columnModel.getColumn(0).setPreferredWidth(50);
		columnModel.getColumn(0).setMaxWidth(50);
		columnModel.getColumn(1).setPreferredWidth(50);
		columnModel.getColumn(1).setMaxWidth(50);
		columnModel.getColumn(2).setPreferredWidth(200);
	}

	public int open() {

		if (getParent() != null)
			setLocation(getParent().getLocation().x + getParent().getWidth() / 2 - getWidth() / 2,
					getParent().getLocation().y + getParent().getHeight() / 2 - getHeight() / 2);

		setVisible(true);
		return status;
	}

	public JSONObject getSelectedForceAsJSON() {

		JSONObject force = new JSONObject();

		JSONObject data = forceTableModel.getDataAsJSON();// cogemos la informacion de la ley seleccionada en el
															// comboBox (la actual del modelo) como un JSONOBject

		// La fuerza puede estar seleccionada tanto en el comboBox como en el List, pero
		// en ambos se tienen siempre los mismos indices actaulizados como s epued ever
		// en sus listener
		// por tanto aqui en el getSelectedIndex se puede usar tanto el comboBox como la
		// List ya que tendran el mismo indice seleccionado
		force.put("type", forceLawsList.get(comboBox.getSelectedIndex()).get("type"));// ponemos en la clave type, el
																						// campo type de la fuerza
																						// seleccionada en el comboBox
		force.put("data", data);

		return force;
	}

}
