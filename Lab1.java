/*
Question 1: I am using JDK SE 19.0.1

java --version in cmd:

java 19.0.1 2022-10-18
Java(TM) SE Runtime Environment (build 19.0.1+10-21)
Java HotSpot(TM) 64-Bit Server VM (build 19.0.1+10-21, mixed mode, sharing)
 */

//Question 2:
import java.util.*;
public class Lab1 {
    public static void main(String[] args)
    {
        //Question 2(a)
        String name = "";
        for (int i = 0; i<args.length;i++)
        {
            name += args[i];
            if (i+1 < args.length)
            {
                name += " ";
            }
        }
        System.out.println("Question 2(a):");
        System.out.format("Hello, I am %s!\n",name);
        module();
        loopy();
    }
    //Question 2(b)
    public static void module()
    {
        Scanner inputobj = new Scanner(System.in);
        System.out.print("Enter your module name: ");
        String check = inputobj.nextLine();
        System.out.println();
        System.out.println("Question 2(b)");
        switch(check)
        {
            case "CSC1109":
                System.out.println("Object-Oriented Programming");
                break;
            case "INF1006":
                System.out.println("Computer Networks");
                break;
            case "INF1004":
                System.out.println("Mathematics 2");
                break;
            case "CSC1108":
                System.out.println("Data Structures and Algorithms");
                break;
            default:
                System.out.println("Unknown module");
                break;
        }
        System.out.println("After switch");
        System.out.println();
        inputobj.close();
    }

    public static void loopy()
    {
        System.out.println("Question 2(c)");
        for(int x = 102; x>=66; x--)
        {
            if (x%2==1)
            {
                System.out.print(x + " ");
            }
        }
        System.out.println();
    }
}
