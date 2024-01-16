import java.sql.*;

public class AccountData {
    String accountNo, pin, balAmt, userID, trfLimit, overseasLimit, accountType, firstName, lastName, NRIC;

    public void AccountData(){
        this.accountNo = "";
        this.pin = "";
        this.balAmt = "";
        this.userID = "";
        this.trfLimit = "";
        this.overseasLimit = "";
        this.accountType = "";
        this.firstName = "";
        this.lastName = "";
        this.NRIC = "";
    }

    public static void main(String[] args) {
        try {
            // Load the JDBC driver
            Class.forName("com.mysql.jdbc.Driver");

            // Establish a connection
            Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/mydb", "root", "");

            // Create a statement
            Statement statement = connection.createStatement();

            // Execute a query
            ResultSet accountSet = statement.executeQuery("SELECT * FROM mydb.accounts");


            // Process the results
            while (accountSet.next()) {
                AccountData ldObj = new AccountData();
                ldObj.accountNo = accountSet.getString("AccountNo");
                ldObj.pin = accountSet.getString("PIN");
                ldObj.balAmt = accountSet.getString("balAmt");
                ldObj.userID = accountSet.getString("UserID");
                ldObj.trfLimit = accountSet.getString("trfLimit");
                ldObj.overseasLimit = accountSet.getString("overseasLimit");
                ldObj.accountType = accountSet.getString("accountType");
                ldObj.firstName = accountSet.getString("firstName");
                ldObj.lastName = accountSet.getString("lastName");
                ldObj.NRIC = accountSet.getString("NRIC");
                System.out.println("Account No: " + ldObj.accountNo + ", PIN: " + ldObj.pin + ", balAmt: " + ldObj.balAmt + ", userID: " + ldObj.userID +
                        ", trfLimit: " + ldObj.trfLimit + ", overseasLimit: " + ldObj.overseasLimit + ", accountType: " + ldObj.accountType + ", firstName: " + ldObj.firstName +
                        ", lastName: " + ldObj.lastName + ", NRIC: " + ldObj.NRIC);
            }

            // Close the connection
            connection.close();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
