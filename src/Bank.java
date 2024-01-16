import java.util.ArrayList;
import java.util.Random;

public class Bank {
    private Integer bankID;
    private String bankName;
    private Integer bankPrefix;
    private String country;
    private ArrayList<Account> account;
    private ArrayList<Person> person;
    
    public Bank(Integer bankID, String bankName, String country, Integer bankPrefix){
        this.bankID = bankID; //Bank ID is 4 digit, manually identified when first instantiated
        this.bankName = bankName;
        this.country = country;
        this.bankPrefix = bankPrefix;
        this.account = new ArrayList<Account>();
        this.person = new ArrayList<Person>();
        System.out.println("New Bank created named "+bankName);
    }
    
    public void addAccount(Account account){
        this.account.add(account);
    }

    public String getNew6ID(){
        String id;
        Random rng = new Random();
        this.person = new ArrayList<Person>();
        int len = 6;
        boolean nonUnique = false;
        do {
            id = this.bankPrefix.toString();
            for(int c = 0;c<len;c++){
                id+=((Integer)rng.nextInt(10)).toString();
            }

            for(Person u: this.person){
                if(id.compareTo(u.getUserID().toString()) == 0){
                    nonUnique = true;
                    break;
                }
            }
            
        }while(nonUnique);

        return id;
    }
}
