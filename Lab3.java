import loanpack.*;
import java.util.*;
public class Lab3
{
    static Scanner inputObj = new Scanner(System.in);
    public static void main(String[] args)
    {
        System.out.printf("\nEnter annual interest rate, for example, 8.25: ");
        double annualRate = read_double();
        System.out.printf("\nEnter number of years an an integer: ");
        double years = read_double(); //truncates
        System.out.printf("\nEnter loan amount, for example, 120000.95: ");
        double loanAmt = read_double();
        System.out.println();
        loanpack instantiate = new loanpack(annualRate, loanAmt, (int)years);
        instantiate.getLoanDate();
        double monthlyPayment = instantiate.getMonthlyPayment();
        System.out.printf("The monthly payment is %.2f", monthlyPayment);
        instantiate.TotalPayment();
        System.out.println();
        inputObj.close();
    }

    public static double read_double()
    {
        double output = 0.0;
        boolean valid = false;
        while(!valid)
            try
            {
                output = inputObj.nextDouble();
                valid = true;
            }
            catch (InputMismatchException e)
            {
                System.out.print("Input mismatch, try again.\t\t   ");
                inputObj.nextLine(); //discards the invalid input
            }
        return output;
    }
}

