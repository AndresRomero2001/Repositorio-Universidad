package simulator.view;

public class LawInfo {

	private String key;
	private String value;
	private String desc;

	public LawInfo(String k, String v, String d) {
		key = k;
		value = v;
		desc = d;
	}

	public String getKey() {
		return key;
	}

	public String getValue() {
		return value;
	}

	public String getDesc() {
		return desc;
	}

	public void setKey(String k) {
		key = k;
	}

	public void setValue(String v) {
		value = v;
	}

	public void setDesc(String d) {
		desc = d;
	}

}
