package GeometricShape;

public abstract class GeometricShape
{
    private static String color = "White";
    private static boolean filled = false;
    private static java.util.Date date = new java.util.Date();
    public GeometricShape() //0 args constructor
    {

    }
    public GeometricShape(String color, boolean filled) //2 args constructor
    {
        this.color = color;
        this.filled = filled;
    }

    public String getColor()
    {
        return this.color;
    }

    public void setColor(String color)
    {
        this.color = color;
    }

    public boolean isFilled()
    {
        return this.filled;
    }
    public java.util.Date getDate()
    {
        return this.date;
    }

    @Override
    public String toString()
    {
        String output = "created on " + getDate() + "\ncolor: " + getColor() + " and filled: " + isFilled();
        return output;
    }
}

