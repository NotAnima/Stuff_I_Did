package GeometricShape;

public class Rect extends Shape
{
    public Rect()
    {
        super();
    }
    public Rect(double dim1, double dim2)
    {
        super(dim1,dim2);
    }
    @Override
    public double area()
    {
        System.out.println("Inside Area for Rectangle.");
        return this.dim1*this.dim2;
    }
}
