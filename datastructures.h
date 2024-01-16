#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>

#define BUFFER_SIZE 1024

#ifndef datastructures

#define datastructures

typedef struct node{

    int pid;
    int arrivalTime; //0-8 int r = rand() % 9
    int burstTime; //3-10 int r = rand() % 8 + 3 // will produce 0-7 then + 3
    int priority; //1-4 int r = rand() % 4 + 1 //will produce 0-3 then + 1

    int originalPriority;
    int timeSlice;
    int timeLeft;
    int active; //0 or 1 for boolean
    int respondedFlag;
    int justServiced;

    int waitingTime;
    int turnAroundTime;
    int responseTime;
    
    struct node* nextPtr; //control block pointers
    struct node* prevPtr;

}node;

typedef struct ganttStruct{

    int timeBlock;
    int pid;

}ganttStruct;

typedef struct linkerHead{

    node* head;
    node* tail;

}linkerHead;

typedef struct winner{

    int schedulingType; //0 for FCFS, 1 for SJF, 2 for SRTF, 3 for RR, 4 for Priority
    float averageTurnAroundTime;
    float averageWaitingTime;
    float averageResponseTime;

}winner;

//link list creation helpers
node* generateNode(int pidToAssign);
void generateNoGaps(node *jobQueue[]);
void generateNoGapsPriority(node* jobQueue[]);

void insertAtHead(node* Node, linkerHead* addressHead);
void placeJobs(node* jobQueue[], linkerHead* head, int size);

void placeArrivedJobs(node* jobQueue[], node* readyArray[], int elapsedTime);

int handleCheck(node *jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);
int runCheck(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);

int handleCheckPriority(node *jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);
int runPriorityCheck(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);

//link list deletion helpers
int countArraySize(node* jobQueue[], int size);

//sorting function prototypes
void sortForFCFS(node* jobQueue[], int size);
void sortForSJF(node* jobQueue[], int size);
void sortForSRTF(node* jobQueue[], int size);
void sortForPriority(node* jobQueue[], int size);

//merge sort functions
void mergeByTimeLeft(node* arr[], node* left[], int leftSize, node* right[], int rightSize);
void mergeByBurst(node* arr[], node* left[], int leftSize, node* right[], int rightSize);
void mergeByArrival(node* arr[], node* left[], int leftSize, node* right[], int rightSize);
void mergeByPriority(node* arr[], node* left[], int leftSize, node* right[], int rightSize);
void mergeByPid(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

void mergeSortByTimeLeft(node* arr[], int size);
void mergeSortByBurst(node* arr[], int size);
void mergeSortByArrival(node* arr[], int size);
void mergeSortByPriority(node* arr[], int size);
void mergeSortByPid(node* arr[], int size);


//other helper functions
void makeJobs(node* jobQueue[], int* validJobs, int* emergencyBreak);
void makeJobsForFCFS(node* jobQueue[], int* validJobs, int* emergencyBreak);
void makeJobsForSJF(node* jobQueue[], int* validJobs, int* emergencyBreak, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);
void makeJobsForPriority(node* jobQueue[], int* validJobs, int* emergencyBreak, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);

int allAreEmpty(node* readyArray[], int size);

void send_to_file(char message[]);
int get_choice();
int getPreempChoice();

//validity checking
int checkValidity(node* jobQueue[]);
int checkForGap(node* jobQueue[], int size);
void normalizeData(node* jobQueue[]);
int isAscending(node* jobQueue[], int choice);

//memory management helpers
void destroyJobQueue(node* jobQueue[]);
void destroyGanttArray(ganttStruct* ganttOrder[]);
void resetProcesses(node* jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[]);

//writer helpers
void getNodeProperties(node* Node);
void writeOutAverageTimes(char *schedulingType, int totalTurnAroundTime, float totalWaitingTime, float totalResponseTime, winner* winnerArray[], node* readyArray[]);
void calculateAverageTimes(node* readyQueue[], char schedulingType[], winner *winnerArray[]);
void appendToBuffer(char* buffer, const char* str);
int countGanttSize(ganttStruct* jobQueue[], int size);
int getGanttBlocks(ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[], char schedulingType[]);
void insertIntoGanttOrder(node* currentProcess, ganttStruct* ganttOrder[], int currentlyElapsedTime);
void insertGanttBlock(ganttStruct* ganttBlocks[], ganttStruct* ganttBlockToInsert);
int samePid(ganttStruct* previousGanttAddress, ganttStruct* currentGanttAddress);
void writeGanttChart(ganttStruct* ganttBlocks[], char schedulingType[]);

void drawTable(node* jobQueue[]);

//determine winner
void freeWinnerArray(winner *array[]);
void addToWinnerArray(winner *winnerArray[], char *schedulingType, node* readyArray[], float averageTurnAroundTime, float averageWaitingTime, float averageResponseTime);
void didIWin(winner *winnerArray[], int choice);

#endif