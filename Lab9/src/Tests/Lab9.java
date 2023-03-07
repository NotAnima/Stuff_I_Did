package Tests;

import java.util.*;

public class Lab9 {
    public static void main(String[] args) {
        q1();
        System.out.println("_____________________________________");
        q2();
    }

    public static void q1()
    {
        int numberOfTimes = 15;
        int i =0;
        for (i = 0; i<numberOfTimes; i++)
        {
            System.out.print(RandomCharacter.getRandomLowerCaseLetter()+ " ");
        }
        System.out.println();
        for (i = 0; i<numberOfTimes; i++)
        {
            System.out.print(RandomCharacter.getRandomUpperCaseLetter()+ " ");
        }
        System.out.println();
        for (i = 0; i<numberOfTimes; i++)
        {
            System.out.print(RandomCharacter.getRandomDigit()+ " ");
        }
        System.out.println();
        for (i = 0; i<numberOfTimes; i++)
        {
            System.out.print(RandomCharacter.getRandomCharacter()+ " ");
        }
        System.out.println();
        System.out.println("______________________________________________________");
        System.out.println("Testing portion of the question");
    }
    public static void q2()
    {
        int numberOfTimes = 15;
        int i =0;
        for (i = 0; i<numberOfTimes; i++)
        {
            System.out.print(RandomCharacter.getRandomPrime()+ " ");
        }
        System.out.println();
        System.out.println("Testing portion of the question");
        System.out.println("_____________________________________");
        System.out.println("_____________________________________");
    }
}

class RandomCharacter
{
    public static char getRandomLowerCaseLetter()
    {
        Random randy = new Random();
        int number = randy.nextInt(26);
        char letter = (char)(number + 'a');
        return letter;
    }
    public static char getRandomUpperCaseLetter()
    {
        Random randy = new Random();
        int number = randy.nextInt(26);
        char letter = (char)(number + 'A');
        return letter;
    }

    public static char getRandomDigit()
    {
        Random randy = new Random();
        int number = randy.nextInt(10);
        return (char)(number+'0');
    }
    public static char getRandomCharacter()
    {
        Random randy = new Random();
        int number = randy.nextInt(3);
        if (number==1)
        {
            return getRandomLowerCaseLetter();
        }
        else if(number ==2)
        {
            return getRandomUpperCaseLetter();
        }
        else
        {
            return getRandomDigit();
        }
    }
    public static int getRandomPrime()
    {
        boolean isValid = false;
        int number = 0;
        Random randy = new Random();
        while (!isValid)
        {
            number = Math.abs(randy.nextInt());
            isValid = isPrime(number);
        }
        return number;
    }
    public static boolean isPrime(int num)
    {
        if (num == 2)
        {
            return true;
        }
        if (num%2==0)
        {
            return false;
        }
        int factor = (int)Math.sqrt(num) +1;
        for (int i = 3; i<factor;i+=2)
        {
            if (num % i==0)
            {
                return false;
            }
        }
        return true;
    }
}
