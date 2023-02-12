import java.util.*;
public class Lab6 {
    static Scanner inputObj = new Scanner(System.in);
    public static void main(String[] args) {
        q1();
        q2();
        q3();
        q4();
        q5();
        q6();
        inputObj.close();
    }

    public static void q1()
    {
        System.out.println("Q1");
        ArrayList<Integer> IntegerList = new ArrayList<>(Arrays.asList(1,3,5,7,9,11));
        LinkedList<Integer> link = new LinkedList<>(IntegerList);
        System.out.println("Before addSorted: ");
        System.out.println(link);
        System.out.println("Input the number you want to add: ");
        int num = read();
        addSorted(link, num);
        System.out.println("After addSorted: ");
        System.out.println(link);
        System.out.println("_______________________________");
    }
    public static void q2()
    {
        System.out.println("Q2");
        ArrayList<Integer> IntegerList = new ArrayList<>(Arrays.asList(1,3,5,7,9,11));
        LinkedList<Integer> link = new LinkedList<>(IntegerList);
        System.out.println("Before swap: ");
        System.out.println(link);
        swap(link, 1, 5);
        System.out.println("After swap: ");
        System.out.println(link);
        System.out.println("_______________________________");
    }
    public static void q3()
    {
        System.out.println("Q3");
        Random rand = new Random();
        int numberOf = 500;
        LinkedList<Integer> link = new LinkedList<>();
        for (int i = 0; i<numberOf;i++)
        {
            Integer randy = rand.nextInt(1000,9999);
            link.add(randy);
        }
        System.out.println("input your number choice: ");
        Integer number = read();
        System.out.println(contains(link,number));
        System.out.println("_______________________________");
    }
    public static void q4()
    {
        System.out.println("Q4");
        System.out.println("_______________________________");
        ArrayList<Integer> IntegerList = new ArrayList<>(Arrays.asList(1,3,5,7,9,11));
        Set<Integer> set = new LinkedHashSet<>(IntegerList);
        //or do no args constructor and do
        //set.addAll(IntegerList);
        System.out.println("Input the number you want to add: ");
        int num = read();
        System.out.println("Before addSorted: ");
        System.out.println(set);
        addSorted(set, num);
        System.out.println("After addSorted: ");
        System.out.println(set);
        System.out.println("_______________________________");
        //not a good idea to do it in a HashSet, should just do a TreeSet to maintain ascending order of the elements.

    }
    public static void q5()
    {
        System.out.println("Q5");
        ArrayList<Integer> IntegerList = new ArrayList<>(Arrays.asList(1,3,5,7,9,11));
        Set<Integer> set = new LinkedHashSet<>(IntegerList);
        System.out.println("Before swap: ");
        System.out.println(set);
        swap(set, 1, 5);
        System.out.println("After swap: ");
        System.out.println(set);
        System.out.println("_______________________________");
        //It's a bad idea. It's only good if we
        //do not care about the order of the elements afterwards. Had to convert the LinkedHashSet into a List.
        //and then iterate through which is O(n), and then .add() and .remove() which is O(1). Resulting in O(n+m)
        //whereas, if we did not care about order-post, all operations would be O(1).
    }
    public static void q6()
    {
        System.out.println("Q6");
        Random rand = new Random();
        int numberOf = 500;
        Set<Integer> set = new HashSet<>();
        for (int i = 0; i<numberOf;i++)
        {
            Integer randy = rand.nextInt(1000,9999);
            set.add(randy);
        }
        System.out.println("input your number choice: ");
        Integer number = read();
        System.out.println(contains(set,number));
        System.out.println("_______________________________");
        //Yes, very good idea to use a HashSet to find if something is contained in a set. Very fast operations O(1)
        //saves memory space because sets do not allow for duplicate elements.
    }
    public static void addSorted(Collection<Integer> collection, int num)
    {
        if (collection instanceof LinkedList)
        {
            LinkedList<Integer> localList = (LinkedList<Integer>)collection;
            int size  = localList.size();
            int index_closest = 0;
            Iterator<Integer> iter = localList.iterator();
            for (int i = 0; i<size; i++)
            {
                int next = (int) iter.next();
                if (num<next)
                {
                    index_closest = i;
                    break;
                }
            }
            if (index_closest > 0)
            {
                localList.add(index_closest,num);
            }
            else
            {
                localList.addFirst(num);
            }
            collection = localList;
        }
        else if(collection instanceof Set<Integer>)
        {
            Set<Integer> localSet = new TreeSet<>(collection); //for ordered Set
            localSet.add(num);
            collection.clear();
            collection.addAll(localSet);
        }
    }
    public static void swap(Collection<Integer> collection, int spot1, int spot2)
    {
        if (spot1>spot2)
        {
            int temp = spot1;
            spot1 = spot2;
            spot2 = temp;
        }
        if (collection instanceof LinkedList<Integer>)
        {
            LinkedList<Integer> locaList = (LinkedList<Integer>) collection;
            int size = locaList.size()-1;
            Iterator<Integer> iter = locaList.iterator();
            Integer first = 0;
            Integer second = 0;
            for (int i =0; i<=size;i++)
            {
                Integer next = iter.next();
                if (i == spot1)
                {
                    first = next;
                }
                if(i == spot2)
                {
                    second = next;
                }
            } //get the values at spot1 and spot2
            Integer temp = first;
            locaList.add(spot1,second);
            locaList.remove(spot1+1);
            locaList.add(spot2,first);
            locaList.remove(spot2+1);
        }
        else if(collection instanceof LinkedHashSet<Integer>)
        {
            ArrayList<Integer> localList = new ArrayList<>(collection);
            int size = localList.size()-1;
            Iterator<Integer> iter = localList.iterator();
            Integer first = 0;
            Integer second = 0;
            for (int i =0; i<=size;i++)
            {
                Integer next = iter.next();
                if (i == spot1)
                {
                    first = next;
                }
                if(i == spot2)
                {
                    second = next;
                }
            } //get the values at spot1 and spot2
            Integer temp = first;
            localList.add(spot1,second);
            localList.remove(spot1+1);
            localList.add(spot2,first);
            localList.remove(spot2+1);
            collection.clear();
            collection.addAll(localList);
        }
    }
    public static boolean contains(Collection<Integer> collection, Integer num)
    {
        if (collection instanceof LinkedList)
        {
            LinkedList<Integer> list = (LinkedList<Integer>)collection;
            Iterator<Integer> iter = list.iterator();
            int size = list.size();
            for (int i = 0; i<size; i++)
            {
                Integer next = iter.next();
                if (next.equals(num))
                {
                    return true;
                }
            }
            return false;
            //alternatively can pass in an int num, and do if(next==num) int num autoboxes to Integer, then == unboxes Integer to int to compare iff Integer = int
        }
        else if(collection instanceof Set<Integer>)
        {
            Set<Integer> localSet = (HashSet<Integer>)collection;
            return localSet.contains(num);
        }
        return false;
    }
    public static Integer read()
    {
        Integer val;
        System.out.println("Reading Integer: ");
        while (!inputObj.hasNextInt())
        {
            System.out.println("Reading Integer: ");
            inputObj.next();
        }
        val = inputObj.nextInt();
        return val;
    }
}
