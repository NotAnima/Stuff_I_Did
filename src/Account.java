import java.util.ArrayList;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Account {
    private String accountID;
    private Bank bankID;
    private Person userID;
    private byte pinHash[];
    private Integer trfLimit;
    private Integer withdrawalLimit;
    private Integer overseasLimit;
    private Integer balance;
    private ArrayList<Transaction> transactions;

    public Account(String pin, Bank bankID, Person userID){
        this.accountID = bankID.getNew6ID(); //Generate ID
        bankID.addAccount(this);
        userID.addAccount(this);
        this.trfLimit = 1000;
        this.withdrawalLimit = 1000;
        this.overseasLimit = 1000;
        this.balance = 0;
        this.transactions = new ArrayList<Transaction>();
        try{
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            this.pinHash = md.digest(pin.getBytes());
            System.out.println("New account created with ID "+accountID);
        }
        catch(NoSuchAlgorithmException e){
            System.err.println("error, caught NoSuchAlogirthmException");
            e.printStackTrace();
            System.exit(1);
        }
    }

    public boolean validatePin(String aPin){
        try{
            MessageDigest md = MessageDigest.getInstance("MD5");
            return MessageDigest.isEqual(md.digest(aPin.getBytes()), this.pinHash);
        }
        catch (NoSuchAlgorithmException e ){
            System.err.println("error, caught NoSuchAlogirthmException");
            e.printStackTrace();
            System.exit(1);
        }
        return false;
    }

    public boolean changePIN(String aPin){
        try{
            MessageDigest md = MessageDigest.getInstance("MD5");
            if (MessageDigest.isEqual(md.digest(aPin.getBytes()), this.pinHash)){
                this.pinHash = md.digest(aPin.getBytes());
            }
        }
        catch (NoSuchAlgorithmException e ){
            System.err.println("error, caught NoSuchAlogirthmException");
            e.printStackTrace();
            System.exit(1);
        }
        return false;
    }

    public void changeTrfLimit(Integer newLimit){
        this.trfLimit = newLimit;
    }
    
    public void changeWithdrawalLimit(Integer newLimit){
        this.withdrawalLimit = newLimit;
    }

    public void changeOverseasLimit(Integer newLimit){
        this.overseasLimit = newLimit;
    }
    
    public void addTransaction(double amount, Account fromAccount, Account toAccount, String memo){
        Transaction newTrans = new Transaction(amount, fromAccount, toAccount,memo);
        this.transactions.add(newTrans);
    }
}
