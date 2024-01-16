#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>

#ifndef workingData

#define workingData

typedef struct node{

    int pid;
    int arrivalTime; //0-8 int r = rand() % 9
    int burstTime; //3-10 int r = rand() % 8 + 3 // will produce 0-7 then + 3
    int priority; //1-4 int r = rand() % 4 + 1 //will produce 0-3 then + 1

    //not a perfect way to get the random integer, because the project brief says only a few of them can have the same
    //it's RNG at this point, idk how to introduce a stopping guideline without making it mega convaluted and unnecessary at a certain point
    int originalPriority;
    int timeSlice;
    int timeLeft;
    int active; //0 or 1 for boolean

    int waitingTime;
    int turnAroundTime;
    int responseTime;
    
    struct node* nextPtr; //control block pointers
    struct node* prevPtr;

}node;

typedef struct linkerHead{

    node* head;
    node* tail;

}linkerHead;

//link list creation helpers
node* generateNode(int pidToAssign);
void insertAtHead(node* Node, linkerHead* addressHead);
void placeJobs(node* jobQueue[], linkerHead* head, int size);
void generateSolidNodes(node* jobQueue[]);
void placeArrivedJobs(node* jobQueue[], node* readyArray[], int elapsedTime);
void removeDoneJobs(node* readyArray[]);

int getListSize(linkerHead* head);

//misc link list helpers
node* getTailAddress(linkerHead* head);
void removeAtTail(linkerHead* addressHead);
void pointPreviousAtTail(linkerHead* addressHead);

//link list deletion helpers
int removeNodeByAddress(linkerHead* addressOfLinkHead, node *addressToFree);
int removeFinishedNodes(linkerHead* addressOfLinkHead);

int countArraySize(node* jobQueue[], int size);

//sorting function prototypes
void sortForFCFS(node* jobQueue[], int size);
void sortForSJF(node* jobQueue[], int size);

void mergeSortByTimeLeft(node* arr[], int size);
void mergeByTimeLeft(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

void mergeSortByBurst(node* arr[], int size);
void mergeByBurst(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

void mergeSortByArrival(node* arr[], int size);
void mergeByArrival(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

void mergeSortByPriority(node* arr[], int size);
void mergeByPriority(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

void mergeSortByPid(node* arr[], int size);
void mergeByPid(node* arr[], node* left[], int leftSize, node* right[], int rightSize);

//other helper functions
void makeJobs(node* jobQueue[], int* validJobs, int* emergencyBreak);
void printAtTail(linkerHead *head);

void send_to_file(char message[]);
int get_choice();

//validity checking
int checkValidity(node* jobQueue[]);
int checkForGap(node* jobQueue[], int size);
void normalizeData(node* jobQueue[]);
void printArray(int arr[]);
void printNodesOrder(node* arr[], int size);

//memory management helpers
void destroyJobQueue(node* jobQueue[]);
void resetProcesses(node* jobQueue[], int size);

//writer helpers
void getNodeProperties(node* Node);
void writeOutAverageTimes(char schedulingType[], int totalTurnAroundTime, float totalWaitingTime, float totalResponseTime);

#endif