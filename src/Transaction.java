import java.util.Date;

public class Transaction {
    private double amount;
    private Date timestamp;
    private String memo;
    private Account fromAccount, toAccount;

    public Transaction(double amount, Account fromAccount, Account toAccount){
        this.amount = amount;
        this.fromAccount = fromAccount;
        this.toAccount = toAccount;
        this.timestamp = new Date();
        this.memo = "";
    }    

    public Transaction(double amount, Account fromAccount, Account toAccount,String memo){
        this(amount,fromAccount,toAccount);
        this.memo = memo;
    }
}
