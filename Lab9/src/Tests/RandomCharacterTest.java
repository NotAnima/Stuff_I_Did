package Tests;

import org.junit.Assert;
import org.junit.jupiter.api.Test;

import static org.junit.jupiter.api.Assertions.*;
class RandomCharacterTest {

    @Test
    void getRandomLowerCaseLetter() {
        for (int i = 0; i < 1000; i++)
        {
            char c = RandomCharacter.getRandomLowerCaseLetter();
            Assert.assertTrue((c>='a'&& c<='z'));
        }
        System.out.println("Passed RandomLowerCase() test...");
    }

    @Test
    void getRandomUpperCaseLetter() {
        for (int i = 0; i < 1000; i++)
        {
            char c = RandomCharacter.getRandomUpperCaseLetter();
            Assert.assertTrue((c>='A'&& c<='Z'));
        }
        System.out.println("Passed RandomUpperCase() test...");
    }

    @Test
    void getRandomDigit() {
        for (int i = 0; i < 1000; i++)
        {
            char c = RandomCharacter.getRandomDigit();
            Assert.assertTrue((c>='0'&& c<='9'));
        }
        System.out.println("Passed RandomDigit() test...");
    }

    @Test
    void getRandomCharacter() {
        for (int i = 0; i < 1000; i++)
        {
            char c = RandomCharacter.getRandomCharacter();
            Assert.assertTrue((c>='a'&& c<='z') || (c>='A'&& c<='Z') || (c>='0'&& c<='9') );
        }
        System.out.println("Passed RandomCharacter() test...");
    }

    @Test
    void getRandomPrime() {
        for (int i = 0; i < 1000; i++)
        {
            int prime = RandomCharacter.getRandomPrime();
            Assert.assertTrue(RandomCharacter.isPrime(prime));
        }
        System.out.println("Passed RandomPrime() test...");
    }
}