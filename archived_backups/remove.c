#include <stdio.h>

int main(void)
{
    //compile and run to remove the .txt file if want to cleanup
    const char *fileName = "Q2_Group_03.txt";
    int success = remove(fileName);
    return success;
}