public class ATM {
 public static void main(String[] args) {
    Bank newBank = new Bank(1234, "UOB", "Singapore", 401);
    Person newPerson = new Person(5678,"Kovi","Tan");
    Account newAccount = new Account("4321", newBank, newPerson);
 }   
}
