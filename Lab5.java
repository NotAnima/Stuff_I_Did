import GeometricShape.*;
public class Lab5
{
    public static void main(String[] args)
    {
        q1();
        System.out.println("\n");
        q2();
    }
    public static void q1()
    {
        Circle circle = new Circle(1);
        System.out.println("A circle "+ circle.toString());
        System.out.println("The color is "+ circle.getColor());
        System.out.println("The radius is "+ circle.getRadius());
        System.out.println("The radius is "+ circle.getArea());
        System.out.println("The diameter is "+ circle.getDiameter());
        Rectangle rectangle = new Rectangle(2,4);
        System.out.println("\nA rectangle "+ rectangle.toString());
        System.out.println("The area is "+ rectangle.getArea());
        System.out.println("The perimeter is "+ rectangle.getPerimeter());
    }

    public static void q2()
    {
        Rect r = new Rect(9,5);
        Triangle t = new Triangle(10,8);
        Circ c = new Circ(5,5);
        Ellipse e = new Ellipse(7,7);
        Square s = new Square(6,6);
        Shape figref;
        figref = r;
        System.out.println("Area is "+ figref.area());
        figref = t;
        System.out.println("Area is "+ figref.area());
        figref = c;
        System.out.println("Area is "+ figref.area());
        figref = e;
        System.out.println("Area is "+ figref.area());
        figref = s;
        System.out.println("Area is "+ figref.area());
    }

}

