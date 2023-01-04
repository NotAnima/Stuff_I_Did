import java.util.*;
import java.lang.*;
//practicing data sanitation, but it is not perfect :=
//(could not get the user to be forced with a float/double type input only)
//could not populate an empty String with .nextLine(); method for some reason <- request was not outputted
public class Lab2
{
    static double radius = 0.0;
    static final double pie = 3.14159;
    static Scanner inputObj = new Scanner(System.in);
    public static void main(String[] args)
    {
        System.out.println("Question_1:");
        q1();
        System.out.println("__________________________________________________________");
        System.out.println("\nQuestion_2:");
        q2();
        System.out.println("__________________________________________________________");
        System.out.println("\nQuestion_3:");
        q3();
        System.out.println("__________________________________________________________");
        System.out.println("\nQuestion_4:");
        q4();
        System.out.println("__________________________________________________________");
        inputObj.close();
    }

    public static void q1()
    {
        System.out.println("Enter a byte value");
        long byteValue = read_long();
        read_out_longs(byteValue);

        System.out.println("Enter a short value");
        long shortValue = read_long();
        read_out_longs(shortValue);

        System.out.println("Enter an int value");
        long intValue = read_long();
        read_out_longs(intValue);

        System.out.println("Enter a long value");
        long longValue = read_long();
        read_out_longs(longValue);

        System.out.println("Enter a float value");
        double floatValue = read_double();
        System.out.printf("The value is %.4f\n",floatValue);

        radius = read_radius();
        double area = pie*(Math.pow(radius,2.0));
        System.out.printf("\nThe area of the circle of radius %.5f is %.5f\n",radius, area);
    }

    public static void q2()
    {
        System.out.print("Enter first number\n");
        double first = read_double();
        System.out.println("\nEnter Second number\n");
        double second = read_double();
        System.out.println("\nEnter Third number\n");
        double third = read_double();
        double avrg = averager(first,second,third);
        System.out.printf("\nThe average of %.4f, %.4f and %.4f is: %.4f\n",first,second,third,avrg);
    }

    public static void q3()
    {
        //I know that the division truncates, but it's just for practice.
        long Current_time_in_ms = System.currentTimeMillis();
        long Current_time_in_s = Math.floorDiv(Current_time_in_ms,1000);
        long Current_secs = Current_time_in_s%60;
        long Total_mins = Math.floorDiv(Current_time_in_s,60);
        long Current_min = Total_mins%60;
        long Total_hrs = Math.floorDiv(Total_mins,60);
        long Current_hr = Total_hrs%24;
        System.out.printf("\nCurrent time is %d:%d:%d GMT\n",Current_hr,Current_min,Current_secs);

    }

    public static void q4()
    {
        System.out.println("Enter a positive year");
        long year = read_long();
        while (year<0)
        {
            year = read_long();
        }
        year = year%12;
        String[] animals = {"monkey", "rooster", "dog", "pig", "rat", "ox", "tiger", "rabbit", "dragon", "snake", "horse", "sheep"};
        System.out.println("It is the year of the "+animals[(int)year]+".");
    }
    public static double averager(double a, double b, double c)
    {
        double sum = a + b + c;
        return sum/3;
    }

    public static void read_out_longs(long x)
    {
        System.out.printf("\nThe value is: %d\n",x);
        System.out.println();
    }
    public static long read_long()
    {
        System.out.print("Please enter a correct value: ");
        while (!inputObj.hasNextLong())
        {
            System.out.println("\nAn error occurred, please try again\n");
            System.out.print("Please enter a correct value: ");
            inputObj.next();
        }
        long longVal = inputObj.nextLong();
        return longVal;
    }
    public static double read_double()
    {
        System.out.print("Please enter a correct value: ");
        while (!inputObj.hasNextDouble())
        {
            System.out.println("\nAn error occurred, please try again\n");
            System.out.print("Please enter a correct value: ");
            inputObj.next();
        }
        double doubleVal = inputObj.nextDouble();
        return doubleVal;
    }
    public static double read_radius()
    {
        System.out.print("Please enter the radius of the circle: ");
        while (!inputObj.hasNextDouble())
        {
            System.out.println("\nAn error occurred, please try again\n");
            System.out.print("Please enter the radius of the circle: ");
            inputObj.next();
        }
        double radi = inputObj.nextDouble();
        return radi;
    }
}
