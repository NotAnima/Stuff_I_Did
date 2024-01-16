import java.sql.*;

public class BankData {
  int id;
  String accountNo, date, tDetails, chqNo, valDate, withdrawAmt, depositAmt, balAmt;

  public void BankData(){
    this.id = -1;
    this.accountNo = "";
    this.date = "";
    this.tDetails = "";
    this.chqNo = "";
    this.valDate = "";
    this.withdrawAmt = "";
    this.depositAmt = "";
    this.balAmt = "";
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
      ResultSet bankdataSet = statement.executeQuery("SELECT * FROM mydb.bankdata");

      // Process the results
      while (bankdataSet.next()) {
        BankData ldObj = new BankData();
        ldObj.id = bankdataSet.getInt("TransactionID");
        ldObj.accountNo = bankdataSet.getString("AccountNo");
        ldObj.date = bankdataSet.getString("Date");
        ldObj.tDetails = bankdataSet.getString("TransactDetails");
        ldObj.chqNo = bankdataSet.getString("ChqNo");
        ldObj.valDate = bankdataSet.getString("ValDate");
        ldObj.withdrawAmt = bankdataSet.getString("WithdrawAmt");
        ldObj.depositAmt = bankdataSet.getString("DepositAmt");
        ldObj.balAmt = bankdataSet.getString("BalAmt");
        System.out.println("id: " + ldObj.id + ", account: " + ldObj.accountNo + ", date: " + ldObj.date + ", transactDetails: " + ldObj.tDetails + 
        ", chqNo: " + ldObj.chqNo + ", valDate: " + ldObj.valDate + ", withdrawAmt: " + ldObj.withdrawAmt + ", depositAmt: " + ldObj.depositAmt + 
        ", balAmt: " + ldObj.balAmt);
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
