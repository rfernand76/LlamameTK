package gpchile.vadagu.server.exception;

public class VDGException extends Exception{
	private String msg = "";
	
	public VDGException(String msg, Exception e){
		this.msg = msg;
		this.initCause(e);
	}
	
	@Override
	public String getMessage(){
		return msg;
	}
	
	public VDGException(Exception e){
		this.initCause(e);
	}
}
