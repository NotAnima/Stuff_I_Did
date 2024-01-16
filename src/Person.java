import java.util.ArrayList;
import java.util.Random;

public class Person {
    private String userID;
    private String firstName;
    private String lastName;
    private ArrayList<Account> account;

    public Person(Integer userID, String firstName, String lastName){
        this.userID = this.getNew4ID(); //Need to random 4 digits
        this.firstName = firstName;
        this.lastName = lastName;
        this.account = new ArrayList<Account>();
        System.out.println("New person created named "+firstName);
    }

    public void addAccount(Account account) {
        this.account.add(account);
    }

    public String getUserID(){
        return this.userID;
    }

    public String getNew4ID(){
        String id;
        Random rng = new Random();
        int len = 4;
        id = "";
        for(int c = 0;c<len;c++){
            id+=((Integer)rng.nextInt(10)).toString();
        }
        return id;
    }
}
