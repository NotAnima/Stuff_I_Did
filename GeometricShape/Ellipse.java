package GeometricShape;

public class Ellipse extends Shape
{
    public Ellipse()
    {
        super();
    }
    public Ellipse(double dim1, double dim2)
    {
        super(dim1,dim2);
    }
    public double area()
    {
        System.out.println("Inside Area for Ellipse.");
        return this.PI*this.dim1*this.dim2;
    }
}
