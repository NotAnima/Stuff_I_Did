package GeometricShape;

public class Circ extends Shape
{
    public Circ()
    {
        super();
    }
    public Circ(double radius, double useless)
    {
        super(radius,0);
    }
    public double area() //implemented area() method
    {
        System.out.println("Inside Area for Circle.");
        return super.PI*this.dim1*this.dim1;
    }
}
