#include <stdio.h>
#include <time.h>


void main()
{
    time_t t = time(NULL);
    struct tm tm = *localtime(&t);
    printf("\nIt is %d:%d:%d on %d %d %d now.\n", tm.tm_hour, tm.tm_min, tm.tm_sec, tm.tm_mday, tm.tm_mon, tm.tm_year);
}