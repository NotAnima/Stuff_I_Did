package GeometricShape;

public class Triangle extends Shape
{
    public Triangle()
    {
        super();
    }
    public Triangle(double dim1, double dim2)
    {
        super(dim1,dim2);
    }
    @Override
    public double area()
    {
        System.out.println("Inside Area for Triangle.");
        return 0.5*this.dim1*this.dim2;
    }
}
