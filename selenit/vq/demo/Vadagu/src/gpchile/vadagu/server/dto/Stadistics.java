package gpchile.vadagu.server.dto;

import java.io.Serializable;

public class Stadistics implements Serializable{
	private long lastActivity = 0;
	
	public long getLastActivity() {
		return lastActivity;
	}

	public void setLastActivity(long lastActivity) {
		this.lastActivity = lastActivity;
	}
}
