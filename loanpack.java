package loanpack;
import java.util.*;
import java.lang.*;
public class loanpack {
    double annualInterestRate = 2.5, loanAmount = 1000;
    int numberOfYears = 1; //numbers of years for the loan, defaulted to 1;
    java.util.Date loanDate = new java.util.Date();
    public loanpack()
    {   //constructor

    }
    public loanpack(double packAnnualInterestRate, double packLoanAmount, int packNumYears)
    {   //constructor
        this.annualInterestRate = packAnnualInterestRate;
        this.loanAmount = packLoanAmount;
        this.numberOfYears = packNumYears;
    }

    public void getAnnualInterestRate() //not public static void because "statics" cant create an instance of a class, but can be called by using the class.methodname();
    {
        System.out.format("\nThe annual interest rate for this loan is: %.4f.\n",this.annualInterestRate);
    }
    public void getNumberOfYears()
    {
        System.out.printf("\nThe number of years this loan has is: %d.\n",numberOfYears);
    }

    public void getLoanAmount()
    {
        System.out.printf("\nThe loan amount is %.3f.\n",this.loanAmount);
    }
    public void getLoanDate()
    {
        System.out.println("The loan was created on "+this.loanDate);
    }

    public void setAnnualInterestRate(double annualInterestRate)
    {
        this.annualInterestRate = annualInterestRate;
    }
    public void setNumberOfYears(int numberOfYears)
    {
        this.numberOfYears = numberOfYears;
    }
    public void setLoanAmount(double loanAmount)
    {
        this.loanAmount = loanAmount;
    }
    public double getMonthlyPayment()
    {
        double monthlyPayment = (loanAmount*(annualInterestRate/1200))/(1-(1/(Math.pow(1+(annualInterestRate/1200),numberOfYears*12))));
        return monthlyPayment;
    }
    public void TotalPayment()
    {
        double monthlyPayment = this.getMonthlyPayment();
        double totalPayment = monthlyPayment*numberOfYears*12;
        System.out.printf("\nThe total payment is: %.2f.\n",totalPayment);
    }

}
