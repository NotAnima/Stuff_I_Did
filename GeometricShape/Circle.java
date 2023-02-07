package GeometricShape;

public class Circle extends GeometricShape {
    double radius = 0;

    public Circle() {
        super();
    }

    public Circle(double radius) {
        super();
        this.radius = radius;
    }

    public Circle(double radius, String color, boolean filled) {
        super(color, filled);
        this.radius = radius;
    }
    public double getRadius()
    {
        return this.radius;
    }
    public double getDiameter()
    {
        return 2*this.radius;
    }

    public void setRadius(double radius) {
        this.radius = radius;
    }

    public double getArea() {
        return (Math.PI * Math.pow(this.radius, 2));
    }

    public double getPerimeter() {
        return (Math.PI * 2 * this.radius);
    }

    public void printCircle() {
        super.toString();
    }
}
