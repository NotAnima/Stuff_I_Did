package GeometricShape;

public class Square extends Shape
{
    public Square()
    {
        super();
    }
    public Square(double dim1, double dim2)
    {
        super(dim1,dim2);
    }
    public double area()
    {
        System.out.println("Inside Area for Square.");
        return this.dim1*this.dim2;
    }
}