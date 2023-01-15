import java.util.*;
import java.lang.*;
public class Lab4
{
    static Scanner inputObj = new Scanner(System.in);
    final static double poundToKg = 0.45359237;
    final static double inchTom = 0.0254;
    public static void main(String[] args)
    {
        q1();
        q2();
        inputObj.close();
    }
    public static void q1()
    {
        System.out.print("\nEnter weight in pounds: ");
        double weight = read_double()* poundToKg;
        System.out.print("Enter height in inches: ");
        double height = read_double()* inchTom;
        double BMI = BMI(height,weight);
        System.out.printf("BMI is %.4f\n",BMI);
        String BMI_range = BMIRange(BMI);
        System.out.println(BMI_range+"\n");
    }
    public static void q2()
    {
        integerStack stacker = new integerStack();
        for (int i =0; i<10; i++)
        {
            stacker.push(i);
        }
        while(!stacker.isEmpty())
        {
            System.out.print(stacker.pop() + " ");
        }
        System.out.println();
    }
    public static double BMI(double height, double weight)
    {
        double BMI_val = weight/(Math.pow(height,2));
        return BMI_val;
    }
    public static String BMIRange(double BMI_val)
    {
        if (BMI_val<18.5)
        {
            return "Underweight";
        }
        else if(BMI_val>=18.5 && BMI_val < 25.0)
        {
            return "Normal";
        }
        else if(BMI_val>=25.0 && BMI_val < 30.0)
        {
            return "Overweight";
        }
        else
        {
            return "Obese";
        }
    }
    public static double read_double()
    {
        double value;

        while (!inputObj.hasNextDouble())
        {
            System.out.println("Input a value: ");
            inputObj.next();
        }
        value = inputObj.nextDouble();
        return value;
    }
}

class integerStack
{
    static int top = -1;
    static int[] data_array = new int[0];
    //class constructor
    public integerStack()
    {
        this.top = top;
        this.data_array = data_array;
    }
    public void push(int data)
    {
        this.data_array = append(data, this.data_array);
        this.top += 1;
    }
    public int pop()
    {
        int was_data = this.data_array[this.top];
        this.data_array = delTop(this.data_array);
        this.top -= 1;
        return was_data;
    }
    public int peek()
    {
        int top_val = this.data_array[this.top];
        return top_val;
    }
    public boolean isEmpty()
    {
        if (this.top == -1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public int[] append(int data, int[] array)
    {
        int size = array.length;
        int[] new_array = new int[size + 1];
        int i = 0;
        for (i = 0; i<size;i++)
        {
            new_array[i] = array[i];
        }
        new_array[i] = data;
        return new_array;
    }
    public int[] delTop(int[] array)
    {
        int size = array.length;
        int[] new_array = new int[size-1];
        int i = 0;
        for (i = 0; i<size-1;i++)
        {
            new_array[i] = array[i];
        }
        return new_array;
    }
}
