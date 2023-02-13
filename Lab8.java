import java.util.*;
public class Lab8 {
    static Scanner inputObj = new Scanner(System.in);
    public static void main(String[] args)
    {
        q1();
        q2();
        inputObj.close();
    }
    public static void q1()
    {
        CircleWithException C1 = new CircleWithException();
        CircleWithException C2 = new CircleWithException();
        CircleWithException C3 = new CircleWithException();
        System.out.println("");
        System.out.println("What is the radius of Circle 1: ");
        double rad1 = read();
        System.out.println("What is the radius of Circle 2: ");
        double rad2 = read();
        System.out.println("What is the radius of Circle 3: ");
        double rad3 = read();
        System.out.println("");
        try
        {
            try
            {
                C1.setRadius((rad1));
            }
            catch (IllegalArgumentException ile)
            {
                System.out.println("Unable to set radius of C1. IllegalArgument Exception is raised");
            }

            try
            {
                C2.setRadius((rad2));
            }
            catch (IllegalArgumentException ile)
            {
                System.out.println("Unable to set radius of C2. IllegalArgument Exception is raised");
            }

            try
            {
                C3.setRadius((rad3));
            }
            catch (IllegalArgumentException ile)
            {
                System.out.println("Unable to set radius of C3. IllegalArgument Exception is raised");
            }
        }
        catch (IllegalArgumentException ile)
        {
            System.out.println("IllegalArgumentException is raised!");
        }
        finally
        {
            System.out.println("Finally Block: Exited setting phase, any illegal sets are set to radius 1...");
        }

        System.out.println("______________________________________");

        try
        {
            try
            {
                double a1 = C1.getArea();
                System.out.println("Area of C1 is "+a1);
            }
            catch (Exception e)
            {
                System.out.println("The area of the C1 is above 1000...");
                System.out.println("General Exception is raised!");
            }
            try
            {
                double a2 = C2.getArea();
                System.out.println("Area of C2 is "+a2);
            }
            catch (Exception e)
            {
                System.out.println("The area of the C2 is above 1000...");
                System.out.println("General Exception is raised!");
            }
            try
            {
                double a3 = C3.getArea();
                System.out.println("Area of C3 is "+a3);
            }
            catch (Exception e)
            {
                System.out.println("The area of the C3 is above 1000...");
                System.out.println("General Exception is raised!");
            }
        }
        catch (Exception e)
        {
            System.out.println("General exception is raised!");
        }
        finally
        {
            System.out.println("Finally Block: Exited getArea() phase...");
        }
        System.out.println("");
    }
    public static void q2()
    {
        System.out.println("");
        System.out.println("___________________________________");
        CheckingAccount acc1 = new CheckingAccount(1234567);
        System.out.println("How much would you like to deposit?: ");
        double deposit = read();
        acc1.deposit(deposit);
        System.out.println("How much would you like to withdraw?");
        double w1 = read();
        acc1.withdraw(w1);
        System.out.println("How much would you like to withdraw?");
        double w2 = read();
        acc1.withdraw(w2);
        System.out.println("End of BankDemoTest");
    }
    public static double read()
    {
        double val;
        while(!inputObj.hasNextDouble())
        {
            inputObj.next();
        }
        val = inputObj.nextDouble();
        return val;
    }
}

class CircleWithException
{
    double radius = 1;
    public CircleWithException()
    {

    }
    public void setRadius(double rad) throws RuntimeException {
        if (rad<=0)
        {
            throw new IllegalArgumentException("Illegal argument exception is received");
        }
        this.radius = rad;
        System.out.println("Successfully set radius of circle to be "+rad);
    }
    public double getRadius()
    {
        return this.radius;
    }
    public double getArea() throws Exception
    {
        double area = this.radius*this.radius*Math.PI;
        if (area>1000)
        {
            throw new Exception("General Exception is received");
        }
        return area;
    }
    public double getDiameter()
    {
        return 2*this.radius*Math.PI;
    }

}

class CheckingAccount
{
    long accountNumber;
    double Balance = 0;
    public CheckingAccount(long accountNumber)
    {
        this.accountNumber = accountNumber;
    }
    public void withdraw(double draw) throws insufficientFundsException
    {
        try
        {
            if (draw > this.Balance)
            {
                throw new insufficientFundsException(draw);
            }
            this.Balance -= draw;
            System.out.println("The balance after withdraw is: "+this.Balance);
        }
        catch (insufficientFundsException ife)
        {
            System.out.println("Sorry, but your account is short by: $"+ (draw-this.Balance));
        }
    }
    public void deposit(double depos) throws IllegalArgumentException
    {
        try
        {
            this.Balance += depos;
        }
        catch (IllegalArgumentException ile)
        {
            System.out.println("Input is incorrect: " +depos);
        }
    }

    public double getBalance()
    {
        return this.Balance;
    }
    public long getNumber()
    {
        return this.accountNumber;
    }

}

class insufficientFundsException extends RuntimeException
{
    double Amount;
    public insufficientFundsException()
    {
        //no args constructor
    }
    public insufficientFundsException(double Amount)
    {
        this.Amount = Amount;
    }
    public double getAmount()
    {
        return this.Amount;
    }
}
